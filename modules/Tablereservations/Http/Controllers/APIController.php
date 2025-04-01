<?php

namespace Modules\Tablereservations\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Carbon\Carbon;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Laravel\Sanctum\PersonalAccessToken;
use Modules\Tablereservations\Models\Tables;
use Modules\Tablereservations\Models\Customer;
use Modules\Tablereservations\Models\Reservation;
use Modules\Tablereservations\Notifications\ReservationConfirmed;
use Modules\Tablereservations\Notifications\ReservationRejected;

class APIController extends Controller
{

    private function authenticate(Request $request,Closure $next,$rules=['token' => 'required']){
        if(count($rules)!=0){
            $validator = Validator::make($request->all(), $rules);
        
            if ($validator->fails()) {
                return response()->json([
                    'status' => 'error',
                    'errors' => $validator->errors()
                ], 400);
            }
        }
        
        
        if (config('settings.is_demo')) {
            /*return response()->json([
                'status' => 'error',
                'errors' => "API is disabled in demo"
            ], 400);*/
        }

        //Check if we are logged in
        if(Auth::check()){
            return $next($request);
        }else{
            $token = PersonalAccessToken::findToken($request->token);
            if(!$token){
                return response()->json(['status'=>'error','message'=>'Invalid token']);
            }else{
                
                $user=User::findOrFail($token->tokenable_id);
                Auth::login($user);
                return $next($request);
            }
        }

        
    }

    public function getAvailableTables(Request $request){
        return $this->authenticate($request,function($request){
            //Company
            $company=$this->getCompany();

            //Get the tables that are not reserved for the specific date and time
            $tables = Tables::where('company_id', $company->id)
                ->where('size', '>=', $request->guests)
                ->whereDoesntHave('reservations', function ($query) use ($request) {
                    $query->where('reservation_date', '=', $request->date)
                        ->where('reservation_time', '>=', $request->time)
                        ->where('reservation_time', '<=', Carbon::parse($request->time)->addMinutes($request->period))
                        ->whereIn('status', ['confirmed', 'seated']);
                })
                ->with('restoarea')
                ->get();

            return response()->json([
                'status' => 'success',
                'tables' => $tables
            ], 200);
        },[
            'token' => 'required',
            'date' => 'required|date_format:Y-m-d',
            'time' => 'required',
            'period' => 'required|integer',
            'guests' => 'required|integer|min:1',
        ]);
    }

    public function getReservations($area=0,$date=null){
        //Create the request with the area and the date
        $request=new Request();
        $request->merge(['area'=>$area]);
        $request->merge(['date'=>$date]);

        return $this->authenticate($request,function($request){

            //Company
            $company=$this->getCompany();

            $pendingReservations=Reservation::where('company_id',$company->id)
                ->whereIn('status', ['pending'])
                ->orderBy('reservation_date','asc')
                ->orderBy('reservation_time','asc')
                ->with('customer')
                ->get();
            
            $upcomingReservations=Reservation::where('company_id',$company->id)
            ->whereIn('status', ['confirmed', 'soon', 'late', 'no-show'])
                ->where('reservation_date','=',Carbon::parse($request->date)->format('Y-m-d'))
                ->orderBy('reservation_date','asc')
                ->orderBy('reservation_time','asc')
                ->with(['customer','table.restoarea'])
                ->get();
            
            $seatedReservations=Reservation::where('company_id',$company->id)
                ->where('status','seated')
                ->where('reservation_date','=',Carbon::parse($request->date)->format('Y-m-d'))
                ->orderBy('reservation_date','asc')
                ->orderBy('reservation_time','asc')
                ->with(['customer','table.restoarea'])
                ->get();

            return response()->json([
                'status' => 'success',
                'pending' => $pendingReservations,
                'upcoming' => $upcomingReservations,
                'seated' => $seatedReservations,
            ], 200);
        },[
        ]);
    }

    private function getCode()
    {
        // Generate a unique reservation code, that is combination of 2 random numbers and 3 random letter
        $code = '';
        $code .= rand(100, 999);
        $code .= chr(rand(65, 90));
        $code .= chr(rand(65, 90));
        $code .= chr(rand(65, 90));

        //Validate if the code is unique
        $reservation=Reservation::where('reservation_code',$code)->first();
        if($reservation){
            return $this->getCode();
        }

      
        return $code;
    }

