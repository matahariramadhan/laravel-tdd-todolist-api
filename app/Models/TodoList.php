<?php

namespace App\Models;

use App\Models\Task;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TodoList extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
