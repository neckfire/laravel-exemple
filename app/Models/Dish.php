<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Dish extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;
    protected $fillable = [
        'name',
        'recipe',
        'owner_id',
        'image'
    ];

    public function owner(): BelongsTo
    {
        return $this->belongsTo(User::class, 'owner_id');
    }

    public function likedBy(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'likes', 'dish_id', 'user_id');
    }

    public function likesCount(): int
    {
        return $this->hasMany(Like::class, 'dish_id')->count();
    }

    public function casts()
    {
        return [
            'recipe' => 'encrypted',
        ];
    }
}
