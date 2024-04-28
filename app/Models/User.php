<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const INVALIDATE_TOKEN_IF_INACTIVE_IN_MINUTES = 120;
    const DEFAULT_BALANCE = 10000;
    const DEFAULT_ACTIVE_STATUS = true; 

    protected $fillable = [
        'email',
        'password',
        'active',
        'balance',
        'last_activity',
        'created_at',
        'updated_at',   
    ];

    protected $hidden = [
        'password',
    ];

    public function userOperations(){
        return $this->hasMany(UserOperation::class, 'user_id', 'id');
    }    
}
