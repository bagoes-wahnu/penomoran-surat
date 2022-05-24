<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use App\Models\NumberInUse;
use App\Models\Pegawai;
use App\Helpers\HelperPublic;

class DetailNumberInUseResource extends JsonResource
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
            'number'         => $this->number,
            'date_number'    => date('d-m-Y', strtotime($this->date_use)),
            'user_use'       => $this->user_name,
            'regarding'      => $this->regarding,
            'judul'          => $this->judul,
            'type'           => $this->type,
            'sector_id'      => $this->sector_id,
            'surat'          => null
        ];

        if (!empty($this->surat)) {
            $data['surat'] = [
                'no_surat'  => $this->surat->srt_nomor_surat ?? '-',
                'tanggal'   => date('d-m-Y', strtotime($this->surat->srt_tanggal)),
                'judul'     => $this->surat->srt_judul,
                'pengirim'  => Pegawai::select('pgw_id as id', 'pgw_nama as nama', 'pgw_unit_id')->where('pgw_id', $this->surat->srt_pgw_id)->first(),
                'link'      => env('LINK_ESURAT').'surat-download/'.$this->surat->srt_id.'/'.env('TOKEN_ESURAT'),
            ];
        }
        if ($data['regarding'] == null) {
            $data['regarding'] = $data['judul'];
            // dump('test');
            if ($data['judul'] == null) {
                $data['judul'] = '-';
                // dump('test123');
            }
        }
        // dump($data);
        return $data;
    }
}
