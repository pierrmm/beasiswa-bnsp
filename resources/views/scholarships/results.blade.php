@extends('layouts.app')

@section('title', 'Hasil Pendaftaran')

@section('content')
    <div class="card shadow-sm">
        <div class="card-body">
            <h1 class="h4 mb-3">Hasil Pendaftaran Beasiswa</h1>
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Semester</th>
                            <th>IPK</th>
                            <th>Jenis Beasiswa</th>
                            <th>Berkas</th>
                            <th>Status Ajuan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($applications as $application)
                            <tr>
                                <td>{{ $application->nama }}</td>
                                <td>{{ $application->email }}</td>
                                <td>
                                    <a href="https://wa.me/{{ $application->no_hp }}" target="_blank">
                                        {{ $application->no_hp }}
                                    </a>
                                </td>
                                <td>{{ $application->semester }}</td>
                                <td>{{ number_format($application->ipk, decimals: 2) }}</td>
                                <td>{{ $application->jenis_beasiswa ?? '-' }}</td>
                                <td>
                                    @if ($application->berkas_path)
                                        @php $fileName = basename($application->berkas_path); @endphp
                                        <div class="d-flex flex-column">
                                            <a href="{{ route('scholarships.preview', ['application' => $application, 'filename' => $fileName]) }}"
                                                target="_blank">
                                                Lihat
                                            </a>
                                        </div>
                                    @else
                                        <span class="text-muted">Tidak ada</span>
                                    @endif
                                </td>
                                <td><span
                                        class="badge bg-warning text-dark">{{ ucfirst($application->status_ajuan) }}</span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center text-muted">Belum ada data pendaftaran.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
