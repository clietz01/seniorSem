<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class channel extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'slogan', 'user_id'];

    public function post(){
        return $this->hasMany(post::class);
        //
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
