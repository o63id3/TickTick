<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function list(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(AppList::class, 'list_id');
    }

    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class)
            ->orderBy('completed_at', 'asc')
            ->orderByRaw('
                case
                    when priority = "None" then 1
                    when priority = "Low" then 2
                    when priority = "Medium" then 3
                    when priority = "High" then 4
                end desc
            ');
    }

    public function completedTasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class)
            ->whereNotNull('completed_at');
    }

    public function uncompletedTasks(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Task::class)
            ->whereNull('completed_at');
    }
}
