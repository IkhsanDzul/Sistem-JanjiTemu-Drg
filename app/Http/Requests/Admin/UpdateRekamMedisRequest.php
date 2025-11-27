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
            'biaya' => 'required|numeric|min:0',
            'resep_obat_nama' => 'nullable|string|max:255',
            'resep_obat_jumlah' => 'nullable|required_with:resep_obat_nama|integer|min:1',
            'resep_obat_dosis' => 'nullable|integer|min:0',
            'resep_obat_aturan_pakai' => 'nullable|string',
            'hapus_resep_obat' => 'nullable|boolean',
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
            'biaya.required' => 'Biaya wajib diisi.',
            'biaya.numeric' => 'Biaya harus berupa angka.',
            'biaya.min' => 'Biaya tidak boleh negatif.',
            'resep_obat_nama.max' => 'Nama obat maksimal 255 karakter.',
            'resep_obat_jumlah.required_with' => 'Jumlah obat wajib diisi jika memilih resep.',
            'resep_obat_jumlah.integer' => 'Jumlah harus berupa angka bulat.',
            'resep_obat_jumlah.min' => 'Jumlah minimal 1.',
            'resep_obat_dosis.integer' => 'Dosis harus berupa angka bulat.',
            'resep_obat_dosis.min' => 'Dosis tidak boleh negatif.',
        ];
    }
}

