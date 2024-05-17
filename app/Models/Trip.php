<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Trip extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'country',
        'locations',
        'date',
        'description',
        'latitude',
        'longitude',
        'image',
        'shared',
    ];

    protected $casts = [
        'date' => 'datetime',
    ];

    public function user(): belongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function locals(): hasMany
    {
        return $this->hasMany(Local::class);
    }
}
