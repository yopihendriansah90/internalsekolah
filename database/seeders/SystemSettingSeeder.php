<?php

namespace Database\Seeders;

use App\Enums\SystemSettingKeyEnum;
use App\Models\SystemSetting;
use Illuminate\Database\Seeder;

class SystemSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SystemSetting::putValue(SystemSettingKeyEnum::AppInitialized, false, 'boolean');
        SystemSetting::putValue(SystemSettingKeyEnum::DefaultLocale, 'id', 'string', true);
        SystemSetting::putValue(SystemSettingKeyEnum::AllowSchoolTypeChange, true, 'boolean');
        SystemSetting::putValue(SystemSettingKeyEnum::AcademicLabelOverrides, [], 'json');
    }
}
