<?php

namespace App\Services;

use App\Enums\UserProfilesEnum;

class UserProfileService
{
    public static function all(): array
    {
        return collect(UserProfilesEnum::cases())->map(function ($profile) {
            return [
                'value' => $profile->value,
                'label' => $profile->label(),
            ];
        })->toArray();
    }
}