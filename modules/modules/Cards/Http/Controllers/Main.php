<?php

namespace Modules\Cards\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Cards\Models\Categories;
use Modules\Cards\Models\Movments;
use Modules\Cards\Models\Card;
use App\Models\Posts;
use App\Coupons;
use App\Restorant;
use Illuminate\Support\Str;
use Modules\Cards\Notifications\LoyaltyPointsRemoved;

class Main extends Controller
{

    //Show form for adding points to a user
     public function showPointGiveForm(){
        $vendor=$this->getRestaurant();
        $categories=Categories::where('restorant_id',$vendor->id)->get();
        //This vendor's cards
        $cards=Card::where('vendor_id',$vendor->id)->orderBy('id','desc')->with('client')->get();
        $userList=[];
        foreach($cards as $card){
          $userList[$card->id]=$card->card_id." -- ".$card->client->name." - ".$card->points." ".__('points');
        }
        $userFields=[
          ['ftype'=>'select','classselect'=>'widder','editclass'=>'col-6','name'=>"Client", 'id'=>'card_id', 'data'=>$userList, 'required'=>true],
          ['ftype'=>'input','editclass'=>'col-4','name'=>"Order ID", 'id'=>'order_id', 'placeholder'=>__('Order id or internal reference number'), 'required'=>true],
          ['ftype'=>'input','editclass'=>'col-4','name'=>"Order value", 'id'=>'order_value', 'placeholder'=>__('Order value'), 'required'=>true],
          ['ftype'=>'input','editclass'=>'col-4','name'=>"Points", 'id'=>'points', 'placeholder'=>__('Points to give to user'), 'required'=>true]
        ];
        
        if(isset($_GET['card'])){
          $userFields[0]['value']=$_GET['card'];
        }
        return view('cards::points.givepoints',['categories'=>$categories,'userFields'=>['fields'=>$userFields],'vendor'=>$vendor]);
     }

     //Shoer form for removing points from a user
     public function showPointRemoveForm(){
          $vendor=$this->getRestaurant();


          //This vendor's cards
          $cards=Card::where('vendor_id',$vendor->id)->with('client')->get();
          $userList=[];
          foreach($cards as $card){
               $userList[$card->id]=$card->card_id." -- ".$card->client->name." - ".$card->points." ".__('points');
          }
         

          //Get list of awards
          $awards=Posts::where('vendor_id',$vendor->id)
          ->where('post_type','reward')
          ->where('active_to','>',now())
          ->get();
          //Create list of awards
          $awardsList=[];
          foreach($awards as $award){
               $awardsList[$award->id]=$award->title." - ".$award->points." ".__('points');
          }

          $fields=[
               ['ftype'=>'select','editclass'=>'col-6','name'=>"Client", 'id'=>'card_id', 'data'=>$userList, 'required'=>true],
               ['ftype'=>'select','editclass'=>'col-2','name'=>"Award", 'id'=>'award_id', 'data'=>$awardsList, 'required'=>true]
          ];

          return view('cards::points.removepoints',['userFields'=>['fields'=>$fields]]);
     }

     //Show the form for giving points to a user
     public function givePoints(Request $request)
     {
          $vendor=$this->getRestaurant();
          $points = $request->points;
          $card = Card::where('id', $request->card_id)->where('vendor_id', $vendor->id)->first();
          if ($card) {
               $card->points = $card->points + $points;
               $card->save();
               $movment = new Movments();
               $movment->loyalycard_id = $card->id;
               $movment->vendor_id = $vendor->id;
               $movment->value = $points;
               $movment->order_id = $request->order_id;
               $movment->order_value = $request->order_value;
               $movment->type = 1;
               $movment->staff_id = auth()->user()->id;
               $movment->save();

               //Submit to webhooks
               $doc=[
                    'card_id'=>$card->card_id,
                    'points'=>$points,
                    'type'=>'add',
                    'order_id'=>$request->order_id,
                    'vendor_id'=>$vendor->id
               ];
               $this->submitToWebhook($doc,$vendor);
               return redirect()->route('loyalty.give')->withStatus(__('Points added successfully'));
          } else {
                    return redirect()->route('loyalty.give')->withStatus(__('Card not found'));
               
          }
     }

