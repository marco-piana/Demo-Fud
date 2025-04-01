<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QRTemplateModel extends Model
{
    use HasFactory;

    protected $table = 'qr_template';

    protected $fillable = ['path', 'restaurant_id'];

}
