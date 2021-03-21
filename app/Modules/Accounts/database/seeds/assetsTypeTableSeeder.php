<?php

namespace App\Modules\Accounts\Database\Seeds;

use App\Modules\Accounts\Models\AssetsType;
use Illuminate\Database\Seeder;

class assetsTypeTableSeeder extends Seeder
{

    protected $assetsTypes = [
        [
            'root_id' => null,
            'name' => 'Root',
            'description' => 'This is a root assets type'
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->assetsTypes as $index => $assetsType) {
            $result = AssetsType::create($assetsType);
            if (!$result) {
                $this->command->info("Inserted at record $index.");
                return;
            }
            $this->command->info('Inserted '.count($this->assetsTypes) . ' records');
        }
    }
}