     private function removingPoints($vendor,$card,$award,$points){
          $card->points = $card->points - $points;
          $card->save();
          $movment = new Movments();
          $movment->loyalycard_id = $card->id;
          $movment->vendor_id = $vendor->id;
          $movment->value = $points;
          $movment->staff_id = auth()->user()->id;
          $movment->type = 0;
          $movment->save();

          //Create coupon
          $couponData=[
               'name' => $award->title." - ".$card->client->name,
               'code' => "LOY".strtoupper(substr($vendor->name, 0, 2).(Str::random(6))),
               'type' => 0,
               'price' => $award->coupon_value,
               'active_from' => $award->created_at,
               'active_to' => $award->active_to,
               'limit_to_num_uses' => 1,
               'restaurant_id' => $vendor->id,
               'user_id' => $card->client->id,
          ];
          if($award->coupon_type=='percentage'){
               $couponData['type']=1;
          }

          $coupon = Coupons::create($couponData);
          $coupon->save();

          //Send email and sms notification to the client
          $client=$card->client;
          $client->notify(new LoyaltyPointsRemoved($client,$card,$award,$coupon,$vendor));
          
          //Increase the number of award used
          $award->used=$award->used+1;
          $award->save();

          //Submit to webhook
          $doc=[
               'card_id'=>$card->card_id,
               'points'=>$points,
               'type'=>'remove',
               'client'=>$card->client,
               'award'=>$award,
               'vendor_id'=>$vendor->id
          ];
          $this->submitToWebhook($doc,$vendor);

     }

     //Convert points into reward for the user
     public function exchangePoints($reward,Request $request){
          //Points can be calcualted from the award
          $award=Posts::where('id',$reward)->first();
          $vendor=Restorant::where('id',$award->vendor_id)->first();
          $points=$award->points;
          $card = Card::where('client_id',auth()->user()->id)->where('vendor_id',$vendor->id)->first();;
          if ($card) {
               if ($card->points >= $points) {
                   //Do the transaction
                    $this->removingPoints($vendor,$card,$award,$points);
                    return redirect()->route('loyaltyawards.peruser')->withStatus(__('Points removed successfully, Coupon created'));
               } else {
                    return redirect()->route('loyalty.movments.peruser')->withStatus(__('Not enough points'));
               }
          } else {
               return redirect()->route('loyalty.movments.peruser')->withStatus(__('Card not found'));
          }
     }

     //Function for removing points from a user
     public function removePoints(Request $request)
     {
          $vendor=$this->getRestaurant();
          //Points can be calcualted from the award
          $award=Posts::where('id',$request->award_id)->first();
          $points=$award->points;
          $card = Card::where('id', $request->card_id)->where('vendor_id', $vendor->id)->first();
          if ($card) {
               if ($card->points >= $points) {
                   //Do the transaction
                    $this->removingPoints($vendor,$card,$award,$points);
                    return redirect()->route('loyalty.remove')->withStatus(__('Points removed successfully, Coupon created'));
               } else {
                    return redirect()->route('loyalty.remove')->withStatus(__('Not enough points'));
               }
          } else {
               return redirect()->route('loyalty.remove')->withStatus(__('Card not found'));
          }
     }
     

     //Submit to webhook
     public function submitToWebhook($doc,$vendor){
          $webhook=$vendor->getConfig('loyalty_webhook','');
          if(strlen($webhook)>3){
               $client = new \GuzzleHttp\Client();
               $response = $client->request('POST', $webhook, [
                    'json' => $doc
               ]);
          }
     }

    //Calculate points that needs to be given to a user based on the order categories
    public function calculatePoints(Request $request)
    {
         $orderValuePerCategory=$request->orders_per_categories;
         $vendor = \App\Restorant::where('id', $request->vendor_id)->first();
         //Fetch points distributions per category
         $pointsDistribution=Categories::where('restorant_id',$vendor->id)->get()->toArray();

        $pointsTotal=0;
        $orderTotal=0;
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
            $orderTotal+=$value;
            $pointsTotal+=$pointsPerCategory[$categoryID];
        }
        return response()->json(['status' => 'success', 'points' => $pointsTotal,'orderTotal'=> $orderTotal, 'points_per_category' => $pointsPerCategory]);
    }

}
