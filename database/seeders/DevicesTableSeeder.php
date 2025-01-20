<?php

namespace Database\Seeders;

use App\Models\Device;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DevicesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Device::create([
            'name' => 'Router 1',
            'icon' => 'prise.png',
            'type' => 'router',
            'description' => 'Main router for the office',
            'status' => 'active',
            'ip_address' => '192.168.1.1',
            'model' => 'Cisco XYZ',
            'serial_number' => '123456789',
        ]);

        Device::create([
            'name' => 'Switch 1',
            'icon' => 'switch.png',
            'type' => 'switch',
            'description' => '24-port switch',
            'status' => 'active',
            'ip_address' => '192.168.1.2',
            'model' => 'Netgear ABC',
            'serial_number' => '987654321',
        ]);

        Device::create([
            'name' => 'Switch 1',
            'icon' => 'switch.png',
            'type' => 'switch',
            'description' => '24-port switch',
            'status' => 'active',
            'ip_address' => '192.168.1.2',
            'model' => 'Netgear ABC',
            'serial_number' => '987654321',
        ]);

        Device::create([
            'name' => 'Switch 1',
            'icon' => 'switch.png',
            'type' => 'switch',
            'description' => '24-port switch',
            'status' => 'active',
            'ip_address' => '192.168.1.2',
            'model' => 'Netgear ABC',
            'serial_number' => '987654321',
        ]);

        Device::create([
            'name' => 'Switch 1',
            'icon' => 'switch.png',
            'type' => 'switch',
            'description' => '24-port switch',
            'status' => 'active',
            'ip_address' => '192.168.1.2',
            'model' => 'Netgear ABC',
            'serial_number' => '987654321',
        ]);
    }
}
