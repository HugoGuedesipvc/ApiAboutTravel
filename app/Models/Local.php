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
        'label',
        'latitude',
        'longitude',
        'description',
        'date',
    ];

    protected $casts = [
        'trip_id' => 'integer',
        'local_type_id' => 'integer',
        'date' => 'datetime',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    public function trip(): belongsTo
    {
        return $this->belongsTo(Trip::class);
    }

    public function localType(): belongsTo
    {
        return $this->belongsTo(LocalType::class);
    }

    public function localFiles(): hasMany
    {
        return $this->hasMany(LocalFile::class);
    }
}
