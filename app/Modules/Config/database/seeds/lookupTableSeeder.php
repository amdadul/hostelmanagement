<?php

namespace App\Modules\Config\Database\Seeds;

use App\Modules\Config\Models\lookup;
use Illuminate\Database\Seeder;

class lookupTableSeeder extends Seeder
{
    protected $lookups = [
        [
            'name' => 'Male',
            'type' => 'gender',
            'code' => '1'
        ],
        [
            'name' => 'Female',
            'type' => 'gender',
            'code' => '2'
        ],
        [
            'name' => 'Others',
            'type' => 'gender',
            'code' => '3'
        ],
        [
            'name' => 'Single',
            'type' => 'marital_status',
            'code' => '1'
        ],
        [
            'name' => 'Married',
            'type' => 'marital_status',
            'code' => '2'
        ],
        [
            'name' => 'Separated',
            'type' => 'marital_status',
            'code' => '3'
        ],
        [
            'name' => 'Islam',
            'type' => 'religion',
            'code' => '1'
        ],
        [
            'name' => 'Hinduism',
            'type' => 'religion',
            'code' => '2'
        ],
        [
            'name' => 'Cristian',
            'type' => 'religion',
            'code' => '3'
        ],
        [
            'name' => 'Cash',
            'type' => 'cash_credit',
            'code' => '1'
        ],
        [
            'name' => 'Credit',
            'type' => 'cash_credit',
            'code' => '2'
        ],
        [
            'name' => 'Cash',
            'type' => 'payment_method',
            'code' => '1'
        ],
        [
            'name' => 'Bkash',
            'type' => 'payment_method',
            'code' => '2'
        ],
        [
            'name' => 'Card',
            'type' => 'payment_method',
            'code' => '3'
        ],
        [
            'name' => 'Cheque',
            'type' => 'payment_method',
            'code' => '4'
        ],
        [
            'name' => 'Bank',
            'type' => 'payment_method',
            'code' => '5'
        ],
        [
            'name' => 'Brac Bank',
            'type' => 'bank',
            'code' => '1'
        ],
        [
            'name' => 'City Bank',
            'type' => 'bank',
            'code' => '2'
        ],
        [
            'name' => 'Prime Bank',
            'type' => 'bank',
            'code' => '3'
        ],
        [
            'name' => 'Dhaka Bank',
            'type' => 'bank',
            'code' => '4'
        ],
        [
            'name' => 'Eastern Bank',
            'type' => 'bank',
            'code' => '5'
        ],
        [
            'name' => 'Dutch Bangla Bank',
            'type' => 'bank',
            'code' => '6'
        ],
        [
            'name' => 'Student',
            'type' => 'profession',
            'code' => '1'
        ],
        [
            'name' => 'Service Holder',
            'type' => 'profession',
            'code' => '2'
        ],
        [
            'name' => 'Father',
            'type' => 'relation',
            'code' => '1'
        ],
        [
            'name' => 'mother',
            'type' => 'relation',
            'code' => '2'
        ],
        [
            'name' => 'brother',
            'type' => 'relation',
            'code' => '3'
        ],
        [
            'name' => 'sister',
            'type' => 'relation',
            'code' => '4'
        ],
        [
            'name' => 'uncle',
            'type' => 'relation',
            'code' => '5'
        ],
        [
            'name' => 'aunty',
            'type' => 'relation',
            'code' => '6'
        ],
        [
            'name' => 'cousin',
            'type' => 'relation',
            'code' => '7'
        ],
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        foreach ($this->lookups as $index => $lookup) {
            $result = lookup::create($lookup);
            if (!$result) {
                $this->command->info("Inserted at record $index.");
                return;
            }
            $this->command->info('Inserted '.count($this->lookups) . ' records');
        }
    }
}

