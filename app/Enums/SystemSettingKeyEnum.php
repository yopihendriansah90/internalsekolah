<?php

namespace App\Enums;

enum SystemSettingKeyEnum: string
{
    case AppInitialized = 'app_initialized';
    case ActiveSchoolId = 'active_school_id';
    case DefaultLocale = 'default_locale';
    case AllowSchoolTypeChange = 'allow_school_type_change';
    case AcademicLabelOverrides = 'academic_label_overrides';
}
