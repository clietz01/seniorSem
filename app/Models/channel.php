<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class channel extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description', 'slogan', 'latitude', 'longitude', 'radius'];

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


    public function isWithinRadius($userLat, $userLong){

        if (!$this->latitude || !$this->longitude || !$this->radius){
            return false;
        }

        $distance = $this->haversine($userLat, $userLong, $this->latitude, $this->longitude);
        return $distance <= $this->radius;
    }


    private function haversine($lat1, $lng1, $lat2, $lng2)
    {
        $earthRadius = 6371; // Kilometers
        $latDiff = deg2rad($lat2 - $lat1);
        $lngDiff = deg2rad($lng2 - $lng1);

        $a = sin($latDiff / 2) * sin($latDiff / 2) +
             cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
             sin($lngDiff / 2) * sin($lngDiff / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return $earthRadius * $c;
    }



}
