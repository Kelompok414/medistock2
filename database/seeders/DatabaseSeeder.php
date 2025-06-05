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
        $this->call([
            RolePermissionSeeder::class,
            CategorySeeder::class,
            AdminUserSeeder::class,
            KasirUserSeeder::class
        ]);

        Medicine::factory()->count(10)->create();
        Batch::factory()->count(10)->create();

        Transaction::factory()
            ->count(50)
            ->create()
            ->each(function (Transaction $tx) {
                $batchIds = Batch::pluck('id')->toArray();
                $items = rand(1, 5);
                $total = 0;

                for ($i = 0; $i < $items; $i++) {
                    $saleitem = Saleitem::factory()->create([
                        'transaction_id' => $tx->id,
                        'batch_id' => $batchIds[array_rand($batchIds)],
                    ]);
                    $total += $saleitem->subtotal;
                }

                $tx->update(['total_price' => $total]);
            });
    }
}
