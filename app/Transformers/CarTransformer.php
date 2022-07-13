<?php

namespace App\Transformers;

use App\Car;
use League\Fractal\TransformerAbstract;

class CarTransformer extends TransformerAbstract
{

    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Car $car)
    {
        return [
            'id' => $car->id,
            'name' => $car->name,
            'registration_number' => $car->registration_number,
            'is_registered' => $car->is_registered ? true : false,
            'parts_count' => $car->parts()->count(),
        ];
    }
}
