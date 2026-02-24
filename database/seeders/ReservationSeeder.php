<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ReservationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('settings')->insert([
            'id' => 1,
            'base_price' => 27.50,
            'extra_fee' => 5.00,
            'player_limit' => 4,
            'created_at' => now(),
            'updated_at' => now(),
            'member_discount' => 0.20,
            'super_member_discount' => 0.50,
            'child' => 1.00,
            'youth' => 0.50,
            'greenfee' => 0.00
        ]);
    }
}
