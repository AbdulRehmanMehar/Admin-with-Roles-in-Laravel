<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // Order Manger
        DB::table('users')->insert([
            'name' => 'Order Manager',
            'email' => 'ordermanager@app.com',
            'password' => bcrypt('admin'),
            'isAdmin' => true,
            'role' => 'order'
        ]);
        // Shipping Manager
        DB::table('users')->insert([
            'name' => 'Shipping Manager',
            'email' => 'shippingmanager@app.com',
            'password' => bcrypt('admin'),
            'isAdmin' => true,
            'role' => 'shipping'
        ]);
        // Delivery manager
        DB::table('users')->insert([
            'name' => 'Delivery Manager',
            'email' => 'deliverymanager@app.com',
            'password' => bcrypt('admin'),
            'isAdmin' => true,
            'role' => 'delivery'
        ]);

    }
}
