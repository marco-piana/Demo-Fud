<?php

namespace Modules\Tablereservations\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Tablereservations\Models\Reservation;
use Maatwebsite\Excel\Facades\Excel;
use Modules\Tablereservations\Exports\ReservationsExport;
use Modules\Tablereservations\Models\Customer;

class Main extends Controller
{
     /**
     * Provide class.
     */
    private $provider = Reservation::class;

     /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'tablereservations.';

    /**
     * View path.
     */
    private $view_path = 'tablereservations::reservations.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'reservation';

    /**
     * Title of this crud.
     */
    private $title = 'reservation';

    private $statuses = ['pending', 'confirmed', 'cancelled', 'seated', 'soon', 'late', 'no-show','completed'];

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'reservations';

    private function getFields($class='col-md-4',$getCustom=true)
    {
        $fields=[];

        //Add name field
        $fields[0]=['class'=>$class, 'ftype'=>'input', 'name'=>'Name', 'id'=>'name', 'placeholder'=>'Enter name', 'required'=>true];

        //Add phone
        $fields[1]=['class'=>$class, 'ftype'=>'input', 'name'=>'Phone', 'id'=>'phone', 'placeholder'=>'Enter phone', 'required'=>true];

        //Add date
        $fields[2]=['class'=>$class, 'ftype'=>'input','type'=>'date', 'name'=>'Date', 'id'=>'reservation_date', 'placeholder'=>'Enter date', 'required'=>true];

        //Add time
        $fields[3]=['class'=>$class, 'ftype'=>'input','type'=>"time", 'name'=>'Time', 'id'=>'reservation_time', 'placeholder'=>'Enter time', 'required'=>true];

        //Add number of people
        $fields[4]=['class'=>$class, 'ftype'=>'input', 'name'=>'Number of people', 'id'=>'number_of_guests', 'placeholder'=>'Enter number of people', 'required'=>true];

        //Add special_requests
        $fields[5]=['class'=>$class, 'ftype'=>'textarea', 'name'=>'Special requests', 'id'=>'special_requests', 'placeholder'=>'Enter special requests', 'required'=>false];

        //Select table_id\

        $tablesDB=\Modules\Floorplan\Models\Tables::where('id','>',0)->get();
        $tables=[];
        foreach($tablesDB as $table){
            $tables[$table->id]=$table->full_name;
        }
        $fields[6]=['class'=>$class, 'ftype'=>'select', 'name'=>'Table', 'id'=>'table_id', 'placeholder'=>'Select table', 'required'=>true, 'data'=>$tables];

        //Select status
        $fields[7]=['class'=>$class, 'ftype'=>'select', 'name'=>'Status', 'id'=>'status', 'placeholder'=>'Select status', 'required'=>true, 'data'=>array_combine($this->statuses, array_map('strtoupper', $this->statuses))];

        //Add email
        $fields[8]=['class'=>$class, 'ftype'=>'input', 'name'=>'Email', 'id'=>'email', 'placeholder'=>'Enter email', 'required'=>false];
        
        //Add expected_occupancy, which is the time in minutes that the table is expected to be occupied, select from values like 30, 60, 90, 120, 150, 180
        $fields[9]=['class'=>$class, 'ftype'=>'select', 'name'=>'Expected Occupancy', 'id'=>'expected_occupancy', 'placeholder'=>'Select expected occupancy', 'required'=>false, 'data'=>[
            30=>'30 minutes',
            45=>'45 minutes',
            60=>'1 hour',
            90=>'1.5 hours',
            120=>'2 hours',
            150=>'2.5 hours',
            180=>'3 hours',
            240=>'4 hours',
            300=>'5 hours',
            360=>'6 hours',
            420=>'7 hours',
            480=>'8 hours',
            540=>'9 hours',
            600=>'10 hours',
            660=>'11 hours',
            720=>'12 hours'
        ]];
        return $fields;
    }

