<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AfcSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('afcs')->insert([
            ['nombre' => 'Porvenir', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Protección', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Colfondos', 'created_at' => now(), 'updated_at' => now()],
            ['nombre' => 'Old Mutual', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
