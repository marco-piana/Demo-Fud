<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

// Brij Negi Update
class UserViewer extends Authenticatable
{
    use HasFactory;
    protected $table = 'user_viewer';
    protected $fillable = [
        'name',
        'email',
        'password',
        'company_id',
        'email_verification_token',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
