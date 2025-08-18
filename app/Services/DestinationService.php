<?php

namespace App\Services;

use App\Models\Destination;

class DestinationService
{
    public static function all(): array
    {
        $destinations = [];

        $destinations = Destination::all()->map(function ($destination) {
            if($destination->airport === null) {
                $destination->airport = 'N/A';
            }
            return [
                'value' => $destination->id,
                'label' => "{$destination->city} - {$destination->state} ({$destination->airport})",
            ];
        })->toArray();

       return $destinations;
    }
}