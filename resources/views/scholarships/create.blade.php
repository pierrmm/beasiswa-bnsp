@extends('layouts.app')

@section('title', 'Daftar Beasiswa')

@section('content')
<div class="row justify-content-center">
    <div class="col-lg-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <h1 class="h4 mb-3">Form Pendaftaran Beasiswa</h1>
                <p class="text-muted">IPK terbaru Anda: <strong>{{ number_format($gpa, 2) }}</strong></p>
                @if (!$canApply)
                    <div class="alert alert-warning">
                        IPK Anda belum memenuhi syarat minimal 3.00. Form akan otomatis terkunci.
                    </div>
                @endif
                <form action="{{ route('scholarships.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control @error('nama') is-invalid @enderror" id="nama" name="nama" value="{{ old('nama') }}" required>
                        @error('nama')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control @error('email') is-invalid @enderror" id="email" name="email" value="{{ old('email') }}" required>
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" class="form-control @error('no_hp') is-invalid @enderror" id="no_hp" name="no_hp" value="{{ old('no_hp') }}" required>
                        @error('no_hp')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="semester" class="form-label">Semester</label>
                        <select class="form-select @error('semester') is-invalid @enderror" id="semester" name="semester" required>
                            <option value="">-- Pilih Semester --</option>
                            @for ($sem = 1; $sem <= 8; $sem++)
                                <option value="{{ $sem }}" @selected((int) old('semester') === $sem)>{{ $sem }}</option>
                            @endfor
                        </select>
                        @error('semester')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label class="form-label">IPK</label>
                        <input type="text" class="form-control" value="{{ number_format($gpa, 2) }}" readonly>
                    </div>
                    {{-- Elemen di bawah ini dinonaktifkan ketika IPK < 3 --}}
                    <div class="mb-3">
                        <label for="jenis_beasiswa" class="form-label">Jenis Beasiswa</label>
                        <select class="form-select @error('jenis_beasiswa') is-invalid @enderror" id="jenis_beasiswa" name="jenis_beasiswa" @disabled(!$canApply)>
                            <option value="">-- Pilih Beasiswa --</option>
                            @foreach ($scholarshipTypes as $type)
                                <option value="{{ $type['name'] }}" @selected(old('jenis_beasiswa') === $type['name'])>{{ $type['name'] }}</option>
                            @endforeach
                        </select>
                        @if (!$canApply)
                            <div class="form-text text-danger">IPK minimal 3.00 untuk memilih beasiswa.</div>
                        @endif
                        @error('jenis_beasiswa')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="mb-3">
                        <label for="berkas" class="form-label">Upload Berkas Pendukung</label>
                        <input class="form-control @error('berkas') is-invalid @enderror" type="file" id="berkas" name="berkas" accept=".pdf,.jpg,.jpeg,.png,.zip" @disabled(!$canApply)>
                        @if (!$canApply)
                            <div class="form-text text-danger">Berkas hanya bisa diunggah jika IPK memenuhi.</div>
                        @endif
                        @error('berkas')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success" @disabled(!$canApply)>Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const canApply = @json($canApply);
        if (canApply) {
            document.getElementById('jenis_beasiswa').focus();
        }
    });
</script>
@endpush
