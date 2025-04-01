<?php

namespace Modules\Cards\Providers;

use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;
use Modules\Cards\Listeners\AssignPointsOnOrder;
use Modules\Cards\Listeners\CreateNewCard;

class Event extends ServiceProvider
{
    protected $listen = [];

    protected $subscribe = [
        AssignPointsOnOrder::class,
        CreateNewCard::class
    ];
}