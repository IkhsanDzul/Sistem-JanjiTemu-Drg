<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRekamMedisRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'diagnosa' => 'required|string|max:500',
            'tindakan' => 'required|string|max:500',
            'catatan' => 'nullable|string|max:1000',
            'biaya' => 'nullable|numeric|min:0',
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'diagnosa.required' => 'Diagnosa wajib diisi.',
            'diagnosa.max' => 'Diagnosa maksimal 500 karakter.',
            'tindakan.required' => 'Tindakan wajib diisi.',
            'tindakan.max' => 'Tindakan maksimal 500 karakter.',
            'catatan.max' => 'Catatan maksimal 1000 karakter.',
            'biaya.numeric' => 'Biaya harus berupa angka.',
            'biaya.min' => 'Biaya tidak boleh negatif.',
        ];
    }
}

