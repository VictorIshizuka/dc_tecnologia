<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $customers = [
            ['name' => 'João Silva', 'email' => 'joao.silva@gmail.com', "document" => "91380209000183", 'phone' => '11999999999'],
            ['name' => 'Maria Souza', 'email' => 'maria.souza@gmail.com', "document" => "92232555000187", 'phone' => '11988888888'],
            ['name' => 'Carlos Oliveira', 'email' => 'carlos.oliveira@gmail.com', "document" => "77334543000170", 'phone' => '11977777777'],
        ];
        foreach ($customers as $customer) {
            Customer::create($customer);
        }
    }
}
