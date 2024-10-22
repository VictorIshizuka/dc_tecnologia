<?php

namespace Database\Seeders;

use App\Models\PaymentType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $paymentTypes = [
            ['name' => 'Cartão de Crédito'],
            ['name' => 'Boleto Bancário'],
            ['name' => 'Pix'],
            ['name' => 'Transferência Bancária'],
            ['name' => 'Dinheiro'],
            ['name' => 'Parcelado']

        ];

        foreach ($paymentTypes as $type) {
            PaymentType::create($type);
        }
    }
}