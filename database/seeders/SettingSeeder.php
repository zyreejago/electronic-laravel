<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        Setting::setValue('ewallet_ovo_number', '081234567890');
        Setting::setValue('ewallet_dana_number', '081234567891');
        Setting::setValue('ewallet_gopay_number', '081234567892');
        Setting::setValue('ewallet_spay_number', '081234567893');
    }
} 