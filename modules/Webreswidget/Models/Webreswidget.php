<?php

namespace Modules\Webreswidget\Models;

use App\Models\MyModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Webreswidget extends MyModel
{
    use HasFactory;

    //protected $guarded= [];
    
    protected $imagePath = '/uploads/companies/';

    public function getImageLinkAttribute()
    {
        return $this->getImage($this->logo, "");
    }
}
