<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoListController;

Route::get('todo-list', [TodoListController::class, 'index'])->name('todo-list.index');
Route::post('todo-list', [TodoListController::class, 'store'])->name('todo-list.store');
Route::get('todo-list/{todolist}', [TodoListController::class, 'show'])->name('todo-list.show');
Route::put('todo-list/{todolist}', [TodoListController::class, 'update'])->name('todo-list.update');
Route::delete('todo-list/{todolist}', [TodoListController::class, 'destroy'])->name('todo-list.destroy');
