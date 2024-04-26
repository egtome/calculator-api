<?php

namespace Database\Seeders;

use App\Models\Operation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OperationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $operationsData = [
            [
                'id' => 1,
                'type' => 'addition',
                'cost' => 150,
                'created_at' => now(),
            ],
            [
                'id' => 2,
                'type' => 'subtraction',
                'cost' => 300,
                'created_at' => now(),
            ],
            [
                'id' => 3,
                'type' => 'multiplication',
                'cost' => 450,
                'created_at' => now(),
            ],
            [
                'id' => 4,
                'type' => 'division',
                'cost' => 600,
                'created_at' => now(),
            ],
            [
                'id' => 5,
                'type' => 'square_root',
                'cost' => 750,
                'created_at' => now(),
            ],
            [
                'id' => 6,
                'type' => 'random_string',
                'cost' => 900,
                'created_at' => now(),
            ],        
        ];

        Operation::insert($operationsData);
    }
}
