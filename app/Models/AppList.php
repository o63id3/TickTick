<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppList extends Model
{
    use HasFactory;

    protected $table = 'lists';

    protected $fillable = ['name'];

    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function sections(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Section::class, 'list_id');
    }

    public function tasks(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Task::class, Section::class, 'list_id', 'section_id');
    }

    public function completedTasks(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Task::class, Section::class, 'list_id', 'section_id')
            ->where('completed', 1);
    }

    public function uncompletedTasks(): \Illuminate\Database\Eloquent\Relations\HasManyThrough
    {
        return $this->hasManyThrough(Task::class, Section::class, 'list_id', 'section_id')
            ->where('completed', 0);
    }
}
