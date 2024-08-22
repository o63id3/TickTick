<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Staudenmeir\EloquentHasManyDeep\HasRelationships;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use HasRelationships;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */
    protected $appends = [
        'profile_photo_url',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function lists(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(AppList::class);
    }

    public function tasks(): \Staudenmeir\EloquentHasManyDeep\HasManyDeep
    {
        return $this->hasManyDeep(
            Task::class,
            [AppList::class, Section::class],
            [
                'user_id',
                'list_id',
                'section_id'
            ])
            ->with(['section:id,list_id,name', 'section.list:id,name']);
    }

    public function recentlyCreatedTasks(): \Staudenmeir\EloquentHasManyDeep\HasManyDeep
    {
        return $this
            ->tasks()
            ->where('tasks.created_at', '>', now()->subDay())
            ->orderByDesc('created_at');
    }

    public function completedTasks(): \Staudenmeir\EloquentHasManyDeep\HasManyDeep
    {
        return $this
            ->tasks()
            ->whereNotNull('completed_at')
            ->orderByRaw('
                case
                    when priority = "None" then 1
                    when priority = "Low" then 2
                    when priority = "Medium" then 3
                    when priority = "High" then 4
                end desc
            ');
    }

    public function recentlyCompletedTasks(): \Staudenmeir\EloquentHasManyDeep\HasManyDeep
    {
        return $this
            ->tasks()
            ->whereNotNull('completed_at')
            ->orderByDesc('completed_at');
    }

    public function uncompletedTasks(): \Staudenmeir\EloquentHasManyDeep\HasManyDeep
    {
        return $this
            ->tasks()
            ->latest()
            ->whereNull('completed_at');
    }

    public function highPriorityTasks(): \Staudenmeir\EloquentHasManyDeep\HasManyDeep
    {
        return $this
            ->tasks()
            ->whereNull('completed_at')
            ->orderByRaw('
                case
                    when priority = "None" then 1
                    when priority = "Low" then 2
                    when priority = "Medium" then 3
                    when priority = "High" then 4
                end desc
            ');
    }
}
