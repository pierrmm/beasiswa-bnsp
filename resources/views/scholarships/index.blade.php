@extends('layouts.app')

@section('title', 'Jenis Beasiswa')

@section('content')
<div class="row mb-4">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h4 mb-3">Sistem Pendaftaran Beasiswa Online</h1>
                <p class="mb-2">Gunakan portal ini untuk melihat jenis beasiswa, mendaftar, dan memantau status ajuan.</p>
                <p class="mb-0"><strong>IPK terakhir Anda:</strong> {{ number_format($gpa, 2) }}</p>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="h5">Panduan Singkat</h2>
                <ol class="mb-0">
                    <li>Lihat syarat setiap beasiswa di halaman ini.</li>
                    <li>Buka menu "Daftar Beasiswa" untuk mengisi formulir.</li>
                    <li>Cek hasil dan status ajuan di menu "Hasil Pendaftaran".</li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row g-4">
    @foreach ($scholarshipTypes as $type)
        <div class="col-md-6">
            <div class="card h-100 shadow-sm">
                <div class="card-body">
                    <h2 class="h5">{{ $type['name'] }}</h2>
                    <p>{{ $type['description'] }}</p>
                    <h3 class="h6">Syarat:</h3>
                    <ul>
                        @foreach ($type['requirements'] as $requirement)
                            <li>{{ $requirement }}</li>
                        @endforeach
                    </ul>
                    <a href="{{ route('scholarships.create') }}" class="btn btn-primary btn-sm">Daftar Sekarang</a>
                </div>
            </div>
        </div>
    @endforeach
</div>
@endsection
