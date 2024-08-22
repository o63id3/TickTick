<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class AppList extends Model
{
    use HasFactory;

    protected $table = 'lists';

    protected $fillable = ['name', 'description'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sections(): HasMany
    {
        return $this->hasMany(Section::class, 'list_id');
    }

    public function tasks(): HasManyThrough
    {
        return $this->hasManyThrough(Task::class, Section::class, 'list_id', 'section_id');
    }

    public function completedTasks(): HasManyThrough
    {
        return $this->hasManyThrough(Task::class, Section::class, 'list_id', 'section_id')
            ->whereNotNull('completed_at');
    }

    public function uncompletedTasks(): HasManyThrough
    {
        return $this->hasManyThrough(Task::class, Section::class, 'list_id', 'section_id')
            ->whereNull('completed_at');
    }
}
