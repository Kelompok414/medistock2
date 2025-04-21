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
        Category::factory()->count(5)->create();
        Medicine::factory()->count(10)->create();
        Batch::factory()->count(10)->create();
        Transaction::factory()
            ->count(10)
            ->create()
            ->each(function (Transaction $tx) {
                $batchIds = Batch::pluck('id')->toArray();
                $items = rand(1, 5);

                for ($i = 0; $i < $items; $i++) {
                    Saleitem::factory()->create([
                        'transaction_id' => $tx->id,
                        'batch_id'       => $batchIds[array_rand($batchIds)],
                    ]);
                }
            });
    }
}
