<?php

namespace App\Models;

use App\Enums\TaskPriority;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'priority', 'completed_at'];

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

    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(TaskItem::class)
            ->orderBy('completed_at');
    }

    public function completedItems(): HasMany
    {
        return $this->hasMany(TaskItem::class)
            ->whereNotNull('completed_at');
    }

    public function uncompletedItems(): HasMany
    {
        return $this->hasMany(TaskItem::class)
            ->whereNull('completed_at');
    }
}
