<?php

namespace Modules\Cards\Models;

use Illuminate\Database\Eloquent\Model;


class Card extends Model 
{

 

    protected $table = 'loyalycards';
    public $guarded = [];


    public function client()
    {
        return $this->belongsTo(\App\User::class, 'client_id');
    }

    public function vendor()
    {
        return $this->belongsTo(\App\Restorant::class, 'vendor_id');
    }

    public function movments()
    {
        //Create hasMany relationship with Movments
        return $this->hasMany(\Modules\Cards\Models\Movments::class, 'loyalycard_id');
    }
}
