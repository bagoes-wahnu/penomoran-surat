<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LetterNumberStoreRequest;
use App\Http\Requests\DetailNumberRequest;
use App\Http\Resources\LetterNumberResource;
use App\Http\Resources\DetailNumberInUseResource;
use App\Models\LetterNumber;
use App\Models\NumberInUse;
use Carbon\Carbon;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

use function PHPUnit\Framework\isEmpty;

class LetterNumberController extends Controller
{

    public function index(Request $request)
    {
        // $model = LetterNumber::query();
        $sector_id = $request->sector_id;

        $model = LetterNumber::select()->with('sector');
        if($sector_id){
            $model->whereIn('sector_id',$sector_id);
        }

        return DataTables::eloquent($model)
        ->setTransformer(function($item){
            return [
                'id' => $item->id,
                'numbers_date'   => date('d-m-Y', strtotime($item->numbers_date)),
                'start_at'      => $item->start_at,
                'end_in'        => $item->end_in,
                'locked_at'     => $item->locked_at,
                'locked_by'     => $item->locked_by,
                'letter_code'   => $item->letter_code,
                'regarding'     => $item->regarding,
                'sector'        => $item->sector,
                'created_at'    => date('d-m-Y', strtotime($item->created_at)),
                'updated_at'    => date('d-m-Y', strtotime($item->updated_at)),
            ];
        })->filterColumn('start_at', function($query, $keyword) {
            $query->where('start_at', '<', $keyword);
            $query->where('end_in', '>', $keyword);
        })->toJson();
    }


    public function create()
    {
        //
    }


    public function store(LetterNumberStoreRequest $request, LetterNumber $letterNumber)
    {
        // $request->validate();

        $start = $request->input('start_at');
        $end = $request->input('end_in');
        $date = $request->input('date');
        $date = date('Y-m-d', strtotime($date));
        $dateYear = date('Y', strtotime($date));

        $letterNumber->numbers_date = $date;
        $letterNumber->start_at = $request->input('start_at');
        $letterNumber->end_in = $request->input('end_in');
        $letterNumber->letter_code = $request->input('letter_code');
        $letterNumber->regarding = $request->input('regarding');
        $letterNumber->type = $request->input('type');
        $letterNumber->sector_id = $request->input('sector_id');

        $checkStart_at = LetterNumber::select('id')
                         ->where('start_at', '<=', $start)
                         ->where('end_in', '>=', $start)
                         ->whereYear('numbers_date', $dateYear)
                         ->get();

        $checkEnd_in = LetterNumber::select('id')
                       ->where('start_at', '<=', $end)
                       ->where('end_in', '>=', $end)
                       ->whereYear('numbers_date', $dateYear)
                       ->get();

        $checkUse = NumberInUse::select('id', 'number')
                    ->where('number', '>=', $start)
                    ->where('number', '<=', $end)
                    ->whereYear('date_use', $dateYear)
                    ->get();

        if (!$checkStart_at->isEmpty() || !$checkEnd_in->isEmpty()){
            $this->responseCode = 400;
            $this->responseMessage = 'range nomor sudah ada yang di pesan';
            return response()->json($this->getResponse(), $this->responseCode);
        } elseif (!$checkUse->isEmpty()) {
            $listNumber = $checkUse->pluck('number')->all();
            $listNumber = implode(", ",$listNumber);

            $this->responseCode = 400;
            $this->responseMessage = "Nomor {$listNumber} telah digunakan pada aplikasi E-Surat";
            return response()->json($this->getResponse(), $this->responseCode);
        } else {
            $letterNumber ->save();

            $this->responseCode = 200;
            $this->responseMessage = 'Data tersimpan!';
            $this->responseData = $letterNumber;

            return response()->json($this->getResponse(), $this->responseCode);
        }

        return response()->json($this->getResponse(), $this->responseCode);
    }


