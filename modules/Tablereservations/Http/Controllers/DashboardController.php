<?php

namespace Modules\Tablereservations\Http\Controllers;

use Akaunting\Module\Facade as Module;
use App\Http\Controllers\Controller;
use App\Models\Plans;
use App\Models\Posts;
use Carbon\Carbon;
use App\Services\ConfChanger;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Cookie;
use Modules\Tablereservations\Models\Reservation;

class DashboardController extends Controller
{

    public function index()
    {
        if(auth()->user()->hasRole(['owner','staff'])){

            return $this->asCompany();
        }
    }   
    
    public function asCompany()
    {

        $company=$this->getCompany();

        //Change Language
        ConfChanger::switchLanguage($company);

        //Change currency
        ConfChanger::switchCurrency($company);

    

        $data=[
            'today_reservations'=>[
                'title'=>'Reservations for today',
                'icon'=>'ni-calendar-grid-58',
                'icon_color'=>'bg-gradient-info',
                'main_value'=>0,
                'sub_value'=>0,
                'sub_value_color'=>'text-success',
                'sub_title'=>"Already done",
                'href'=>route('tablereservations.index')."?reservation_date=".Carbon::today()->format('Y-m-d')
            ],
            
            'seated_customers'=>[
                'title'=>'Seated customers',
                'icon'=>'ni-satisfied',
                'icon_color'=>'bg-gradient-success',
                'main_value'=>0,
                'sub_value'=>0,
                'sub_value_color'=>'text-success',
                'sub_title'=>"left for today",
                'href'=>route('tablereservations.index')."?status=seated&reservation_date=".Carbon::today()->format('Y-m-d')
            ],
            'pending_reservations'=>[
                'title'=>'Pending reservations',
                'icon'=>'ni-time-alarm',
                'icon_color'=>'bg-gradient-danger',
                'main_value'=>0,
                'sub_value'=>0,
                'sub_value_color'=>'text-success',
                'sub_title'=>"for today",
                'href'=>route('tablereservations.index')."?status=pending"
            ],
            'tomorrow_reservations'=>[
                'title'=>'Reservations for tomorrow',
                'icon'=>'ni-book-bookmark',
                'icon_color'=>'bg-gradient-warning',
                'main_value'=>0,
                'sub_value'=>0,
                'sub_value_color'=>'text-success',
                'sub_title'=>"confirmed",
                'href'=>route('tablereservations.index')."?reservation_date=".Carbon::tomorrow()->format('Y-m-d')
            ]
            
            
        ];  

        //===== today_reservations =========
        //Calculate the today_reservations main_value - the number of reservations for today
        $today_reservations = Reservation::where('reservation_date', Carbon::today())
            ->whereNotIn('status', ['pending', 'cancelled'])
            ->count();
        $data['today_reservations']['main_value'] = $today_reservations;

        //Calculate the today_reservations sub_value - the number of reservations for today that are done
        $today_reservations_done = Reservation::where('reservation_date', Carbon::today())
            ->where('status', 'completed')
            ->count();
        $data['today_reservations']['sub_value'] = $today_reservations_done;
       


        //===== seated_customers =========
        $seated_customers = Reservation::where('status', 'seated')
        ->where('reservation_date', Carbon::today())
        ->count();
        $data['seated_customers']['main_value'] = $seated_customers;    
        $unseated = Reservation::where('reservation_date', Carbon::today())
            ->where('status', 'confirmed')
            ->count();
        $data['seated_customers']['sub_value'] = $unseated;

        //===== pending_reservations =========
        $total_pending_reservations = Reservation::where('status', 'pending')->count();
        $data['pending_reservations']['main_value'] = $total_pending_reservations;
        $pending_reservations_today = Reservation::where('reservation_date', Carbon::today())
            ->where('status', 'pending')
            ->count();
        $data['pending_reservations']['sub_value'] = $pending_reservations_today;

        //===== tomorrow_reservations =========
        $tomorrow_reservations_all = Reservation::where('reservation_date', Carbon::tomorrow())->count();
        $data['tomorrow_reservations']['main_value'] = $tomorrow_reservations_all;
        $tomorrow_reservations_confirmed = Reservation::where('reservation_date', Carbon::tomorrow())
            ->where('status', 'confirmed')
            ->count();
        $data['tomorrow_reservations']['sub_value'] = $tomorrow_reservations_confirmed;


        return $data;
    }

    public function landing()
    {

        //Change Language
        $locale = Cookie::get('lang') ? Cookie::get('lang') : config('settings.app_locale');
        if(isset($_GET['lang'])){
             //this is language route
             $locale = $_GET['lang'];
        }

        if($locale!="android-chrome-256x256.png"){
            App::setLocale(strtolower($locale));
            session(['applocale_change' => strtolower($locale)]);
        }

   

         //Landing page content
         $features = Posts::where('post_type', 'feature')->get();
         $testimonials = Posts::where('post_type', 'testimonial')->get();
         $faqs = Posts::where('post_type', 'faq')->get();
         $mainfeatures = Posts::where('post_type', 'mainfeature')->get();

         


         $colCounter = [1, 2, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4, 4];
         $plans = config('settings.forceUserToPay',false)?Plans::where('id','!=',intval(config('settings.free_pricing_id')))->get():Plans::get();
        $data=[
            'col' => count($plans)>0?$colCounter[count($plans)-1]:4,
            'plans'=>$plans,
            'features' => $features,
            'processes' => $features,
            'mainfeatures' => $mainfeatures,
            'locale'=>strtolower($locale),
            'faqs' => $faqs,
            'testimonials' => $testimonials,
            'hasAIBots'=>Module::has('flowiseai')
        ];

        $response = new \Illuminate\Http\Response(view('wpbox::landing.index', $data));
        App::setLocale(strtolower($locale));
        $response->withCookie(cookie('lang', $locale, 120));
        App::setLocale(strtolower($locale));
        

        return $response;
    }

}