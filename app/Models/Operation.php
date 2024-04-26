<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    use HasFactory;

    const OPERATION_ADDITION_ID = 1;
    const OPERATION_SUBSTRACTION_ID = 2;
    const OPERATION_MULTIPLICATION_ID = 3;
    const OPERATION_DIVISION_ID = 4;
    const OPERATION_SQUARE_ROOT_ID = 5;
    const OPERATION_RANDOM_STRING_ID = 6;

    protected $fillable = [
        'type',
        'cost',
        'created_at',
        'updated_at',
    ];

    public function userOperations(){
        return $this->hasMany(UserOperation::class, 'operation_id', 'id');
    }
}
