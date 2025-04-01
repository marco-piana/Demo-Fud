<?php

namespace Modules\Tablereservations\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Services\ConfChanger;
use Modules\Floorplan\Models\RestoArea;
use Carbon\Carbon;

class PanelController extends Controller
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
        //Get the company areas
        try {
            $areas=RestoArea::where('company_id',$company->id)->get();
            $areasForFloorPlan=RestoArea::where('company_id',$company->id)->with('tables')->get();
        } catch (\Throwable $th) {
            $areas=RestoArea::where('restaurant_id',$company->id)->get();
            $areasForFloorPlan=RestoArea::where('restaurant_id',$company->id)->with('tables')->get();
        }
        


        //On areas add on start the "All Areas" option with id 0
        $allAreas=new RestoArea();
        $allAreas->id=0;
        $allAreas->name="All Areas";
        $areas->prepend($allAreas);


        //Get the dates for the next 7 days, as two elements in  arrays, one with the dates and one with the days
        $dates = [];
        $days = [];
        for ($i = 0; $i < 7; $i++) {
            $date = Carbon::now()->addDays($i);
            $dates[] = $date->format('Y-m-d');
            $days[] = $date->isoFormat('dddd, MMM Do');
        }
        $days[0] = __('Today');
        
        // merge the two arrays, so the key is a regular index and the value in associative array of name and date
        $dateArray=[];
        foreach ($dates as $key => $date) {
            $dateArray[$key]=['name'=>$days[$key],'date'=>$date];
        }
        
    
    
        

        $floorPlan=[];
        foreach ($areas as $key => $area) {
            foreach ($area->tables as $table) {
                $floorPlan[$table->id]=$area->name." - ".$table->name;
            }
        }
        

        //Change Language
        ConfChanger::switchLanguage($company);

        //Change currency
        ConfChanger::switchCurrency($company);

        //Return the view
        $data=[
            'setup'=>[
                'title'=>'Table Reservations',
            ],
            'title'=>'Table Reservations',
            'company'=>$company,
            'areasForFloorPlan'=>$areasForFloorPlan,
            'dates'=>$dateArray,
            'areas'=>$areas,
            'floorPlan'=>$floorPlan 
        ];

        if(config('settings.app_code_name','nottablereservations')=='reservations'){
            return view('tablereservations::panel.compact',$data);
        }else{
            return view('tablereservations::panel.compactqr',$data);
        }
    }
    
}