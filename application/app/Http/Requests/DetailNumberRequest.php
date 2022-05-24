<?php

namespace App\Http\Requests;

use App\Helpers\HelperPublic;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class DetailNumberRequest extends FormRequest
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
        return [
            'number' => 'numeric|required',
            'date' => 'date',
        ];
    }

    public function attributes()
    {
        return [
            'number' => 'Nomor',
            'date' => 'Tanggal',
        ];
    }
}