    public function show(LetterNumber $letterNumber)
    {
        $this->responseCode = 200;
        $this->responseMessage = 'Data berhasil didapatkan';
        $this->responseData = new LetterNumberResource($letterNumber);

        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function showDetailNumber(DetailNumberRequest $request)
    {
        $number = $request->input('number');
        $date = $request->input('date');

        $numberInUse = NumberInUse::select("number_in_use.*", "letter_numbers.regarding", "letter_numbers.type", "letter_numbers.sector_id")
                                  ->with('surat')
                                  ->leftJoin('letter_numbers', function($join)
                                  {
                                      $join->on('letter_numbers.numbers_date', '=', 'number_in_use.date_use');
                                      $join->whereColumn('start_at', '<=', 'number');
                                      $join->whereColumn('end_in', '>=', 'number');
                                  })
                                  ->where('number', $number)
                                  ->whereDate('date_use', $date)
                                  ->first();

        $this->responseCode = 200;
        $this->responseMessage = 'Data berhasil didapatkan';
        $this->responseData = new DetailNumberInUseResource($numberInUse);

        return response()->json($this->getResponse(), $this->responseCode);
    }


    public function edit($id)
    {

    }


    public function update(LetterNumberStoreRequest $request, LetterNumber $letterNumber)
    {
        if ($letterNumber->locked_at == null){
            $start = $request->input('start_at');
            $end = $request->input('end_in');
            $date = $request->input('date');
            $date = date('Y-m-d', strtotime($date));
            $dateYear = date('Y', strtotime($date));

            $checkStart_at = LetterNumber::select('*')
                             ->where('start_at', '<=', $start)
                             ->where('end_in', '>=', $start)
                             ->whereYear('numbers_date', $dateYear)
                             ->where('id','!=',$letterNumber->id)
                             ->get();

            $checkEnd_in = LetterNumber::select('*')
                            ->where('start_at', '<=', $end)
                            ->where('end_in', '>=', $end)
                            ->whereYear('numbers_date', $dateYear)
                            ->where('id','!=',$letterNumber->id)
                            ->get();

            $checkUse = NumberInUse::select('id', 'number')
                            ->where('number', '>=', $start)
                            ->where('number', '<=', $end)
                            ->whereYear('date_use', $dateYear)
                            ->get();

            if (!$checkStart_at->isEmpty() || !$checkEnd_in->isEmpty()){
                $this->responseCode = 400;
                $this->responseMessage = 'Range nomor sudah pernah dibuat';
                return response()->json($this->getResponse(), $this->responseCode);
            } elseif (!$checkUse->isEmpty()) {
                $listNumber = $checkUse->pluck('number')->all();
                $listNumber = implode(", ",$listNumber);

                $this->responseCode = 400;
                $this->responseMessage = "Nomor {$listNumber} telah digunakan";
                return response()->json($this->getResponse(), $this->responseCode);
            } else {
                $letterNumber->start_at = $request->input('start_at');
                $letterNumber->end_in = $request->input('end_in');
                $letterNumber->letter_code = $request->input('letter_code');
                $letterNumber->regarding = $request->input('regarding');
                $letterNumber->sector_id = $request->input('sector_id');

                $letterNumber->save();

                $this->responseCode = 200;
                $this->responseMessage = 'Data berhasil disimpan';
                $this->responseData = $letterNumber ;

                return response()->json($this->getResponse(), $this->responseCode);
            }
        } else {
            $this->responseCode = 400;
            $this->responseMessage = 'Data Telah Dikunci, Silahkan Hubungi Administrator';
            $this->responseData = $letterNumber ;
        }

        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function lock(LetterNumber $letterNumber)
    {
        $id = auth()->user()->id;

        if ($letterNumber->locked_at == null){
            $letterNumber->locked_at = now();
            $letterNumber->locked_by = $id;

            $letterNumber->save();

            $this->responseCode = 200;
            $this->responseMessage = 'Data berhasil dikunci';
        } else {
            $this->responseCode = 400;
            $this->responseMessage = 'Data Telah Dikunci Sebelumnya';
        }

        return response()->json($this->getResponse(), $this->responseCode);
    }


    public function destroy(LetterNumber $letterNumber)
    {


        $letterNumber ->delete();

        $this->responseCode = 200;
        $this->responseMessage = 'Data berhasil dihapus';

        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function getLastNumber(Request $request)
    {
        $date = $request->input('date');
        $date = date('Y-m-d', strtotime($date));
        $dateYear = date('Y', strtotime($date));

        $modelLetterNumber = LetterNumber::select('end_in')
        ->whereYear('numbers_date', $dateYear)
        ->orderBy('end_in', 'DESC')
        ->first();

        $modelNumberInUse = NumberInUse::select('number')
        ->whereYear('date_use', $dateYear)
        ->orderBy('number', 'DESC')
        ->first();

        if (!empty($modelLetterNumber) && empty($modelNumberInUse)){
            $this->responseData = $modelLetterNumber->end_in;
        } elseif (empty($modelLetterNumber) && !empty($modelNumberInUse)) {
            $this->responseData = $modelNumberInUse->number;
        } elseif (!empty($modelLetterNumber) && !empty($modelNumberInUse)) {
            if ($modelLetterNumber->end_in > $modelNumberInUse->number){
                $this->responseData = $modelLetterNumber->end_in;
            } else {
                $this->responseData = $modelNumberInUse->number;
            }
        } else {
            $this->responseData = 0;
        }

        return response()->json($this->getResponse(), $this->responseCode);

    }
    // ! EXTERNAL

    public function getDateExisting()
    {
        $dt = Carbon::create(2018, 1, 12);
        $model = LetterNumber::select('*')
        ->whereBetween('numbers_date',[$dt,Carbon::now()])
        ->get();
        $this->responseData = LetterNumberResource::collection($model) ;

        return response()->json($this->getResponse(), $this->responseCode);

    }
}
