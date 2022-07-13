<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Car extends Model
{
    use SoftDeletes;


    protected $table = 'cars';
    protected $fillable = ['name', 'registration_number', 'is_registered'];

    public function parts()
    {
        return $this->hasMany(CarPart::class, 'car_id', 'id');
    }

    public function scopeFilter($query, $filters)
    {
        if(isset($filters['name']) && $filters['name']) {
            $query = $query->orWhere('name', 'like', "%$filters[name]%");
        }
        if(isset($filters['registrationNumber']) && $filters['registrationNumber']) {
            $query = $query->where('registration_number', 'like', "%$filters[registrationNumber]%");
        }
        if(isset($filters['is_registered']) && $filters['is_registered']) {
            $query = $query->where('is_registered', $filters['is_registered'] == 'true' ? 1 : 0);
        }
        return $query;
    }
}
