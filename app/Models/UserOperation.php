<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\{Model,SoftDeletes};

class UserOperation extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
    protected $fillable = [
        'user_id',
        'operation_id',
        'amount',
        'user_balance',
        'operation_response',
        'created_at',
        'updated_at',        
    ];

    public function user(){
        return $this->belongsTo(User::class);
    }
   
    public function operation(){
        return $this->belongsTo(Operation::class);
    }
}
