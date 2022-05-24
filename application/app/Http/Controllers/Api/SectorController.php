<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\SectorResource;
use App\Http\Requests\MasterListRequest;
use App\Http\Requests\SectorStoreRequest;
use Carbon\Carbon;
use App\Models\Sector;
use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class SectorController extends Controller
{

    public function index()
    {
        $model = Sector::get();

        return DataTables::of(SectorResource::collection($model))->toJson();
    }

    public function selectList(MasterListRequest $request)
    {
        $request->validated();
        $limit = $request->limit;
        $search = $request->search;
        $active_only = $request->active_only;

        $model = new Sector();

        if ($limit){
            $model = $model->limit($limit);
        }

        if (!empty($search)) {
          $model = $model->where(function ($where) use ($search) {
              $where->where('name', 'ilike', '%' . $search . '%');
          });
        }

        if ($active_only == 1) {
            $model = $model->active();
        }

        $model = $model->orderBy('name', 'ASC')->get();

        $this->responseCode = 200;
        $this->responseData = $model;

        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function store(SectorStoreRequest $request)
    {
        $sector = Sector::create($request->validated());

        $this->responseCode = 200;
        $this->responseMessage = 'Data berhasil disimpan';
        $this->responseData = $sector;

        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function show(Sector $sector)
    {
        $this->responseCode = 200;
        $this->responseData = $sector;

        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function updateSector(Request $request)
    {
        $id = $request->input('ID');
        $data = [
            'name' => $request->input('UNIT'),
            'is_active' => $request->input('STATUS'),
        ];

        $sector = Sector::updateOrCreate(
            ['id' => $id], $data
        );

        $this->responseCode = 200;
        $this->responseMessage = 'Data berhasil diubah';
        $this->responseData = $sector;

        return response()->json($this->getResponse(), $this->responseCode);
    }

    public function destroy(Sector $sector)
    {
        $sector->delete();

        $this->responseCode = 200;
        $this->responseMessage = 'Data berhasil dihapus';

        return response()->json($this->getResponse(), $this->responseCode);
    }
}
