<?php

namespace App\Enums;

enum UserProfilesEnum: string
{
    case ADMIN =  'administrador';
    case CLIENT = 'cliente';    

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrador',
            self::CLIENT => 'Cliente',
        };
    }
}