<?php

use App\Http\Controllers\PDFController;
use Illuminate\Support\Facades\Route;

// PDF Form Routes
Route::get('/', [PDFController::class, 'showForm'])->name('pdf.form');
Route::post('/generate-pdf', [PDFController::class, 'generatePdf'])->name('pdf.generate');
