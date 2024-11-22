<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class reply extends Model
{
    use HasFactory;
    protected $fillable = ['post_id', 'user_id', 'content', 'parent_id'];

    public function post(){
        return $this->belongsTo(post::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function parent(){
        return $this->belongsTo(reply::class, 'parent_id');
    }

    public function replies(){
        return $this->hasMany(reply::class, 'parent_id');
    }
}
