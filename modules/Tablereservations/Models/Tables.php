<?php


namespace Modules\Tablereservations\Models;

use Modules\Floorplan\Models\Tables as ModelsTables;

class Tables extends ModelsTables
{

    // Define the "reservations" relationship
    public function reservations()
    {
        return $this->hasMany(Reservation::class, 'table_id');
    }
    
}