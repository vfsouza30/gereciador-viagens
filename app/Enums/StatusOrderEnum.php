<?php

namespace App\Enums;

enum StatusOrderEnum: string
{
    case REQUESTED =  'solicitado';
    case APPROVED = 'aprovado';
    case CANCELED = 'cancelado';

    public function label(): string
    {
        return match ($this) {
            self::REQUESTED => 'Solicitado',
            self::APPROVED => 'Aprovado',
            self::CANCELED => 'Cancelado',
        };
    }
}