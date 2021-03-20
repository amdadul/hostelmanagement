<?php

namespace App\Modules\Accounts\Database\Seeds;

use App\Modules\Accounts\Models\ExpenseType;
use Illuminate\Database\Seeder;

class expenseTypeTableSeeder extends Seeder
{

    protected $expenseTypes = [
        [
            'root_id' => null,
            'name' => 'Root',
            'description' => 'This is a root expense type'
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->expenseTypes as $index => $expenseType) {
            $result = ExpenseType::create($expenseType);
            if (!$result) {
                $this->command->info("Inserted at record $index.");
                return;
            }
            $this->command->info('Inserted '.count($this->expenseTypes) . ' records');
        }
    }
}

