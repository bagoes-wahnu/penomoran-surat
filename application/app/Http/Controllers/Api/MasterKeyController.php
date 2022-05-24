<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\MasterKeyResource;
use App\Models\MasterKey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class MasterKeyController extends Controller
{
    public function index()
    {
        $model = MasterKey::get();
        return DataTables::of(MasterKeyResource::collection($model))->toJson();
    }

    public function store(Request $request, MasterKey $masterKey)
    {
        $validator = Validator::make($request->all(),[
            'client_name' => 'required|unique:master_keys,client_name'
        ]);

        if ($validator->fails()) {
         return response()->json( $validator->errors(), $this->responseCode);
        }

        $masterKey->client_name = $request->input('client_name');
        $masterKey->key = Hash::make($request->input('client_name'));

        $masterKey->save();

        $this->responseCode = 200;
        $this->responseMessage = 'buat key data sukses';
        $this->responseData = $masterKey;
 
         return response()->json($this->getResponse(), $this->responseCode);

    }

    public function show($id)
    {
        $model= MasterKey::where('id',$id)->get();

        return DataTables::of(MasterKeyResource::collection($model))->toJson();

    }

    public function destroy(MasterKey $masterKey)
    {
        $masterKey ->delete();

        $this->responseCode = 200;
        $this->responseMessage = 'Data berhasil dihapus';

        return response()->json($this->getResponse(), $this->responseCode);
    }

}
