<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\NumberInUse;

class LetterNumberResource extends JsonResource
{
    /**
    * Transform the resource into an array.
    *
    * @param  \Illuminate\Http\Request  $request
    * @return array
    */

    public function toArray($request)
    {
        $data = [
            'id'             => $this->id,
            'numbers_date'   => date('Y-m-d', strtotime($this->numbers_date)),
            'start_at'       => $this->start_at,
            'end_in'         => $this->end_in,
            'locked_at'      => $this->locked_at,
            'locked_by'      => $this->locked_by,
            'number_use'     => null,
            'number_not_use' => null,
            'letter_code'    => $this->letter_code,
            'regarding'      => $this->regarding,
            'sector'         => $this->sector,
            'created_at'     => date('Y-m-d', strtotime($this->created_at)),
            'updated_at'     => date('Y-m-d', strtotime($this->updated_at)),
        ];

        $getNumberInUse = NumberInUse::where('number', '>=', $this->start_at)
        ->where('number', '<=', $this->end_in)
        ->where('user_id', '!=', null)
        ->whereDate('date_use', $this->numbers_date)
        ->orderBy('number', 'ASC')
        ->get()
        ->pluck('number')
        ->all();

        $getNumberNonEsurat = NumberInUse::where('number', '>=', $this->start_at)
        ->where('number', '<=', $this->end_in)
        ->where('user_id', '=', null)
        ->orderBy('number', 'ASC')
        ->get()
        ->pluck('number')
        ->all();

        $getNumberNameInUse = NumberInUse::select('number', 'user_name', 'date_use', 'user_id')->where('number', '>=', $this->start_at)
        ->where('number', '<=', $this->end_in)
        ->where('user_id', '!=', null)
        ->whereDate('date_use', $this->numbers_date)
        ->orderBy('number', 'ASC')
        ->get();

        $getNumberDateNonEsurat = NumberInUse::select('number', 'user_name', 'judul', 'keterangan', 'date_use')->where('number', '>=', $this->start_at)
        ->where('number', '<=', $this->end_in)
        ->where('user_id', '=', null)
        ->orderBy('number', 'ASC')
        ->get();

        $getNumber = [];
        $getNumber = array_merge($getNumberInUse, $getNumberNonEsurat);
        $getNumberNotUse = [];
        for ($i=$this->start_at; $i <= $this->end_in; $i++) {
            if(!in_array($i, $getNumber)){
                $getNumberNotUse[] = $i;
            }
        }

        $data['number_use'] = $getNumberNameInUse;
        $data['number_use_non_esurat'] = $getNumberDateNonEsurat;
        $data['number_not_use'] = $getNumberNotUse;

        return $data;
    }
}
