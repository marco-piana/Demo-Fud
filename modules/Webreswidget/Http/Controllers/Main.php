<?php

namespace Modules\Webreswidget\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Modules\Webreswidget\Models\Webreswidget;

class Main extends Controller
{
    public function index(Request $request)
    {
        //Get the widget data
        $widget = Webreswidget::where('id', $request->id)->first();
        if(!$widget){
            return response()->json(['error'=>'Widget not found'], 404);
        }else{
            $imageLink= $widget->getImageLinkAttribute();
            $widget = $widget->toArray();
            
            $widget['message'] = $widget['widget_text'];
            $widget['url'] = config('app.url')."/uploads/default/reservations/widget/";
            $widget['app_url'] = config('app.url');
            $widget['widget_id'] = $request->id;
            if (!str_starts_with($imageLink, 'http')) {
                $widget['logo'] = config('app.url').$imageLink;
            } else {
                $widget['logo'] = $imageLink;
            }
            if (isset($widget['phone_number'])) {
                $widget['calllink'] = "tel://".$widget['phone_number'];
            } else {
                $widget['calllink'] = '';
            }
        }

 
        return response()->view('webreswidget::dynamic_js',$widget)->header('Content-Type', 'application/javascript');
    }

    public function create()
    {
        return view('webreswidget::create');
    }

    private function generateRandomString($length = 10) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomString = '';
        for ($i = 0; $i < $length; $i++) {
            $randomString .= $characters[rand(0, $charactersLength - 1)];
        }
        return $randomString;
    }

    public function store(Request $request)
    {

        // Validate the request data
        $validatedData = $request->validate([
            'phone_number' => 'required',
            'header_text' => 'required',
            'header_subtext' => 'required',
            'widget_text' => 'required',
            'button_text' => 'required',
            'widget_type' => 'required',
            'button_color' => 'required',
            'header_color' => 'required'
        ]);

        // Create a new widget
        //Check for existing widget
        $company = $this->getCompany();
        $widget = Webreswidget::where('company_id', $company->id)->first();
        if(!$widget){
            $widget = new Webreswidget();
            $widget->id = $this->generateRandomString(10);
        }
       

        // Assign the validated data to the widget
        $widget->phone_number = $validatedData['phone_number'];
        $widget->header_text = $validatedData['header_text'];
        $widget->header_subtext = $validatedData['header_subtext'];
        $widget->widget_text = $validatedData['widget_text'];
        $widget->button_text = $validatedData['button_text'];
        $widget->widget_type = $validatedData['widget_type'];
        $widget->button_color = $validatedData['button_color'];
        $widget->header_color = $validatedData['header_color'];
        $widget->company_id = auth()->user()->company->id;


        // Save the widgets
        $widget->save();

        //save the image
        if ($request->hasFile('logo')) {
            $widget->logo = $this->saveImageVersions(
                'uploads/companies/',
                $request->logo,
                [
                    ['name'=>'large'],
                ]
            );
            $widget->update();
        }else if(strlen($widget->logo==0)){
            $widget->logo = $company->logom;
            $widget->update();
        }

        // Redirect to a success page
        return redirect()->route('webreswidget.edit')->with('status', 'Widget updated successfully');
    }

    public function show($id)
    {
        return view('webreswidget::show');
    }

    public function edit()
    {
        //Find existing widget
        //Get the company   
        $company = $this->getCompany();
        $widget = Webreswidget::where('company_id', $company->id)->first();
        if(!$widget){
            $widget = [
                'logo' => '',
                'phone_number' => $company->phone,
                'header_text' => $company->name,
                'header_subtext' => __('Reservations'),
                'widget_text' => "Hi there 👋\nI'm here to help you reserve a table?",
                'button_text' => __('Make reservation'),
                'widget_type' => '1',
                'input_field_placeholder' => 'Enter your message',
                'button_color' => '#ea580c',
                'header_color' => '#0284c7',
                'logo' => $company->logom,
            ];
        }else{

            $id=$widget->getAttributes()['id'];
            $imageLink= $widget->getImageLinkAttribute();
            $widget = $widget->toArray();
            $widget['logo'] = $imageLink;
            $widget['url'] = config('app.url')."/popup/webreswidget?id=".$id;

        }

        return view('webreswidget::edit',['widget'=>$widget]);
    }

    public function update(Request $request, $id)
    {
        //
    }

    public function destroy($id)
    {
        //
    }

    public function makereservation(Request $request)
    {
        

        $validator = \Illuminate\Support\Facades\Validator::make($request->all(), [
            'name' => 'required',
            'phone' => 'required',
            'date' => 'required',
            'time' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 200);
        }

        //Get the widget
        $widget = Webreswidget::where('id', $request->widget_id)->first();

        //Get the company
        $company = Company::where('id', $widget->company_id)->first();

        //Get or create the contact by phone number
        $customer = \Modules\Tablereservations\Models\Customer::where('phone', $request->phone)->first();
        if(!$customer){
            $customer = new \Modules\Tablereservations\Models\Customer();
            $customer->name = $request->name;
            $customer->phone = $request->phone;
            $customer->save();
        }

        //Create a new reservation
        $reservation = new \Modules\Tablereservations\Models\Reservation();
        $reservation->company_id = $company->id;
        $reservation->customer_id = $customer->id;
        $reservation->created_by_user_id = $customer->id;
        $reservation->reservation_date = $request->date;
        $reservation->reservation_time = $request->time;
        $reservation->created_by = 'web widget';
        $reservation->number_of_guests = $request->people;
        $reservation->status = 'pending';
        $reservation->reservation_code = $this->generateRandomString(6);
        $reservation->special_requests = $request->note;
        $reservation->save();




        //Respond with json
        $response = [
            'status' => 'success',
            'message' => 'Reservation made successfully',
            'company' => $company->name,
            'customer' => $customer->name,
            'reservation' => $reservation,
            'data'=> $request->all()
        ];
        return response()->json($response);

    }
}