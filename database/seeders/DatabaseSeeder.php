<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Client;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Product;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            ServiceCategorySeeder::class,
            TemplateBlockSeeder::class,
            JobSeeder::class,
            JobApplicationSeeder::class,
        ]);

        // Seed roles and permissions first
        $this->call([RoleAndPermissionSeeder::class, UserSeeder::class]);

        // Create 50 clients
        Client::factory(50)->create();

        // Create 100 products
        $products = Product::factory(100)->create();

        // Create 200 invoices with 1-5 items each
        Client::factory(50)->create()->each(function ($client) use ($products) {
            // Create 4 invoices per client (200 total)
            Invoice::factory(4)->create([
                'client_id' => $client->id,
            ])->each(function ($invoice) use ($products) {
                // Create 1-5 items per invoice
                $numItems = rand(1, 5);
                $randomProducts = $products->random($numItems);

                foreach ($randomProducts as $product) {
                    $quantity = rand(1, 5);
                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'product_id' => $product->id,
                        'description' => $product->name,
                        'quantity' => $quantity,
                        'price' => $product->price,
                        'total' => $product->price * $quantity,
                    ]);
                }

                // Recalculate invoice totals
                $subtotal = $invoice->items()->sum('total');
                $taxAmount = $subtotal * 0.14;
                $total = $subtotal + $taxAmount;

                $invoice->update([
                    'subtotal' => $subtotal,
                    'tax_amount' => $taxAmount,
                    'total' => $total,
                ]);
            });
        });
    }
}
