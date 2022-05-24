<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\GenerateExcelRequest;
use App\Http\Resources\DetailNumberInUseResource;
use App\Models\LetterNumber;
use App\Models\Sector;
use App\Models\NumberInUse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Worksheet\MemoryDrawing;

class ReportController extends Controller
{

    public function exportExcel(GenerateExcelRequest $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $date_start = date('Y-m-d', strtotime($request->input('date_start')));
        $date_end = date('Y-m-d', strtotime($request->input('date_end')));
        $preview = $request->input('preview');
        // dump($preview);
        $numberInUse = NumberInUse::select("number_in_use.*", "letter_numbers.regarding", "letter_numbers.type", "letter_numbers.sector_id")
                                  ->with('surat')
                                  ->leftJoin('letter_numbers', function($join)
                                  {
                                    //   $join->on('letter_numbers.numbers_date', '=', 'number_in_use.date_use');
                                      $join->on('start_at', '<=', 'number');
                                      $join->on('end_in', '>=', 'number');
                                  });
        $today = Carbon::now();
        $beforetoday = Carbon::now()->subYears(5);
        // dump('end '.$end);
        // dump('start '.$beforetoday->toDateString());
        // dump($today->toDateString());
        // dump($date_start == "1970-01-01");
        // dump('date_start '.$date_start);
        // dump('date_end '.$date_end);
        $sector = Sector::select('*')->get();
        $sector = $sector->keyBy('id');

        if ($start) {
            $numberInUse = $numberInUse->where('number_in_use.number', '>=', $start);
        }

        if ($end) {
            $numberInUse = $numberInUse->where('number_in_use.number', '<=', $end);
        }

        if ($date_start == "1970-01-01") {
            $numberInUse = $numberInUse->whereDate('number_in_use.date_use', '>=', $beforetoday->toDateString());
            // dump('1');
        }elseif ($date_start) {
            $numberInUse = $numberInUse->whereDate('number_in_use.date_use', '>=', $date_start);
            // dump('2');
        }

        if ($date_end == "1970-01-01") {
            $numberInUse = $numberInUse->whereDate('number_in_use.date_use', '<=', $today->toDateString());
            // dump('10');
        }elseif ($date_end) {
            $numberInUse = $numberInUse->whereDate('number_in_use.date_use', '<=', $date_end);
            // dump('20');
        }

        $numberInUse = $numberInUse->orderBy('number_in_use.number', 'ASC')->get();

        $numberInUse = DetailNumberInUseResource::collection($numberInUse)->resolve();
        // dump($numberInUse);
        if ($preview == 1){
            $this->generatePreview($numberInUse, $sector);
        } else {
            $this->generateExcel($numberInUse, $sector);
        }
    }

