<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\DB;

class Section extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function list(): BelongsTo
    {
        return $this->belongsTo(AppList::class, 'list_id');
    }

    public function tasks(): HasMany
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

    public function completedTasks(): HasMany
    {
        return $this->hasMany(Task::class)
            ->whereNotNull('completed_at');
    }

    public function uncompletedTasks(): HasMany
    {
        return $this->hasMany(Task::class)
            ->whereNull('completed_at');
    }
}