    private function getFilterFields(){
        $fields=$this->getFields('col-md-3',false);
        unset($fields[3]);
        unset($fields[4]);
        unset($fields[5]);
        unset($fields[9]);

        //Add reservation_code
        $fields[10]=['class'=>'col-md-3', 'ftype'=>'input', 'name'=>'Reservation Code', 'id'=>'reservation_code', 'placeholder'=>'Enter reservation code', 'required'=>false];

        
        //Make each field not required
        foreach($fields as $key=>$field){
            $fields[$key]['required']=false;
        }
        return $fields;
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $items=$this->provider::orderBy('id', 'desc');
        if(isset($_GET['name']) && strlen($_GET['name']) > 1){
            $items = $items->whereHas('customer', function($query) {
            $query->where('name', 'like', '%'.$_GET['name'].'%');
            });
        }
        if(isset($_GET['phone']) && strlen($_GET['phone']) > 1){
            $items = $items->whereHas('customer', function($query) {
            $query->where('phone', 'like', '%'.$_GET['phone'].'%');
            });
        }

        //Email
        if(isset($_GET['email']) && strlen($_GET['email']) > 1){
            $items = $items->whereHas('customer', function($query) {
            $query->where('email', 'like', '%'.$_GET['email'].'%');
            });
        }

        //Date
        if(isset($_GET['reservation_date']) && strlen($_GET['reservation_date']) > 1){
            $items = $items->where('reservation_date', $_GET['reservation_date']);
        }

        //Reservation Code
        if(isset($_GET['reservation_code']) && strlen($_GET['reservation_code']) > 1){
            $items = $items->where('reservation_code', $_GET['reservation_code']);
        }

        //Table
        if(isset($_GET['table_id']) && strlen($_GET['table_id']) > 0){
            $items = $items->where('table_id', $_GET['table_id']);
        }

        //Status
        if(isset($_GET['status']) && strlen($_GET['status']) > 2){
            $items = $items->where('status', $_GET['status']);
        }


        if(isset($_GET['report'])){
            return $this->exportCSV($items->with(['customer','table'])->get());
            
        }
        $totalItems=$items->count();
        $items=$items->paginate(config('settings.paginate'));


        return view($this->view_path.'index', ['setup' => [
            'usefilter'=>true,
            'title'=>__('crud.item_managment', ['item'=>__($this->titlePlural)]),
            'subtitle'=>$totalItems==1?__('1 Reservation'):$totalItems." ".__('Reservations'),
            'action_link'=>route($this->webroute_path.'create'),
            'action_name'=>__('crud.add_new_item', ['item'=>__($this->title)]),
            //'action_link2'=>route($this->webroute_path.'groups.index'),
            //'action_name2'=>__('Groups'),
            //'action_link3'=>route($this->webroute_path.'fields.index'),
            //'action_name3'=>__('Fields'),
            //'action_link4'=>route($this->webroute_path.'index',['report'=>true]),
            //'action_name4'=>__('Export'),
            'items'=>$items,
            'item_names'=>$this->titlePlural,
            'webroute_path'=>$this->webroute_path,
            'fields'=>$this->getFields(),
            'filterFields'=>$this->getFilterFields(),
            'custom_table'=>true,
            'parameter_name'=>$this->parameter_name,
            'parameters'=>count($_GET) != 0
        ]]);
    }

    public function exportCSV($reservatinsToDowload){
        $items=[];
        foreach ($reservatinsToDowload as $key => $reservation) {
            $item = [
                'reservation_code' => $reservation->reservation_code,
                'Name' => $reservation->customer->name,
                'Phone' => $reservation->customer->phone,
                'Date' => $reservation->reservation_date,
                'Time' => $reservation->reservation_time,
                'Status' => $reservation->status,
                'Table' => $reservation->table->full_name,
                'Created At' => $reservation->created_at,
                'Updated At' => $reservation->updated_at,
                'Relative Time' => $reservation->created_at->diffForHumans(),
            ];

           
            array_push($items, $item);
        }
        return Excel::download(new ReservationsExport($items), 'reservations_'.time().'.csv', \Maatwebsite\Excel\Excel::CSV);
    }


    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        $fields=$this->getFields();

