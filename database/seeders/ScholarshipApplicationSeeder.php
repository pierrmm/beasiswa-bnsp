<?php

namespace Database\Seeders;

use App\Models\ScholarshipApplication;
use Illuminate\Database\Seeder;

class ScholarshipApplicationSeeder extends Seeder
{
    /**
     * Seed contoh data pendaftaran beasiswa.
     */
    public function run(): void
    {
        $gpa = (float) config('scholarship.gpa_value');

        ScholarshipApplication::query()->create([
            'nama' => 'Andi Mahardika',
            'email' => 'andi@example.com',
            'no_hp' => '081234567890',
            'semester' => 5,
            'ipk' => $gpa,
            'jenis_beasiswa' => 'Beasiswa Akademik',
            'status_ajuan' => 'belum diverifikasi',
            'berkas_path' => null,
        ]);

        ScholarshipApplication::query()->create([
            'nama' => 'Sari Puspita',
            'email' => 'sari@example.com',
            'no_hp' => '082233445566',
            'semester' => 6,
            'ipk' => $gpa,
            'jenis_beasiswa' => 'Beasiswa Non-Akademik',
            'status_ajuan' => 'belum diverifikasi',
            'berkas_path' => null,
        ]);
    }
}
