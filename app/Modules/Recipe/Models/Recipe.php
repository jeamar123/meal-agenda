<?php

namespace App\Modules\Recipe\Models;

use App\Models\User;
use App\Concerns\UuidPrimaryKey;
use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

class Recipe extends Model
{
    use UuidPrimaryKey, LogsActivity;

    protected $fillable = [
        'user_id',
        'name',
        'description',
        'ingredients',
        'instructions',
        'prep_time',
        'cook_time',
        'servings',
        'difficulty',
        'category',
        'calories',
    ];

    protected $casts = [
        'prep_time' => 'integer',
        'cook_time' => 'integer',
        'servings' => 'integer',
        'calories' => 'integer',
    ];

    // Activity logging
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['name', 'category', 'difficulty']);
    }

    // Relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function meals()
    {
        return $this->hasMany(\App\Modules\Meal\Models\Meal::class);
    }

    // Scopes
    public function scopeForUser($query, $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrderedByName($query)
    {
        return $query->orderBy('name', 'asc');
    }
}