    public function createReservation(Request $request){

        return $this->authenticate($request,function($request){
            //Company
            $company=$this->getCompany();

            //Based on the received required data in $request, create a new reservation
            $reservation=new Reservation();
            $reservation->company_id=$company->id;
            $reservation->reservation_time=$request->reservation_time;
            $reservation->number_of_guests=$request->number_of_guests;
            $reservation->created_by=$request->channel;
            $reservation->reservation_code=$this->getCode();

            //Create the customer, or find if already exists based on the phone number
            $customer=Customer::where('phone',$request->phone)->first();
            if(!$customer){
                $customer=new Customer();
                $customer->name=$request->name;
                $customer->phone=$request->phone;
                $customer->company_id=$company->id;
                $customer->save();
            }

            $reservation->customer_id=$customer->id;

            //Save the reservation
            $reservation->save();

            //Set initial status as pending
            $reservation->status='pending';
            
            //Continue to update the reservation with the updateReservation method
            $request->merge(['reservation_id'=>$reservation->id]);
            return $this->updateReservation($request);

        },[
            'token' => 'required',
            'name'=>'required|string',
            'phone'=>'required|string',
            'reservation_time' => 'required|date_format:H:i',
            'number_of_guests' => 'required|integer|min:1',
            'expected_occupancy' => 'nullable|integer|min:1',
            'special_requests' => 'nullable|string',
            'channel' => 'required|string',
        ]);
    }

    public function updateReservation(Request $request){

        return $this->authenticate($request,function($request){
            //Company
            $company=$this->getCompany();

            //Get the reservation
            $reservation=Reservation::find($request->reservation_id);
            if(!$reservation){
                return response()->json(['status'=>'error','message'=>'Reservation not found']);
            }

            //Update the reservation based on the received data in $request, one by one
            if($request->has('reservation_date')){
                $reservation->reservation_date=$request->reservation_date;
            }
            if($request->has('reservation_time')){
                $reservation->reservation_time=$request->reservation_time;
            }
            if($request->has('number_of_guests')){
                $reservation->number_of_guests=$request->number_of_guests;
            }
            if($request->has('expected_occupancy')){
                $reservation->expected_occupancy=$request->expected_occupancy;
            }
            if($request->has('special_requests')){
                $reservation->special_requests=$request->special_requests;
            }

            //If we have name and phone, update the customer
            if($request->has('name') && $request->has('phone')){
                $customer=Customer::where('phone',$request->phone)->first();
                if(!$customer){
                    $customer=new Customer();
                    $customer->phone=$request->phone;
                    $customer->company_id=$company->id;
                    $customer->save();
                }
                $customer->name=$request->name;
                $customer->save();
                $reservation->customer_id=$customer->id;
            }

            //Update customer email
            if($request->has('email')){
                $customer=Customer::find($reservation->customer_id);
                if($customer){
                    $customer->email=$request->email;
                    $customer->save();
                }
            }


            
            //Table
            if($request->has('table_id')){
                $table=Tables::find($request->table_id);

                //Check if there is no confirmed reservation for the table, at the same time
                $confirmedReservations=Reservation::
                    where('table_id',$table->id)
                    ->whereIn('status', ['confirmed', 'seated'])
                    ->where('reservation_date',$reservation->reservation_date)
                    ->where('id', '!=', $reservation->id)
                    ->get();
                if($confirmedReservations->count()>0){

                    //Loop in all confirmedReservations if the time is overlapping
                    $confirmedReservation=null;
                    foreach($confirmedReservations as $confirmed){
                        $start1 = Carbon::parse($confirmed->reservation_time);
                        $end1 = Carbon::parse($confirmed->reservation_time)->addMinutes($confirmed->expected_occupancy);
                        $start2 = Carbon::parse($reservation->reservation_time);
                        $end2 = Carbon::parse($reservation->reservation_time)->addMinutes($reservation->expected_occupancy);
                        if($start1->between($start2,$end2) || $end1->between($start2,$end2)){
                            $confirmedReservation=$confirmed;
                            break;
                        }
                    }

                    if($confirmedReservation){
                        return response()->json(['status'=>'error','message'=>'Your reservation is created - #'.$reservation->reservation_code.'.But that table is already reserved by #'.$confirmedReservation->reservation_code." - ".$confirmedReservation->customer->name], 200);
                    }
                  
                   
                }

                if(!$table){
                    return response()->json(['status'=>'error','message'=>'Table not found'], 200);
                }
                $reservation->table_id=$table->id;

                
            }

            //Status
            if($request->has('status')){

                //Set the status
                $reservation->status=$request->status;
            }

            

            //Update the reservation
            $reservation->save();


            //After save, if we have status change, send a notification to the customer
            if($request->has('status')&&$request->status=='confirmed'){
                $customer=$reservation->customer;
                if($customer){
                    $customer->notify(new ReservationConfirmed($reservation));
                }
            }

            //Rejected
            if($request->has('status')&&$request->status=='cancelled'&&config('tablereservations.send_reject_notification',"true")=='true'){
                $customer=$reservation->customer;
                if($customer){
                    $customer->notify(new ReservationRejected($reservation));
                }
            }

            return response()->json([
                'status' => 'success',
                'message' => 'Reservation updated',
                'reservation' => $reservation
            ], 200);
        },[
            'token' => 'required',
            'reservation_id' => 'required|integer',
        ]);
    }
}