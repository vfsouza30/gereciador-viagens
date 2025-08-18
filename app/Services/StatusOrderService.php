<?php

namespace App\Services;

use App\Enums\StatusOrderEnum;

class StatusOrderService
{
    public static function all(): array
    {
        $all = collect(StatusOrderEnum::cases())->map(function ($status) {
            return [
                'value' => $status->value,
                'label' => $status->label(),
            ];
        })->toArray();
        
        array_unshift($all, [
            'value' => 'todos',
            'label' => 'Todos',
        ]);
        return $all;
    }
}