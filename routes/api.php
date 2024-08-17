<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\UserController;
use App\Http\Controllers\ProgramaController;
use App\Http\Controllers\MateriaController;
use App\Http\Controllers\InscripcionController;

Route::get('/users', [UserController::class, 'index']);
Route::get('/users/last', [UserController::class, 'lastIndex']);
Route::post('/users/new', [UserController::class, 'store']);
Route::post('/users/login', [UserController::class, 'login']);
Route::post('/users/update', [UserController::class, 'update']);
Route::post('/users/show', [UserController::class, 'show']);
Route::get('/users/delete/{id}', [UserController::class,'destroy']);

Route::get('/profesores', [UserController::class, 'profesores']);
Route::get('/profesores/horario/{id}', [InscripcionController::class,'horarioProfesor']);

Route::get('/alumnos', [UserController::class, 'alumnosInfo']);

Route::get('/materias', [MateriaController::class,'index']);
Route::post('/materias/new', [MateriaController::class,'store']);
Route::post('/materias/update', [MateriaController::class,'update']);
Route::get('/materias/delete/{id}', [MateriaController::class,'destroy']);
Route::post('/materias/prof_update', [MateriaController::class,'updateProfesor']);

Route::get('/programas', [ProgramaController::class,'index']);
Route::post('/programas/new', [ProgramaController::class,'store']);
Route::post('/programas/update', [ProgramaController::class,'update']);
Route::get('/programas/delete/{id}', [MateriaController::class,'destroy']);

Route::get('/inscripciones/{id}', [InscripcionController::class,'index']);
Route::get('/inscripciones/delete/{id}', [InscripcionController::class,'destroy']);
Route::post('/inscripciones/new', [InscripcionController::class,'store']);