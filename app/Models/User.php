<?php

namespace App\Models;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable, HasFactory;

    protected $table = 'users';

   
    public $timestamps = false; 

    protected $guarded = []; 

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }
//////////// JWT WILL RETURN THESE ATTRIBUTSE WITH TOKEN/////////////
    public function getJWTCustomClaims()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'id' => $this->id,
        ];
    }
}
