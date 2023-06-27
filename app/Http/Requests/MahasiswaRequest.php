<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MahasiswaRequest extends FormRequest
{
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
            'nrp' => 'required|integer|unique:mahasiswas',
            'nama' => 'required',
            'id_prodi' => 'required|integer',
            'photo' => 'required|image',
            'password' => 'required|confirmed',
        ];
    }
}
