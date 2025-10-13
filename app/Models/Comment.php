<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //
    protected $fillable = ['news_id', 'title', 'content', 'author_id'];
    public function news() {
        return $this->belongsTo(News::class, 'news_id');
    }
    public function author() {
        return $this->belongsTo(User::class, 'author_id');
    
    }
}