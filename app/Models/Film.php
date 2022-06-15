<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;


class Film extends Model
{
    use HasFactory, Sluggable;


    /* Laravel fillable properties for mass assignment values */
    protected $fillable = [
        'name',
        'slug',
        'description',
        'release_date',
        'rating',
        'ticket_price',
        'country',
        'genre',
        'photo'
    ];

    protected $casts = [
        'release_date' => 'date:Y-m-d'
    ];
    protected $appends = ['photoSrc'];

    /**
     * Get all of the comments for the films.
     */
    public function comments() {
        return $this->hasMany(Comment::class)->whereNull('comment_id');
    }

    /**
     * Get the film's genre in array format.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */

     protected function genre(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => (Str::length($value) > 0) ? (Str::contains($value, ',') ? explode(',', $value) : [trim($value)]) : [],
        );
    }

    /**
     * Get the film's photo Src.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    
    protected function photoSrc(): Attribute
    {
        return new Attribute(
            get: fn () => Storage::url($this->photo) ?? null,
        );
    }

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name'
            ]
        ];
    }
}
