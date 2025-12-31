<?php

namespace App\Modules\HouseholdMember\Models;

use Illuminate\Database\Eloquent\Model;
use App\Concerns\UuidPrimaryKey;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;
use App\Modules\User\Models\User;

class HouseholdMember extends Model
{
    use UuidPrimaryKey, LogsActivity;

    protected $fillable = [
        'user_id',
        'name',
        'color',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    /**
     * Get the user that owns the household member.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope a query to only include household members for a specific user.
     */
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    /**
     * Scope a query to order household members by sort order.
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }

    /**
     * Activity log options.
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
                ->logAll()
                ->useLogName('household_member');
    }
}
