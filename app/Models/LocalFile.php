<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocalFile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'local_id',
        'label',
        'path',
    ];

    protected $casts = [
        'local_id' => 'integer',
    ];
    
    protected $appends = [
        'url'
    ];

    public function getUrlAttribute(): string
    {
        return asset($this->path);
    }
}
