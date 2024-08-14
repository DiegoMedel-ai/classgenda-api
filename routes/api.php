<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\MateriaController;

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/last', [UserController::class, 'lastIndex']);
Route::post('/users/new', [UserController::class, 'store']);
Route::post('/users/login', [UserController::class, 'login']);
Route::post('/users/show', [UserController::class, 'show']);
Route::get('/profesores', [UserController::class, 'profesores']);

Route::get('/materias', [MateriaController::class,'index']);
Route::post('/materias/new', [MateriaController::class,'store']);
Route::post('/materias/update', [MateriaController::class,'update']);

Route::get('/programas', [ProgramaController::class,'index']);
Route::post('/programas/new', [ProgramaController::class,'store']);
Route::post('/programas/update', [ProgramaController::class,'update']);