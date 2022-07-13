<?php

namespace App\Http\Repositories;

use App\Car;
use App\CarPart;

class CarRepository
{
    /**
     * create car
     * @param $request
     * @return void
     */
    public function create($request)
    {
        $car = Car::create($request->all('name', 'registration_number', 'is_registered'));
        if(!empty($request->parts)) {
            $car->parts()->delete();
            $this->saveParts($car, $request);
        }
    }

    /**
     * update car
     * @param $car
     * @param $request
     * @return void
     */
    public function update($car, $request)
    {
        $car->fill($request->all('name', 'registration_number', 'is_registered'))->save();
        if(!empty($request->parts)) {
            $car->parts()->delete();
            $this->saveParts($car, $request);
        }
    }

    /**
     * create car parts
     * @param $car
     * @param $request
     * @return void
     */
    private function saveParts($car, $request)
    {
        foreach ($request->parts as $part) {
            if($part['name'] && $part['serial_number']) {
                $part['car_id'] = $car->id;
                CarPart::create($part);
            }
        }
    }
}
