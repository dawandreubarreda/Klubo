<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = ['news_post_id', 'user_id', 'content'];

    // Relaciones
    public function newsPost()
    {
        return $this->belongsTo(NewsPost::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}