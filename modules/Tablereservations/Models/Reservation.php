<?php

namespace Modules\Tablereservations\Models;

use App\Scopes\CompanyScope;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Reservation extends Model
{
    use HasFactory;

    protected $fillable = [];

    //Customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    //Company
    public function company()
    {
        return $this->belongsTo(\App\Models\Company::class);
    }

    //Table
    public function table()
    {
        return $this->belongsTo(\Modules\Floorplan\Models\Tables::class);
    }

    //Relative time of reservation using Carbon
    public function getRelativeTimeAttribute()
    {
        //Using  $this->reservation_date and  $this->reservation_time, show data in a relative time format using Carbon
        return \Carbon\Carbon::parse($this->reservation_date.' '.$this->reservation_time)->toDayDateTimeString();
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Tablereservations\Database\Factories\Reservation::new();
    }

    protected static function booted(){
        static::addGlobalScope(new CompanyScope);

        static::creating(function ($model){
            $company_id=session('company_id',null);
            if($company_id){
                $model->company_id=$company_id;
            }
        });

        //On create or update, set the expected_leave timestamp based on the reservation_time and the expected_occupancy minutes, onSave on onUpdate
        static::saving(function ($model){
            $model->expected_leave = \Carbon\Carbon::parse($model->reservation_date.' '.$model->reservation_time)->addMinutes($model->expected_occupancy);
        });
    }

   

}
