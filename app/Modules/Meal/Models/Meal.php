<?php

namespace App\Modules\Meal\Models;

use Illuminate\Database\Eloquent\Model;
use App\Concerns\UuidPrimaryKey;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Modules\User\Models\User;
use App\Modules\HouseholdMember\Models\HouseholdMember;

class Meal extends Model
{
    use UuidPrimaryKey, LogsActivity;

    protected $fillable = [
        'user_id',
        'date',
        'name',
        'meal_type',
        'time',
        'assigned_to_id',
        'notes',
        'calories',
    ];

    protected $casts = [
        'date' => 'date',
        'time' => 'datetime:H:i',
        'calories' => 'integer',
    ];

    /**
     * Get the user that owns the meal.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the household member assigned to this meal.
     */
    public function assignedTo()
    {
        return $this->belongsTo(HouseholdMember::class, 'assigned_to_id');
    }

    /**
     * Scope a query to only include meals for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to only include meals for a specific date.
     */
    public function scopeForDate($query, $date)
    {
        return $query->whereDate('date', $date);
    }

    /**
     * Scope a query to order meals by meal type and time.
     */
    public function scopeOrderedByTime($query)
    {
        return $query->orderByRaw("
            CASE meal_type
                WHEN 'breakfast' THEN 1
                WHEN 'lunch' THEN 2
                WHEN 'snack' THEN 3
                WHEN 'dinner' THEN 4
            END
        ")->orderBy('time');
    }

    /**
     * Activity log options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logAll()
                ->useLogName('meal');
    }
}
