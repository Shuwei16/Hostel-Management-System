<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Payment;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Payment::create([
            'registration_id' => 1,
            'receipt_no' => "R-000001",
            'amount' => 100.00,
            'payment_method' => "Online Banking"
        ]);
    }
}