    public function generateExcel($data, $sector){
        $user = auth()->user();

        $spreadsheet = new Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        $spreadsheet->getProperties()->setCreator($user->username.' - Penomoran Surat')
        ->setLastModifiedBy($user->username.' - Penomoran Surat')
        ->setTitle('Report Penomoran Surat')
        ->setSubject('Report Penomoran Surat')
        ->setDescription('Report Penomoran Surat')
        ->setKeywords('office 2007 openxml php')
        ->setCategory('Report Penomoran Surat');

        $spreadsheet->getActiveSheet()->getStyle('A1:H1')->getAlignment()->setHorizontal('center')->setVertical('center');
        $spreadsheet->getActiveSheet()->setCellValue('A1', 'No');
        $spreadsheet->getActiveSheet()->setCellValue('B1', 'No Surat');
        $spreadsheet->getActiveSheet()->setCellValue('C1', 'Tanggal Surat');
        $spreadsheet->getActiveSheet()->setCellValue('D1', 'Tanggal Penomoran');
        $spreadsheet->getActiveSheet()->setCellValue('E1', 'Perihal');
        $spreadsheet->getActiveSheet()->setCellValue('F1', 'User Create Bidang');
        $spreadsheet->getActiveSheet()->setCellValue('G1', 'Tipe');
        $spreadsheet->getActiveSheet()->setCellValue('H1', 'Unit Kerja');

        $i=2; $nomor=1;
        // dump($data);
        foreach($data as $val) {
            $spreadsheet->setActiveSheetIndex(0)
            ->setCellValue('A'.$i, $nomor)
            ->setCellValue('B'.$i, str_pad($val['number'], 2, '0', STR_PAD_LEFT),)
            ->setCellValue('C'.$i, $val['surat']['tanggal'])
            ->setCellValue('D'.$i, $val['date_number'])
            // ->setCellValue('E'.$i, ($val['regarding']) ? $val['regarding'] : $val['surat']['judul'])
            ->setCellValue('E'.$i, (isset($val['regarding']) ? $val['regarding'] : isset($val['surat']['judul'])) ? $val['surat']['judul'] : (isset($val['judul']) ? $val['judul'] : '-'))
            ->setCellValue('F'.$i, $val['surat']['pengirim']['nama'])
            ->setCellValue('G'.$i, ($val['type'] == 1 || $val['type'] == null) ? "Dinas" : "Unit Kerja");

            if ($val['type'] == 1) {
                // $spreadsheet->setActiveSheetIndex(0)
                // ->setCellValue('H'.$i, '-');
                $unitKerja = '  -';
                if (
                    isset($val['surat']) &&
                    isset($val['surat']['pengirim']['pgw_unit_id']) && 
                    isset($sector[$val['surat']['pengirim']['pgw_unit_id']]['name']) && 
                    $val['surat']['pengirim']['pgw_unit_id'] != null
                ) {
                    $unitKerja = $sector[$val['surat']['pengirim']['pgw_unit_id']]['name']; 
                }
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('H' . $i, $unitKerja);
            } elseif ($val['type'] == 2) {
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('H'.$i, $sector[$val['sector_id']]['name']);
            } else {
                $unitKerja = '  -';
                if (
                    isset($val['surat']) &&
                    isset($val['surat']['pengirim']['pgw_unit_id']) && 
                    isset($sector[$val['surat']['pengirim']['pgw_unit_id']]['name']) && 
                    $val['surat']['pengirim']['pgw_unit_id'] != null
                ) {
                    $unitKerja = $sector[$val['surat']['pengirim']['pgw_unit_id']]['name']; 
                }
                $spreadsheet->setActiveSheetIndex(0)
                ->setCellValue('H' . $i, $unitKerja);
            }
            $i++; $nomor++;
        }
        $k=$i-1;
        $spreadsheet->getActiveSheet()->getStyle('A1:A'.$k)->getAlignment()->setHorizontal('center');
        $spreadsheet->getActiveSheet()->getStyle('A1:H'.$k)->applyFromArray([
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                ]
            ]
        ]);
        $spreadsheet->getActiveSheet()->getStyle('A1:H1')->applyFromArray([
            'font' => [
                'bold' => true,
            ]
        ]);

        for($col = 'A'; $col !== 'I'; $col++) {
            $spreadsheet->getActiveSheet()
            ->getColumnDimension($col)
            ->setAutoSize(true);
        }

        $spreadsheet->getActiveSheet()->setTitle('Report Penomoran Surat');
        $spreadsheet->setActiveSheetIndex(0);

        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="report_penomoran_surat_'.date('Y-m-d h:i').'.xlsx"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
        $writer->save('php://output');
    }

    public function generatePreview($data, $sector){
        // dump('123456');
        $nomor=1;

        $dataPenomoran = [];
        foreach($data as $val) {
            $unitKerja = '  -';
            if ($val['type'] == 1) {
                if (
                    isset($val['surat']) &&
                    isset($val['surat']['pengirim']['pgw_unit_id']['name']) && 
                    $val['surat']['pengirim']['pgw_unit_id'] != null) 
                {
                    $unitKerja = $sector[$val['surat']['pengirim']['pgw_unit_id']]['name'];
                }
            } elseif ($val['type'] == 2) {
                $unitKerja = $sector[$val['sector_id']]['name'];
            } else {
                if(
                    isset($val['surat']) &&
                    isset($val['surat']['pengirim']['pgw_unit_id']) && 
                    isset($sector[$val['surat']['pengirim']['pgw_unit_id']]['name']) && 
                    $val['surat']['pengirim']['pgw_unit_id'] != null
                ) {
                    $unitKerja = $sector[$val['surat']['pengirim']['pgw_unit_id']]['name'];
                }
            }

            $dataPenomoran[] = [
                'nomor' => $nomor,
                'no_surat' => str_pad($val['number'], 2, '0', STR_PAD_LEFT),
                'tanggal' => $val['surat']['tanggal'],
                'date_number' => $val['date_number'],
                'regarding' => ($val['regarding'])? $val['regarding']: $val['surat']['judul'],
                'pengirim' => $val['surat']['pengirim']['nama'],
                'tipe' => ($val['type'] == 1 || $val['type'] == null) ? "Dinas" : "Unit Kerja",
                'unit_kerja' => $unitKerja,
            ];

            $nomor++;
        }

        $data['penomoran'] = $dataPenomoran;
        echo view('pages.table', $data);
    }
}
