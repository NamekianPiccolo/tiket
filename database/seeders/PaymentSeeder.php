<?php

namespace Database\Seeders;

use App\Models\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    public function run()
    {
        // Buat 50 data pembayaran dummy
        Payment::factory()->count(50)->create();

        // Buat beberapa data dengan status spesifik untuk testing
        Payment::factory()->create([
            'order_id' => 'PYMT-TEST-SUCCESS',
            'status' => 'success',
            'amount' => 500000,
            'customer_name' => 'John Doe (Test Success)',
            'customer_email' => 'success@example.com',
        ]);

        Payment::factory()->create([
            'order_id' => 'PYMT-TEST-PENDING',
            'status' => 'pending',
            'amount' => 250000,
            'customer_name' => 'Jane Smith (Test Pending)',
            'customer_email' => 'pending@example.com',
        ]);

        Payment::factory()->create([
            'order_id' => 'PYMT-TEST-FAILED',
            'status' => 'failed',
            'amount' => 100000,
            'customer_name' => 'Bob Johnson (Test Failed)',
            'customer_email' => 'failed@example.com',
        ]);
    }
}
