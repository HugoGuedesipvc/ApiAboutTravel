<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class LocalType extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        'label',
        'description',
    ];

    public function locals(): hasMany
    {
        return $this->hasMany(Local::class);
    }
}
