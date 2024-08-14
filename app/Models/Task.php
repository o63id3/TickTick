<?php

namespace App\Models;

use App\Enums\TaskPriority;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'priority', 'completed'];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'priority' => TaskPriority::class,
        ];
    }

    public function section(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function items(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TaskItem::class);
    }

    public function completedItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TaskItem::class)
            ->where('completed', 1);
    }

    public function uncompletedItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(TaskItem::class)
            ->where('completed', 0);
    }
}
