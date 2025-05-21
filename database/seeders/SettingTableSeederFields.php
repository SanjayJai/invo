<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeederFields extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Setting::create([
            'key' => 'company_address',
            'value' => '185/18, Ani complex, Kamarajar Road, Karamadai, Coimbatore - 641104, Tamil Nadu, India.',
        ]);
        Setting::create(['key' => 'company_phone', 'value' => '+91 63794 53263']);
    }
}
