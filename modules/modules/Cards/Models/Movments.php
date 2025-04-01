<?php

namespace Modules\Cards\Models;

use Illuminate\Database\Eloquent\Model;


class Movments extends Model 
{

 

    protected $table = 'loyaltymovments';
    public $guarded = [];


    public function card()
    {
        return $this->belongsTo(Card::class, 'loyalycard_id');
    }

    public function vendor()
    {
        return $this->belongsTo(\App\Restorant::class, 'vendor_id');
    }

    
    public function staff()
    {
        return $this->belongsTo(\App\User::class, 'staff_id');
    }
}
