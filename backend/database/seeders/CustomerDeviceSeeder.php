<?php

namespace Database\Seeders;

use App\Models\Customer;
use App\Models\Device;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CustomerDeviceSeeder extends Seeder
{
    public function run()
    {
        // Daftar customer contoh
        $customers = [
            ['nama' => 'Niken', 'nomor_pelanggan' => 'CUST001', 'alamat' => 'Jakarta'],
            ['nama' => 'Bryan', 'nomor_pelanggan' => 'CUST002', 'alamat' => 'Bandung'],
            ['nama' => 'Silvia', 'nomor_pelanggan' => 'CUST003', 'alamat' => 'Surabaya'],
        ];

        foreach ($customers as $cust) {
            // Jika customer sudah ada berdasarkan nomor_pelanggan, gunakan yang ada
            $customer = Customer::firstOrCreate(
                ['nomor_pelanggan' => $cust['nomor_pelanggan']],
                [
                    'nama' => $cust['nama'],
                    'alamat' => $cust['alamat']
                ]
            );

            // Buat 2 device per customer, jika serial_number belum ada
            for ($i = 1; $i <= 2; $i++) {
                Device::firstOrCreate(
                    ['serial_number' => 'DEV' . $customer->id . sprintf("%02d", $i)],
                    [
                        'customer_id' => $customer->id,
                        'api_key' => Str::random(40)
                    ]
                );
            }
        }
    }
}
