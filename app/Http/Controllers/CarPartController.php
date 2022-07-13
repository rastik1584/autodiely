<?php

namespace App\Http\Controllers;

use App\CarPart;
use App\Http\Requests\CarPartFromRequest;
use App\Transformers\CarPartTransformer;
use Illuminate\Http\Request;

class CarPartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return
     */
    public function index(Request $request)
    {
        return fractal(CarPart::filter($request->all())->get(), new CarPartTransformer());
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  CarPartFromRequest  $request
     * @return
     */
    public function store(CarPartFromRequest $request)
    {
        try {
            CarPart::create($request->all('name', 'serial_number', 'car_id'));
            return response(['message' => trans('car.successfully_saved')]);
        } catch(\Exception $e) {
            return response(['error' => trans('car.error')],500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CarPart  $carPart
     * @return \Illuminate\Http\Response
     */
    public function show(CarPart $carPart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CarPart  $carPart
     * @return
     */
    public function edit(CarPart $carPart)
    {
        return fractal($carPart, new CarPartTransformer());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  CarPartFromRequest $request
     * @param  \App\CarPart  $carPart
     * @return \Illuminate\Http\Response
     */
    public function update(CarPartFromRequest $request, CarPart $carPart)
    {
        try {
            $carPart->fill($request->all('name', 'serial_number', 'car_id'))->save();
            return response(['message' => trans('car.successfully_saved')]);
        } catch(\Exception $e) {
            return response(['error' => trans('car.error')],500);
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CarPart  $carPart
     * @return \Illuminate\Http\Response
     */
    public function destroy(CarPart $carPart)
    {
        try {
            $carPart->delete();
            return response(['message' => trans('car.success_delete')]);
        } catch(\Exception $e) {
            return response(['message' => trans('car.error')],500);
        }
    }
}
