<?php

namespace Modules\Cards\Listeners;

use App\Models\User;
use App\Restorant;
use Modules\Cards\Models\Categories;
use Modules\Cards\Models\Movments;
use Modules\Cards\Models\Card;

class AssignPointsOnOrder
{

    public function handleOrderAcceptedByVendor($event){
        $order=$event->order;
        $vendor=Restorant::findOrFail($order->restorant_id);
        $client=$order->client;

        if($client==null){
            //In case, client is null, we still need to check if the order is from a client with card ID
            if($order->getConfig('loyalty_card','')!=''){
                //Find the card
                $card=Card::where('card_id',$order->getConfig('loyalty_card',''))->first();
                if($card){
                    $client=$card->client;
                }
            }
        }

       

        if($client){
           //Calculate value of order per different categories
            $orderValue=0;    
            $orderValuePerCategory=[];
            foreach($order->items as $item){
                if(!isset($orderValuePerCategory[$item->category->id])){
                    $orderValuePerCategory[$item->category->id]=0;
                }
                $orderValuePerCategory[$item->category->id]+=$item->pivot->qty*($item->pivot->variant_price?$item->pivot->variant_price:$item->price);
            }

            //TODO -- Calculate values from extras

            //Fetch points distributions per category
            $pointsDistribution=Categories::where('company_id',$vendor->id)->get()->toArray();


            //Calculate points total and per category
            $pointsTotal=0;
            $pointsPerCategory=[];
            foreach($orderValuePerCategory as $categoryID=>$value){
                $pointsPerCategory[$categoryID]=0;

                foreach ($pointsDistribution as $key => $pd) {
                    if($pd['id']==$categoryID){
                        //Calcualte percent points
                        $pointsPerCategory[$categoryID]+=($value/100)*$pd['percent'];
                        if($pd['threshold']<=$value){
                            $pointsPerCategory[$categoryID]+=$pd['staticpoints'];
                        }
                    }
                }
                $pointsTotal+=$pointsPerCategory[$categoryID];
            }

            //Find or create the card
            $card=Card::firstOrCreate([
                'client_id'=>$client->id,
                'vendor_id'=>$vendor->id
            ]);

            //Create a movment in the points table
            Movments::create([
                'loyalycard_id'=>$card->id,
                'vendor_id'=>$vendor->id,
                'value'=>$pointsTotal,
                'order_id'=>$order->id,
                'order_value'=>$order->order_price+$order->delivery_price,
                'type'=>1,
                'newstate'=>$card->points+$pointsTotal
            ]);
            $card->points=$card->points+$pointsTotal;
            $card->save();

        }

       

        
    }


    public function subscribe($events)
    {
        $events->listen(
            'App\Events\OrderAcceptedByVendor',
            [AssignPointsOnOrder::class, 'handleOrderAcceptedByVendor']
        );
    }
}