<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MasterKeyResource extends JsonResource
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
            'client_name' => $this->client_name,
            'key'         => $this->key,
            'created_at'     => date('d-m-Y H:i:s', strtotime($this->created_at)),
            'updated_at'     => date('d-m-Y H:i:s', strtotime($this->updated_at)),
        ];
    }
}
