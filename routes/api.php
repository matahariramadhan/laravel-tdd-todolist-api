<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodoListController;

Route::get('todo-list', [TodoListController::class, 'index'])->name('todo-list.index');
Route::get('todo-list/{todolist}', [TodoListController::class, 'show'])->name('todo-list.show');
