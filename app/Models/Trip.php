<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'label',
        'user_id',
        'country_id',
        'location',
        'date',
        'description',
        'latitude',
        'longitude',
        'image',
        'shared',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'country_id' => 'integer',
        'latitude' => 'float',
        'longitude' => 'float',
        'date' => 'datetime',
        'shared' => 'boolean',
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function userSharedTrips(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_trip_shared');
    }

    public function ratings(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_trip_ratings')
            ->withPivot('rating');
    }

    public function locals(): hasMany
    {
        return $this->hasMany(Local::class);
    }

    public function isSharedScope($query)
    {
        return $query->where('shared', true);
    }
}
