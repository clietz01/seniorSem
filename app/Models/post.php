<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class post extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'body', 'user_id', 'channel_id'];

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function channel(){
        return $this->belongsTo(channel::class);
    }

    public function replies(){
        return $this->hasMany(reply::class);
    }

    public function getAnonymousUsernameAttribute(){
        return $this->channel->users()->
        where('users.id', $this->user_id)->
        first()->pivot->anonymous_username ?? 'Anonymous';
    }

    public function likes(){
        return $this->hasMany(Postlike::class);
    }

    public function isLikedByBuyer($userId){

        return $this->like()->where('user_id', $userId)->exists();

    
    }

}
