<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\User;

class Comment extends Model
{
    protected $guarded = [];
    // create a relationship between comment's table user id to  user table id
    public function creator(){
        return $this->belongsTo(User::class,'user_id');
    }
}
