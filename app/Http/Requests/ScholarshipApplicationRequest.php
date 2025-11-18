<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

/**
 * Validasi data pendaftaran beasiswa.
 */
class ScholarshipApplicationRequest extends FormRequest
{
    /**
     * Selalu izinkan request karena akses publik.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Aturan validasi untuk setiap field.
     */
    public function rules(): array
    {
        $gpa = (float) $this->session()->get('current_gpa', config('scholarship.gpa_value'));
        $canApply = $gpa >= 3;

        $rules = [
            'nama' => ['required', 'string', 'min:3'],
            'email' => ['required', 'email', Rule::unique('scholarship_applications', 'email')],
            'no_hp' => ['required', 'regex:/^[0-9]+$/'],
            'semester' => ['required', 'integer', 'between:1,8'],
        ];

        if ($canApply) {
            $rules['jenis_beasiswa'] = ['required', 'string'];
            $rules['berkas'] = ['required', 'file', 'mimes:pdf,jpg,jpeg,png,zip', 'max:2048'];
        } else {
            // Ketika IPK kurang dari 3, field tidak boleh diisi sama sekali.
            $rules['jenis_beasiswa'] = ['prohibited'];
            $rules['berkas'] = ['prohibited'];
        }

        return $rules;
    }

    /**
     * Pesan validasi kustom agar lebih komunikatif.
     */
    public function messages(): array
    {
        return [
            'nama.required' => 'Nama wajib diisi.',
            'nama.min' => 'Nama minimal 3 karakter.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'no_hp.required' => 'No HP wajib diisi.',
            'no_hp.regex' => 'No HP hanya boleh berisi angka.',
            'semester.required' => 'Semester wajib diisi.',
            'semester.between' => 'Semester harus antara 1 sampai 8.',
            'jenis_beasiswa.required' => 'Silakan pilih jenis beasiswa.',
            'jenis_beasiswa.prohibited' => 'IPK belum memenuhi syarat untuk memilih beasiswa.',
            'berkas.required' => 'Berkas wajib diunggah.',
            'berkas.file' => 'Berkas harus berupa file.',
            'berkas.mimes' => 'Format file harus pdf, jpg, jpeg, png, atau zip.',
            'berkas.max' => 'Ukuran file maksimal 2MB.',
            'berkas.prohibited' => 'IPK belum memenuhi syarat untuk mengunggah berkas.',
        ];
    }
}
