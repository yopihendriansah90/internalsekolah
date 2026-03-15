<?php

namespace Database\Seeders;

use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemSetting::putValue('default_locale', 'id', 'string', true);
        SystemSetting::putValue('academic_label_overrides', [], 'json');
    }
}
