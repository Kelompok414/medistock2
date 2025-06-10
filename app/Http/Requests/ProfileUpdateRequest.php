<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileUpdateRequest extends FormRequest
{
    /**
     * Menentukan apakah user diizinkan melakukan request ini.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk pembaruan profil.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'birthday' => ['nullable', 'date'],
            'gender' => ['nullable', 'in:Laki-laki,Perempuan'],
            'phone' => ['nullable', 'string'],
        ];
    }
}
