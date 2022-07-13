<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CarPart extends Model
{
    use SoftDeletes;


    protected $table = 'car_parts';
    protected $fillable = ['car_id', 'serial_number', 'name'];

    public function car()
    {
        return $this->hasOne(Car::class, 'id', 'car_id');
    }

    public function scopeFilter($query, $filter)
    {
        if(isset($filter['name']) && $filter['name']) {
            $query = $query->where('name', 'like', "%$filter[name]%");
        }
        if(isset($filter['serial_number']) && $filter['serial_number']) {
            $query = $query->where('serial_number', 'like', "%$filter[serial_number]%");
        }
        if(isset($filter['car']) && $filter['car']) {
            $query = $query->where('car_id', $filter['car']);
        }

        return $query;
    }

}
