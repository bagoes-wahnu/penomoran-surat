<?php

namespace App\Http\Requests;

use App\Helpers\HelperPublic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class LetterNumberStoreRequest extends FormRequest
{
    protected function failedValidation(Validator $validator)
    {
        $responseCode = 422;
        $responseMessage = 'Silahkan isi form dengan benar terlebih dahulu';
        $responseData = $validator->errors()->all();
        $responseRequest = request()->all();

        $response = HelperPublic::helpResponse($responseCode, $responseData, $responseMessage, null, $responseRequest);

        throw new HttpResponseException(response($response, $responseCode));
    }
    /**
    * Determine if the user is authorized to make this request.
    *
    * @return bool
    */
    public function authorize()
    {
        return true;
    }

    /**
    * Get the validation rules that apply to the request.
    *
    * @return array
    */
    public function rules()
    {
        $request = app('request');

        return [
            'start_at' => 'numeric|required|max:'.$request->end_in,
            'end_in' => 'numeric|required|min:'.$request->start_at,
            'letter_code' => 'nullable',
            'regarding' => 'nullable',
            'type' => 'required',
            'sector_id' => 'nullable|exists:sectors,id|required_if:type,2',
        ];
    }

    public function attributes()
    {
        return [
            'start_at' => 'Nomor Awal',
            'end_in' => 'Nomor Terakhir',
            'letter_code' => 'Kode Surat',
            'regarding' => 'Perihal',
            'type' => 'Tipe Penggunaan',
            'sector_id' => 'Seksi Bidang',
        ];
    }
}
