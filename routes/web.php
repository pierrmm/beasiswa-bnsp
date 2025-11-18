<?php

use App\Http\Controllers\ScholarshipController;
use Illuminate\Support\Facades\Route;

Route::get('/', [ScholarshipController::class, 'index'])->name('scholarships.index');
Route::get('/daftar', [ScholarshipController::class, 'create'])->name('scholarships.create');
Route::post('/daftar', [ScholarshipController::class, 'store'])->name('scholarships.store');
Route::get('/hasil', [ScholarshipController::class, 'results'])->name('scholarships.results');
Route::get('/berkas/{application}/{filename}', [ScholarshipController::class, 'preview'])
    ->where('filename', '.+')
    ->name('scholarships.preview');
Route::get('/berkas/{application}/{filename}/download', [ScholarshipController::class, 'download'])
    ->where('filename', '.+')
    ->name('scholarships.download');
