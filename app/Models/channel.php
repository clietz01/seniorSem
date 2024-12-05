<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class channel extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'slogan'];

    public function post(){
        return $this->hasMany(post::class);
        //
    }

    public function users(){
        return $this->belongsToMany(User::class, 'hash_names')
        ->withPivot('anonymous_username')
        ->withTimestamps();
    }

    public function path(){
        return route('channels.show', $this);
    }
}
