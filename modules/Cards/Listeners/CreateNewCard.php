<?php

namespace Modules\Cards\Listeners;
use Modules\Cards\Models\Card;

class CreateNewCard
{

    public function createCardForUser($event){
        $user=$event->user;
        $vendor=$event->vendor;

        //Create a card for the user
        $card=Card::create([
            'client_id'=>$user->id,
            'vendor_id'=>$vendor->id,
            'points'=>$vendor->getConfig('initial_loyalty_points',0),
            'card_id'=>rand(1000,9999)."-".rand(1000,9999)."-".rand(1000,9999)."-".rand(1000,9999),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        $card->save();
    }


    public function subscribe($events)
    {
        $events->listen(
            'App\Events\NewClient',
            [CreateNewCard::class, 'createCardForUser']
        );
    }
}