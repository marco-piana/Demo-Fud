<?php

namespace Modules\Cards\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Modules\Cards\Models\Categories;
use Modules\Cards\Models\Movments;
use Modules\Cards\Models\Card;
use App\Models\Posts;
use App\Events\NewClient;
use App\Models\Company;
use App\Models\Plans;
use App\Services\ConfChanger;
use Illuminate\Support\Str;
use Modules\Cards\Notifications\LoyaltyPointsRemoved;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\Route;
use Modules\Coupons\Models\Coupons;

class Main extends Controller
{

     public function landing()
    {
          //Normal, with landing
          $plans = config('settings.forceUserToPay',false)?Plans::where('id','!=',intval(config('settings.free_pricing_id')))->get()->toArray():Plans::get()->toArray();
          $colCounter = [12, 6, 4, 3, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4];



          foreach($plans as $key => $plan){
               $plans[$key]['price_form'] =rtrim(money($plan['price'],config('settings.cashier_currency'),config('settings.do_convertion'))->format(), ".00");
          }

      
        $availableLanguagesENV = config('settings.front_languages');
        $exploded = explode(',', $availableLanguagesENV);
        $availableLanguages = [];
        for ($i = 0; $i < count($exploded); $i += 2) {
            $availableLanguages[$exploded[$i]] = $exploded[$i + 1];
        }

        $locale = Cookie::get('lang') ? Cookie::get('lang') : config('settings.app_locale');
        $route = Route::current();
        $name = Route::currentRouteName();
        $query = 'lang.';
        if (substr($name, 0, strlen($query)) === $query) {
            //this is language route
            $exploded = explode('.', $name);
            $lang = strtoupper($exploded[1]);
            $locale = $lang;
        }
        App::setLocale(strtolower($locale));
        session(['applocale_change' => strtolower($locale)]);

        //Landing page content
        $features = Posts::where('post_type', 'feature')->get();
        $testimonials = Posts::where('post_type', 'testimonial')->get();
        $processes = Posts::where('post_type', 'process')->get();
        $blog_posts = Posts::where('post_type', 'blog')->get();
        $showcase = Posts::where('post_type', 'showcase')->get();
        $faqs = Posts::where('post_type', 'faq')->get();
       
        $response = new \Illuminate\Http\Response(view('cards::landing', [
            'isExtended' => md5(config('settings.extended_license_download_code',""))=="d0398556dbecac06370bdc8baec559a9" || config('settings.is_demo',false),
            'col' => count($plans)>0?$colCounter[count($plans)-1]:12,
            'plans' => $plans,
            'availableLanguages' => $availableLanguages,
            'locale' => $locale,
            'pages' =>[],
            'featured_vendors'=>Company::where('active',1)->where('is_featured',1)->get()->shuffle(),
            'showcase' => $showcase,
            'features' => $features,
            'faqs' => $faqs,
            'testimonials' => $testimonials,
            'processes' => $processes,
            'blog_posts' => $blog_posts
        ]));

        $response->withCookie(cookie('lang', $locale, 120));
        App::setLocale(strtolower($locale));

        return $response;
    }

    public function companyLanding(Company $company){

          //Set config based on restaurant
          config(['app.timezone' => $company->getConfig('time_zone',config('app.timezone'))]);

          //Change Language
          ConfChanger::switchLanguage($company);

          //Change currency
          ConfChanger::switchCurrency($company);

          $currentEnvLanguage = isset(config('config.env')[2]['fields'][0]['data'][config('app.locale')]) ? config('config.env')[2]['fields'][0]['data'][config('app.locale')] : 'UNKNOWN';


          $company->increment('views');

          $viewFile='cards::company.landing';

          $viewData=[
               'faqs' =>  Posts::where('post_type', 'loyaltyfaq')->where('vendor_id',$company->id)->get(),
               'rewards' =>  Posts::where('post_type', 'reward')->where('vendor_id',$company->id)->get(),
               'company' => $company,
               'currentLanguage'=>$currentEnvLanguage,
          ];

          if(Auth::user()){
          $viewData['card']=Card::where('client_id',auth()->user()->id)->where('vendor_id',$company->id)->first();
          if($viewData['card']==null){
               //dispatch new user event for this vendor
               NewClient::dispatch(auth()->user(),$company);
               $viewData['card']=Card::where('client_id',auth()->user()->id)->where('vendor_id',$company->id)->first();
          }
          }



          $response = new \Illuminate\Http\Response(view($viewFile,$viewData));
          return $response;
     }



    
     //Show form for adding points to a user
     public function showPointGiveForm(){
        $vendor=$this->getCompany();
        $categories=Categories::where('company_id',$vendor->id)->get();
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
          $vendor=$this->getCompany();


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
          $vendor=$this->getCompany();
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
               'company_id' => $vendor->id,
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
          $vendor=Company::where('id',$award->vendor_id)->first();
          $points=$award->points;
          $card = Card::where('client_id',auth()->user()->id)->where('vendor_id',$vendor->id)->first();
          
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
          $vendor=$this->getCompany();
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
         $vendor = \App\Models\Company::where('id', $request->vendor_id)->first();
         //Fetch points distributions per category
         $pointsDistribution=Categories::where('company_id',$vendor->id)->get()->toArray();

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
