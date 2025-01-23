<?php

namespace Database\Seeders;

use App\Models\Networks;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NetworkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Networks::create([
            'name' => 'Office Network',
            'image' => 'office-network.jpg',
            'description' => 'The main network for the office building.',
        ]);

        Networks::create([
            'name' => 'Warehouse Network',
            'image' => 'warehouse-network.jpg',
            'description' => 'The network for the warehouse facility.',
        ]);

        Networks::create([
            'name' => 'Guest Network',
            'image' => 'guest-network.jpg',
            'description' => 'The network for guests and visitors.',
        ]);
    }
}
