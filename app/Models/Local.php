<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Local extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'trip_id',
        'local_type_id',
        'name',
        'latitude',
        'longitude',
        'description',
        'date',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function trip(): belongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function localType(): belongsTo
    {
        return $this->belongsTo(LocalType::class);
    }

    public function medias(): hasMany
    {
        return $this->hasMany(Media::class);
    }
}
