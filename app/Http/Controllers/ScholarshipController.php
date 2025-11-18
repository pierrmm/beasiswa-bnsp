<?php

namespace App\Http\Controllers;

use App\Http\Requests\ScholarshipApplicationRequest;
use App\Models\ScholarshipApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

/**
 * Mengelola informasi dan proses pendaftaran beasiswa.
 */
class ScholarshipController extends Controller
{
    /**
     * Tampilkan daftar jenis beasiswa yang tersedia.
     */
    public function index(): View
    {
        return view('scholarships.index', [
            'scholarshipTypes' => config('scholarship.types'),
            'gpa' => $this->generateStudentGpa(),
        ]);
    }

    /**
     * Tampilkan formulir pendaftaran beasiswa.
     */
    public function create(): View
    {
        $gpa = $this->generateStudentGpa();
        session(['current_gpa' => $gpa]);

        return view('scholarships.create', [
            'scholarshipTypes' => config('scholarship.types'),
            'gpa' => $gpa,
            'canApply' => $gpa >= 3,
        ]);
    }

    /**
     * Simpan data pendaftaran beasiswa ke database.
     */
    public function store(ScholarshipApplicationRequest $request): RedirectResponse
    {
        $gpa = $this->currentSessionGpa();

        // Validasi tambahan di server agar user dengan IPK rendah tetap tertolak.
        if ($gpa < 3) {
            return redirect()
                ->route('scholarships.create')
                ->withErrors(['ipk' => 'IPK belum memenuhi syarat pendaftaran.'])
                ->withInput($request->except('berkas'));
        }

        $validated = $request->validated();

        $applicationData = [
            'nama' => $validated['nama'],
            'email' => $validated['email'],
            'no_hp' => $validated['no_hp'],
            'semester' => $validated['semester'],
            'ipk' => $gpa,
            'jenis_beasiswa' => $validated['jenis_beasiswa'],
            'status_ajuan' => 'belum diverifikasi',
        ];

        if ($request->hasFile('berkas')) {
            // Simpan berkas ke disk public agar dapat diunduh dari halaman hasil.
            $applicationData['berkas_path'] = $request
                ->file('berkas')
                ->store('berkas_beasiswa', 'public');
        }

        ScholarshipApplication::query()->create($applicationData);

        session()->forget('current_gpa');

        return redirect()
            ->route('scholarships.results')
            ->with('success', 'Pendaftaran berhasil disimpan.');
    }

    /**
     * Tampilkan daftar hasil pendaftaran beasiswa.
     */
    public function results(): View
    {
        return view('scholarships.results', [
            'applications' => ScholarshipApplication::query()->latest()->get(),
        ]);
    }

    /**
     * Unduh berkas pendaftaran melalui storage publik dengan validasi akses.
     */
    public function download(ScholarshipApplication $application)
    {
        if (empty($application->berkas_path)) {
            abort(404, 'Berkas tidak tersedia.');
        }

        if (! Storage::disk('public')->exists($application->berkas_path)) {
            abort(404, 'File tidak ditemukan di server.');
        }

        return Storage::disk('public')->download(
            $application->berkas_path,
            basename($application->berkas_path)
        );
    }

    /**
     * Ambil IPK dari sesi aktif agar nilai GET dan POST selalu sama.
     */
    private function currentSessionGpa(): float
    {
        return (float) session('current_gpa', config('scholarship.gpa_value'));
    }

    /**
     * Menghasilkan IPK acak berdasarkan daftar konstanta konfigurasi.
     */
    private function generateStudentGpa(): float
    {
        $gpaOptions = config('scholarship.gpa_values', []);

        if (! empty($gpaOptions)) {
            return (float) collect($gpaOptions)->random();
        }

        return (float) config('scholarship.gpa_value');
    }
}