        //If there is a table_id in the url, preselect it
        if(isset($_GET['table_id'])){
            $fields[6]['value']=$_GET['table_id'];
        }

        //If there is a contact_id in the url, fill the value for email, name and phone
        if(isset($_GET['contact_id'])){
            $contact=Customer::find($_GET['contact_id']);
            $fields[0]['value']=$contact->name;
            $fields[1]['value']=$contact->phone;
            $fields[8]['value']=$contact->email;
        }

        //Status should be confirmed
        $fields[7]['value']='confirmed';

        //If there is a status in the url, preselect it
        if(isset($_GET['status'])){
            $fields[7]['value']=$_GET['status'];
        }


        //Data should be today
        $fields[2]['value']=date('Y-m-d');

        //Time should be 9 pm
        $fields[3]['value']='21:00';

        //Number of people should be 2
        $fields[4]['value']='2';

        return view($this->view_path.'edit', ['setup' => [
            'title'=>__('crud.new_item', ['item'=>__($this->title)]),
            'action_link'=>route($this->webroute_path.'index'),
            'action_name'=>__('crud.back'),
            'iscontent'=>true,
            'action'=>route($this->webroute_path.'store'),
        ],
        'fields'=>$fields ]);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Response
     */
    public function store(Request $request)
    {
       //Using API
       $api=new APIController;

       //Add token to the request  
       $request->merge(['token'=>'-']);

       //channel
       $request->merge(['channel'=>'admin']);

       $res=$api->createReservation($request);

       //Parse the response
       $parsed=json_decode($res->getContent());
       if($parsed->status=='success'){
            return redirect()->route($this->webroute_path.'index')->with('status', $parsed->message);
       }else{
            return redirect()->route($this->webroute_path.'index')->with('error',$parsed->message);
       }
    }

    
    /**
     * Show the specified resource.
     * @param int $id
     * @return Response
     */
    public function show($id)
    {
        return view('tablereservations::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Response
     */
    public function edit(Reservation $reservation)
    {
        $fields = $this->getFields();
      
        $fields[0]['value'] = $reservation->customer->name;
        $fields[1]['value'] = $reservation->customer->phone;
        $fields[2]['value'] = $reservation->reservation_date;
        $fields[3]['value'] = $reservation->reservation_time;
        $fields[4]['value'] = $reservation->number_of_guests;
        $fields[5]['value'] = $reservation->special_requests;
        $fields[6]['value'] = $reservation->table_id;
        $fields[7]['value'] = $reservation->status;
        $fields[8]['value'] = $reservation->customer->email;
        $fields[9]['value'] = $reservation->expected_occupancy;
        

        $parameter = [];
        $parameter[$this->parameter_name] = $reservation->id;
        $title=__('crud.edit_item_name', ['item'=>__($this->title), 'name'=>"#".$reservation->reservation_code]);
        return view($this->view_path.'edit', ['setup' => [
            'title'=>$title,
            'action_link'=>route($this->webroute_path.'index'),
            'action_name'=>__('crud.back'),
            'iscontent'=>true,
            'isupdate'=>true,
            'action'=>route($this->webroute_path.'update', $parameter),
        ],
        'fields'=>$fields, ]);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //Initialize API
        $api=new APIController;

        //Add the reservation_id to the request
        $request->merge(['reservation_id'=>$id]);
        
        //Add token to the request  
        $request->merge(['token'=>'-']);

        $res=$api->updateReservation($request);

        $parsed=json_decode($res->getContent());
        if( $parsed->status=='success' ){
            return redirect()->route($this->webroute_path.'index')->with('status', $parsed->message);
        }else{
            return redirect()->back()->with('error',$parsed->message);
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
