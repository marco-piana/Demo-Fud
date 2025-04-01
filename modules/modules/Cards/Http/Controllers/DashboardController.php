<?php

namespace Modules\Cards\Http\Controllers;
use App\Http\Controllers\Controller;
use Modules\Cards\Models\Card;
use Carbon\Carbon;
use Modules\Cards\Models\Movments;
use App\Services\ConfChanger;
use App\Models\Posts;
require __DIR__.'/../../vendor/autoload.php';

use  Milon\Barcode\DNS1D;

class DashboardController extends Controller
{

    public function index()
    {
        if(auth()->user()->hasRole(['owner','staff'])){
            return $this->asVendor();
        }else if(auth()->user()->hasRole('client')){
            return $this->asClient();
        }
    }
    
    public function asVendor()
    {

        $vendor=$this->getRestaurant();

        //Change Language
        ConfChanger::switchLanguage($vendor);

        //Change currency
        ConfChanger::switchCurrency($vendor);

        $data=[
            'customers_total' => '',
            'customers_this_month' => '',
            'gifts_given'=> '',
            'gifts_this_month' => '',
            'points_earned' => '',
            'points_this_month' => '',
            'sales_total' => '',
            'sales_this_month' => '',
            'customers'=>[],
            'awards'=>[],
        ];

        $startOfMonth=Carbon::now()->startOfMonth();

        //Count total cards
        $cards=Card::where('vendor_id',$vendor->id);
        $data['customers_total'] = $cards->count();

        //Count total cards this month of the year
        $data['customers_this_month'] = $cards->where('created_at', '>=',$startOfMonth )->count();
    

        //Count  gifts given
        $movements=Movments::where('vendor_id',$vendor->id)->where('type', 0);
        $data['gifts_given'] = $movements->count();
        $data['gifts_this_month'] = $movements->where('created_at', '>=',$startOfMonth )->count();

        //Count  points given
        $points=Movments::where('vendor_id',$vendor->id)->where('type', 1);
        $data['points_earned'] = $points->sum('value');
        $data['points_this_month'] = $points->where('created_at', '>=',$startOfMonth )->sum('value');

        //Count  orders made
        $data['sales_total'] = Money($points->sum('order_value'),config('settings.cashier_currency'),config('settings.do_convertion'));
        $data['sales_this_month'] = Money($points->where('created_at', '>=',$startOfMonth )->sum('order_value'),config('settings.cashier_currency'),config('settings.do_convertion'));


        //Get last 5 customers
        $data['customers']=$cards->orderBy('created_at','desc')->take(5)->get();

        //Get last 5 awards
        $data['awards']=Posts::where('vendor_id',$vendor->id)->where('post_type', 'reward')->orderBy('created_at','desc')->take(5)->get();

        return $data;
    }

    public function asClient()
    {
       

        $data=[
            'dns1d'=>(new DNS1D()),
            'points' => '',
            'points_this_month' => '',
            'gifts_received'=> '',
            'gifts_this_month' => '',
            'transactions_made' => '',
            'transactions_this_month' => '',
            'sales_total' => '',
            'sales_this_month' => '',
            'cards'=>[]
        ];

        $startOfMonth=Carbon::now()->startOfMonth();

        //Set current points
        $points=Movments::where('type', 1);
        $points=$points->whereHas('card', function ($query) {
            $query->where('client_id', auth()->user()->id);
        });
        $data['points'] = Card::where('client_id', auth()->user()->id)->sum('points');
        $data['points_this_month'] = $points->where('created_at', '>=',$startOfMonth )->sum('value');

        //Count  movments  made as gifts
        $gifts=Movments::where('type', 0);
        $gifts=$gifts->whereHas('card', function ($query) {
            $query->where('client_id', auth()->user()->id);
        });
        $data['gifts_received'] = $gifts->count();
        $data['gifts_this_month'] = $gifts->where('created_at', '>=',$startOfMonth )->count();

        //Count  transactions  made 
        $transaction=Movments::where('id','>', 0);
        $transaction=$transaction->whereHas('card', function ($query) {
            $query->where('client_id', auth()->user()->id);
        });
        $data['transactions_made'] = $transaction->count();
        $data['transactions_this_month'] = $transaction->where('created_at', '>=',$startOfMonth )->count();

        
        //Count  orders made
        $data['sales_total'] = Money($points->sum('order_value'),config('settings.cashier_currency'),config('settings.do_convertion'));
        $data['sales_this_month'] = Money($points->where('created_at', '>=',$startOfMonth )->sum('order_value'),config('settings.cashier_currency'),config('settings.do_convertion'));
 

        $data['cards'] = Card::where('client_id', auth()->user()->id)->get();
        return $data;
    }
}