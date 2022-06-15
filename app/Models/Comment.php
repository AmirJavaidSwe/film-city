<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    /* Laravel fillable properties for mass assignment values */
    protected $fillable = [
        'film_id',
        'user_id',
        'comment_id',
        'comment',
    ];


    // fetch user who post this comment with below fuction

    public function user() {
        return $this->belongsTo(User::class);
    }

    
    // fetch comments reply with below fuction

    public function childs() {
        return $this->hasMany(static::class, 'comment_id');
      }
}
