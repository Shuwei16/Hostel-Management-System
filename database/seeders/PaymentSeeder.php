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

        //dummy data for payment registration records
        for($i=1; $i <= 800; $i++) {
            $paymentMethods = ['Online Banking', 'Card', 'E-Wallet'];
            $randomMethodIndex = mt_rand(0, count($paymentMethods) - 1);
            $paymentMethod = $paymentMethods[$randomMethodIndex];

            Payment::create([
                'registration_id' => $i,
                'receipt_no' => "R-" . str_pad($i, 6, '0', STR_PAD_LEFT),
                'amount' => 1000.00,
                'payment_method' => $paymentMethod
            ]);
        }
    }
}
