<?php

namespace App;

use App\Comment;
use Illuminate\Database\Eloquent\Model;

class Publication extends Model
{
    protected $fillable = ['content', 'title', 'user_id'];

    public function comments()
    {
        return $this->hasMany(Comment::class,'publication_id','id');
    }
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }


}
