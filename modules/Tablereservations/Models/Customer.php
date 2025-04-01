<?php

namespace Modules\Tablereservations\Models;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Contacts\Models\Contact;
use Illuminate\Notifications\Notifiable;

class Customer extends Contact
{
    use HasFactory;
    use Notifiable;

    protected $appends = ['gravatar'];

    public function getGravatarAttribute()
    {
        if($this->avatar){
            return $this->avatar;
        }
        return 'https://www.gravatar.com/avatar/'.md5(strtolower($this->email)).'?s=200&d=mp';
    }

    /**
     * Create a new factory instance for the model.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    protected static function newFactory()
    {
        return \Modules\Tablereservations\Database\Factories\Customer::new();
    }

  

}
