<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\BillDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BillSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bill::factory(10)->create()->each(function ($bill) {
            BillDetail::factory(fake()->numberBetween(1, 3))->create(['bill_id' => $bill->id]);
        });
    }
}
