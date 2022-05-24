<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\NumberInUseResource;
use App\Models\LetterNumber;
use App\Models\NumberInUse;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class NumberInUseController extends Controller
{

    public function index()
    {
        $model = NumberInUse::get();

        return DataTables::of(NumberInUseResource::collection($model))->toJson();
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'number' => 'required|numeric',
            'date' => 'required',
            'user_id' => 'required|numeric',
            'user_name' => 'required',
            'link' => 'nullable',
            'surat_id' => 'required',
        ]);
        if ($validator->fails()) {
            $this->responseCode = 400;
            $this->responseMessage = 'Bad Request';
            $this->responseData = $validator->errors();

            return response()->json($this->getResponse(), $this->responseCode);
        }

        $date = $request->input('date');
        $date = date('Y-m-d', strtotime($date));

        $numberInUse = NumberInUse::where('number', $request->input('number'))->whereDate('date_use', $date)->first();

        if (!empty($numberInUse)){
            $this->responseCode = 401;
            $this->responseMessage = 'Nomer Telah Digunakan Sebelumnya';
            $this->responseData = $numberInUse;
        } else {
            $numberInUse = new NumberInUse;
            $numberInUse->number = $request->input('number');
            $numberInUse->date_use = $date;
            $numberInUse->user_id = $request->input('user_id');
            $numberInUse->user_name = $request->input('user_name');
            // $numberInUse->link = $request->input('link');
            $numberInUse->surat_id = $request->input('surat_id');

            $numberInUse->save();

            $this->responseCode = 200;
            $this->responseMessage = 'simpan data sukses';
            $this->responseData = $numberInUse;
        }

        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function useNumber(Request $request)
    {
        // $number = $request->input('number');
        // $date_use = $request->input('date_use');
        // $user_name = $request->input('user_name');
        // $judul = $request->input('judul');
        // $keterangan = $request->input('keterangan');

        $numberInUse = NumberInUse::where('number', $request->input('number'));

        // if (!empty($numberInUse)){
        //     $this->responseCode = 401;
        //     $this->responseMessage = 'Nomer Telah Digunakan Sebelumnya123';
        //     $this->responseData = $numberInUse;
        // } else {
            $numberInUse = new NumberInUse;
            $numberInUse->number = $request->input('number');
            $numberInUse->date_use = $request->input('date_use');
            $numberInUse->judul = $request->input('judul');
            $numberInUse->keterangan = $request->input('keterangan');

            $numberInUse->save();

            $this->responseCode = 200;
            $this->responseMessage = 'simpan data sukses';
            $this->responseData = $numberInUse;
        // }

        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function show($id)
    {
        $model = NumberInUse::where('id', $id)->get();

        return DataTables::of(NumberInUseResource::collection($model))->toJson();
    }

    public function destroy(NumberInUse $numberInUse)
    {
        $numberInUse->delete();

        $this->responseCode = 200;
        $this->responseMessage = 'Data berhasil dihapus';

        return response()->json($this->getResponse(), $this->responseCode);
    }

    // ! EXTERNAL

    // public function numberExisting(Request $request)
    // {
    //     $validator = Validator::make($request->all(), [
    //     'sector_id' => 'nullable|exists:sectors,id'
    //     ]);

    //     if ($validator->fails()) {
    //         $this->responseCode = 400;
    //         $this->responseMessage = 'Bad Request';
    //         $this->responseData    = $validator->errors();

    //         return response()->json($this->getResponse(), $this->responseCode);
    //     }

    //     $date = date('Y-m-d');
    //     // $date = '2021-04-23';

    //     $check = NumberInUse::select('number')
    //     ->whereDate('date_use', $date)
    //     ->orderBy('number', 'ASC')
    //     ->get();

    //     $check = $check->pluck('number')
    //     ->all();

    //     $sector_id = $request->input('sector_id');

    //     $letterNumber = LetterNumber::select('*')
    //     ->whereDate('numbers_date', $date)
    //     ->whereNotNull('locked_at')
    //     ->where(function ($where) use($sector_id) {
    //         $where->where('sector_id', $sector_id)
    //         ->orWhere('type', 1);
    //     })

    //     ->orderBy('start_at', 'ASC')
    //     ->get();

    //     if (!$sector_id){
    //         $letterNumber = [];
    //     }

    //     $data = 0;

    //     foreach ($letterNumber as $key => $value) {
    //         $numberNotUse = 0;
    //         for ($i=$value->start_at; $i <= $value->end_in; $i++) {
    //             if(!in_array($i, $check)){
    //                 $numberNotUse = $i;
    //                 break;
    //             }
    //         }

    //         if ($numberNotUse != 0){
    //             $data = $numberNotUse;
    //             break;
    //         }
    //     }
    //     // } catch (\Exception $e) {
    //     //
    //     //     $this->responseCode = 500;
    //     //     $this->responseMessage = 'Internal Server Error';
    //     //     $this->responseData = 'Data pada tanggal tersebut tidak ada, mohon hubungi Admin';
    //     //     return response()->json($this->getResponse(), $this->responseCode);
    //     //     throw $e;
    //     // }

    //     if ($data == 0){
    //         $data = '-';
    //     }

    //     $this->responseData = $data;
    //     return response()->json($this->getResponse(), $this->responseCode);
    // }

    public function numberExisting()
    {
        $modelLetterNumber = LetterNumber::select('end_in')
        ->whereYear('numbers_date', date('Y'))
        ->orderBy('end_in', 'DESC')
        ->first();

        $modelNumberInUse = NumberInUse::select('number')
        ->whereYear('date_use', date('Y'))
        ->orderBy('number', 'DESC')
        ->first();

        if (!empty($modelLetterNumber) && empty($modelNumberInUse)) {
            $lastNumber = $modelLetterNumber->end_in+1;
        } elseif (empty($modelLetterNumber) && !empty($modelNumberInUse)) {
            $lastNumber = $modelNumberInUse->number+1;
        } elseif (!empty($modelLetterNumber) && !empty($modelNumberInUse)) {
            if ($modelLetterNumber->end_in > $modelNumberInUse->number) {
                $lastNumber = $modelLetterNumber->end_in+1;
            } else {
                $lastNumber = $modelNumberInUse->number+1;
            }
        } else {
            $lastNumber = 1;
        }

        $this->responseData = str_pad($lastNumber, 2, '0', STR_PAD_LEFT);

        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function numberExistingWithDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
        'date' => 'required|date',
        // 'sector_id' => 'nullable|exists:sectors,id'
        'sector_id' => 'nullable'
        ]);

        if ($validator->fails()) {
            $this->responseCode = 400;
            $this->responseMessage = 'Bad Request';
            $this->responseData    = $validator->errors();

            return response()->json($this->getResponse(), $this->responseCode);
        }

        // try {
        $check = NumberInUse::select('number')
        ->whereDate('date_use', $request->input('date'))
        ->orderBy('number', 'ASC')
        ->get();

        $check = $check->pluck('number')
        ->all();
        // dump($check);

        $sector_id = $request->input('sector_id');
        // dump($sector_id);

        $letterNumber = LetterNumber::select('*')
        ->whereDate('numbers_date', $request->input('date'))
        ->whereNotNull('locked_at')
        ->where(function ($where) use($sector_id) {
            $where->where('sector_id', $sector_id)
            ->orWhere('type', 1);
        })

        ->orderBy('start_at', 'ASC')
        ->get();

        // if (!$sector_id){
        //     $letterNumber = [];
        // }

        $data = [];

        foreach ($letterNumber as $key => $value) {
            $numberNotUse = [];
            $getNumberInUse = NumberInUse::where('number', '>=', $value->start_at)
            ->where('number', '<=', $value->end_in)
            ->where('user_id', '!=', null)
            ->whereDate('date_use', $value->numbers_date)
            ->orderBy('number', 'ASC')
            ->get()
            ->pluck('number')
            ->all();
            $getNumberNonEsurat = NumberInUse::where('number', '>=', $value->start_at)
            ->where('number', '<=', $value->end_in)
            ->where('user_id', '=', null)
            ->orderBy('number', 'ASC')
            ->get()
            ->pluck('number')
            ->all();
            // dump($value->start_at);
            $getNumber = array_merge($getNumberInUse, $getNumberNonEsurat);
            for ($i=$value->start_at; $i <= $value->end_in; $i++) {
                // if(!in_array($i, $check)){
                //     $numberNotUse[] = str_pad($i, 2, '0', STR_PAD_LEFT);
                // }
                if(!in_array($i, $getNumber)){
                    $numberNotUse[] = str_pad($i, 2, '0', STR_PAD_LEFT);
                }
            }

            $dataNumber['number'] = $numberNotUse;
            $dataNumber['letter_code'] = $value->letter_code;

            $data[] = $dataNumber;
        }


        // } catch (\Exception $e) {
        //
        //     $this->responseCode = 500;
        //     $this->responseMessage = 'Internal Server Error';
        //     $this->responseData = 'Data pada tanggal tersebut tidak ada, mohon hubungi Admin';
        //     return response()->json($this->getResponse(), $this->responseCode);
        //     throw $e;
        // }



        $this->responseData = $data;
        return response()->json($this->getResponse(), $this->responseCode);
    }
}
