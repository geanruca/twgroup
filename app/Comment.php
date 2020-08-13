<?php

namespace App;

use App\User;
use App\Publication;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $fillable = ['user_id', 'publication_id', 'content', 'status'];
    public function user()
    {
        return $this->belongsTo(User::class,'user_id','id');
    }
    public function publication()
    {
        return $this->belongsTo(Publication::class,'publication_id','id');
    }
}
