<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Medicine;
use App\Models\Batch;
use App\Models\Transaction;
use App\Models\Saleitem;
use App\Models\Purchase;
use App\Models\PurchaseItem;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Seed role, permission, dan user
        $this->call([
            RolePermissionSeeder::class,
            CategorySeeder::class,
            AdminUserSeeder::class,
            KasirUserSeeder::class,
        ]);

        // 2. Seed medicine
        Medicine::factory(10)->create();

        // 3. Seed purchases beserta purchase_items dan batch
        $medicines = Medicine::all();

        Purchase::factory(20)->create()->each(function (Purchase $purchase) use ($medicines) {
            $selectedMedicines = $medicines->random(rand(1, 5));

            foreach ($selectedMedicines as $medicine) {
                $quantity = fake()->numberBetween(10, 100);
                $pricePerUnit = fake()->numberBetween(1000, 100000);
                $expiryDate = fake()->dateTimeBetween('now', '+2 years');

                // Buat purchase item tanpa expiration_date
                $purchaseItem = PurchaseItem::create([
                    'id' => Str::uuid(),
                    'purchase_id' => $purchase->id,
                    'medicine_id' => $medicine->id,
                    'quantity' => $quantity,
                    'price_per_unit' => $pricePerUnit,
                ]);

                // Buat batch dengan expiry_date
                Batch::factory()->create([
                    'medicine_id' => $medicine->id,
                    'purchase_item_id' => $purchaseItem->id,
                    'quantity' => $quantity,
                    'expiry_date' => $expiryDate,
                ]);
            }
        });

        // 4. Seed transaksi & saleitems
        $kasirs = User::role('kasir')->get();

        Transaction::factory(50)->make()->each(function ($tx) use ($kasirs) {
            $tx->user_id = $kasirs->random()->id;
            $tx->save();

            $batchIds = Batch::pluck('id')->toArray();
            $total = 0;

            foreach (range(1, rand(1, 5)) as $i) {
                $saleitem = Saleitem::factory()->create([
                    'transaction_id' => $tx->id,
                    'batch_id' => Arr::random($batchIds),
                ]);

                $total += $saleitem->subtotal;
            }

            $tx->update(['total_price' => $total]);
        });
    }
}
