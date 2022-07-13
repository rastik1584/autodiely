<?php

namespace App\Transformers;

use App\CarPart;
use League\Fractal\TransformerAbstract;

class CarPartTransformer extends TransformerAbstract
{


    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(CarPart $part)
    {
        return [
            'id' => $part->id,
            'name' => $part->name,
            'serial_number' => $part->serial_number,
            'car_name' => $part->car->name,
        ];
    }
}
