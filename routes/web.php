<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\ClassController;

Route::get('/', function () {
    return redirect()->route('students.index');
});

// Students
Route::get('/students/list', [StudentController::class, 'list'])->name('students.list');
Route::resource('students', StudentController::class)->except(['show']); // remove unused show()
Route::post('/students/{student}/assign-class', [StudentController::class, 'assignClass'])->name('students.assignClass');
Route::delete('/students/{student}/class/{class}', [StudentController::class, 'removeClass'])->name('students.removeClass');

// Classes
Route::get('/classes/list', [ClassController::class, 'list'])->name('classes.list');
Route::resource('classes', ClassController::class)->except(['show']); // remove unused show()
Route::get('/classes/create', [ClassController::class, 'create'])->name('classes.create');
Route::post('/classes', [ClassController::class, 'store'])->name('classes.store');
