<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use App\Models\Medicine;
use App\Models\Batch;
use App\Models\Transaction;
use App\Models\Saleitem;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // 1) Categories
        Category::factory()->count(5)->create();

        // 2) Medicines (each will get a random category via the factory)
        Medicine::factory()->count(20)->create();

        // 3) Batches (each will get a random medicine via the factory)
        Batch::factory()->count(50)->create();

        // 4) Transactions + SaleItems
        Transaction::factory()
            ->count(30)
            ->create()
            ->each(function ($tx) {
                // grab all existing batch IDs
                $batchIds = Batch::pluck('id')->toArray();
                // choose 1–5 items per transaction
                $itemCount = rand(1, 5);

                for ($i = 0; $i < $itemCount; $i++) {
                    Saleitem::factory()->create([
                        'transaction_id' => $tx->id,
                        // pick a random existing batch
                        'batch_id'       => $batchIds[array_rand($batchIds)],
                    ]);
                }
            });
    }
}
