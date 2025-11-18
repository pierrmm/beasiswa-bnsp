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
                            <td>{{ $application->no_hp }}</td>
                            <td>{{ $application->semester }}</td>
                            <td>{{ number_format($application->ipk, 2) }}</td>
                            <td>{{ $application->jenis_beasiswa ?? '-' }}</td>
                            <td>
                                @if ($application->berkas_path)
                                    <a href="{{ route('scholarships.download', $application) }}" target="_blank">Unduh</a>
                                @else
                                    <span class="text-muted">Tidak ada</span>
                                @endif
                            </td>
                            <td><span class="badge bg-warning text-dark">{{ ucfirst($application->status_ajuan) }}</span></td>
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
