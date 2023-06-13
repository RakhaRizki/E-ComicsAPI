<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class posts extends Model
{
    use HasFactory, SoftDeletes;

       protected $fillable = [
        'title',
        'sinopsis_komik',
        'cover_komik',
        'author',
    ];

    public function writer(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author', 'id');
    }

    public function comments(): HasMany
    {
        return $this->hasMany(Comments::class, 'post_id', 'id');
    }

}
