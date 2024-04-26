<?php

namespace App\Services;

use App\Models\Operation;
use Illuminate\Support\Collection;

class OperationService
{
    public function getAll(): Collection
    {
        return Operation::all();
    }

    public function getById(int $operationId): Operation
    {
        return Operation::find($operationId);
    }     
}