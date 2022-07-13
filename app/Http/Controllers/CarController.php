<?php

namespace App\Http\Controllers;

use App\Car;
use App\CarPart;
use App\Http\Repositories\CarRepository;
use App\Http\Requests\CarFromRequest;
use App\Transformers\CarFormTransformer;
use App\Transformers\CarTransformer;
use Illuminate\Http\Request;

class CarController extends Controller
{

    protected $repo;
    public function __construct(CarRepository $repo)
    {
        $this->repo = $repo;
    }

    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index(Request $request)
    {
        return [
            'filters' => $request->all(),
            'cars' => fractal(Car::filter($request->all())->get(), new CarTransformer()),
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CarFromRequest $request)
    {
        try {
            $this->repo->create($request);

            return response(['message' => trans('car.successfully_saved')]);
        } catch(\Exception $e) {
            return response(['error' => trans('car.error')],500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Car  $car
     * @return
     */
    public function edit(Car $car)
    {
        return fractal($car, new CarFormTransformer());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function update(CarFromRequest $request, Car $car)
    {
        try {
            $this->repo->update($car, $request);
            return response(['message' => trans('car.successfully_saved')]);
        } catch(\Exception $e) {
            return response(['error' => trans('car.error')],500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Car  $car
     * @return \Illuminate\Http\Response
     */
    public function destroy(Car $car)
    {
        try {
            $car->delete();
            return response(['message' => trans('car.success_delete')]);
        } catch(\Exception $e) {
            return response(['error' => trans('car.error')],500);
        }
    }
}
