<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CreateRequest extends FormRequest
{
    public $validator = null;
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'email' => 'required|string|email|max:255|unique:users',
        ];
        // if ($this->role_id == 2) {
        //     return [
        //         'nama' => 'required|string|max:255',
        //         'password' => 'required|string|min:6',
        //         'role_id' => 'required|integer',
        //         'kyc_file' => 'required|file',
        //         'no_ktp' => 'required|string|max:255',
        //         'telepon' => 'required|string|max:255',
        //     ];
        // } else {
        //     return [
        //         'nama' => 'required|string|max:255',
        //         'email' => 'required|string|email|max:255|unique:users',
        //         'password' => 'required|string|min:6',
        //         'role_id' => 'required|integer',
        //         'telepon' => 'required|string|max:255',
        //     ];
        // }
    }


    public function messages()
    {
        return ['email.unique' => 'Email sudah terdaftar'];
        // if ($this->role_id == 2) {
        //     return [
        //         'nama.required' => 'Nama tidak boleh kosong',
        //         'email.required' => 'Email tidak boleh kosong',
        //         'password.required' => 'Password tidak boleh kosong',
        //         'role_id.required' => 'Role tidak boleh kosong',
        //         'kyc_file.required' => 'File kyc tidak boleh kosong',
        //         'no_ktp.required' => 'No ktp tidak boleh kosong',
        //         'telepon.required' => 'Telepon tidak boleh kosong',
        //     ];
        // } else {
        //     return [
        //         'nama.required' => 'Nama tidak boleh kosong',
        //         'email.required' => 'Email tidak boleh kosong',
        //         'password.required' => 'Password tidak boleh kosong',
        //         'role_id.required' => 'Role tidak boleh kosong',
        //         'email.unique' => 'Email sudah terdaftar',
        //         'telepon.required' => 'Telepon tidak boleh kosong',
        //     ];
        // }
    }


    public function failedValidation(Validator $validator)
    {
        $this->validator = $validator;
    }
}
