<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class NumberInUseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'number' => $this->number,
            'user_id' => $this->user_id,
            'user_name' => $this->user_name,
            'created_at'     => date('d-m-Y H:i:s', strtotime($this->created_at)),
            'updated_at'     => date('d-m-Y H:i:s', strtotime($this->updated_at)),
        ];
    }
}
