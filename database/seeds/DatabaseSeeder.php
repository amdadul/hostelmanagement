<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(\App\Modules\Config\Database\Seeds\lookupTableSeeder::class);
        $this->call(\App\Modules\Accounts\Database\Seeds\expenseTypeTableSeeder::class);
    }
}
