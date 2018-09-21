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
        // Order Mangers
        DB::table('users')->insert([
            'name' => 'Order Manager 1',
            'email' => 'ordermanager1@app.com',
            'password' => bcrypt('admin'),
            'isAdmin' => true,
            'role' => 'order',
        ]);
        DB::table('users')->insert([
            'name' => 'Order Manager 2',
            'email' => 'ordermanager2@app.com',
            'password' => bcrypt('admin'),
            'isAdmin' => true,
            'role' => 'order',
        ]);
        DB::table('users')->insert([
            'name' => 'Order Manager 3',
            'email' => 'ordermanager3@app.com',
            'password' => bcrypt('admin'),
            'isAdmin' => true,
            'role' => 'order',
        ]);
        // Shipping Managers
        DB::table('users')->insert([
            'name' => 'Shipping Manager 1',
            'email' => 'shippingmanager1@app.com',
            'password' => bcrypt('admin'),
            'isAdmin' => true,
            'role' => 'shipping'
        ]);
        DB::table('users')->insert([
            'name' => 'Shipping Manager 2',
            'email' => 'shippingmanager2@app.com',
            'password' => bcrypt('admin'),
            'isAdmin' => true,
            'role' => 'shipping'
        ]);
        DB::table('users')->insert([
            'name' => 'Shipping Manager 3',
            'email' => 'shippingmanager3@app.com',
            'password' => bcrypt('admin'),
            'isAdmin' => true,
            'role' => 'shipping'
        ]);
        // Delivery Managers
        DB::table('users')->insert([
            'name' => 'Delivery Manager 1',
            'email' => 'deliverymanager1@app.com',
            'password' => bcrypt('admin'),
            'isAdmin' => true,
            'role' => 'delivery'
        ]);
        DB::table('users')->insert([
            'name' => 'Delivery Manager 2',
            'email' => 'deliverymanager2@app.com',
            'password' => bcrypt('admin'),
            'isAdmin' => true,
            'role' => 'delivery'
        ]);
        DB::table('users')->insert([
            'name' => 'Delivery Manager 3',
            'email' => 'deliverymanager3@app.com',
            'password' => bcrypt('admin'),
            'isAdmin' => true,
            'role' => 'delivery'
        ]);
        // Customer
        DB::table('users')->insert([
            'name' => 'Customer',
            'email' => 'customer@app.com',
            'password' => bcrypt('customer'),
        ]);
    }
}
