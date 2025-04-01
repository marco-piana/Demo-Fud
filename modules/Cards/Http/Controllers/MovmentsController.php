<?php

namespace Modules\Cards\Http\Controllers;

use Modules\Cards\Models\Categories;
use Modules\Cards\Models\Movments;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Modules\Cards\Models\Card;
use Modules\Cards\Notifications\LoyaltyMovmentCreated;

class MovmentsController extends Controller
{
    /**
     * Provide class.
     */
    private $provider = Movment::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'loyalty.movments.';

    /**
     * View path.
     */
    private $view_path = 'cards::movments.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'movment';

    /**
     * Title of this crud.
     */
    private $title = 'movement';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'Movements';

    private function getFields($class='col-md-4')
    {
        $fields=[];
        
        //Add name field
        $fields[0]=['class'=>$class, 'ftype'=>'input', 'name'=>'Name', 'id'=>'name', 'placeholder'=>'Enter name', 'required'=>true];

        //Add email field
        $fields[1]=['class'=>$class, 'ftype'=>'input','type'=>"email", 'name'=>'Email', 'id'=>'email', 'placeholder'=>'Enter email', 'required'=>true];

        //Add phone field
        $fields[2]=['class'=>$class, 'ftype'=>'input','type'=>"phone", 'name'=>'Phone', 'id'=>'phone', 'placeholder'=>'Enter phone', 'required'=>true];

        //Add movment id field
        $fields[3]=['class'=>$class, 'ftype'=>'input', 'name'=>'Movment id', 'id'=>'movment_id', 'placeholder'=>'Enter movment id', 'required'=>false];

        //Add movment initial points field
        $fields[4]=['class'=>$class, 'ftype'=>'input', 'name'=>'Initial points', 'id'=>'points', 'placeholder'=>'Enter initial points','value'=>0, 'required'=>true];

        //Return fields
        return $fields;
    }


    private function getFilterFields(){
        $fields=$this->getFields('col-md-3');
        $fields[0]['required']=false;
        $fields[1]['required']=false;
        $fields[2]['required']=false;
        $fields[3]['required']=false;
        unset($fields[4]);

        return $fields;
    }

    /**
     * Auth checker functin for the crud.
     */
    private function authChecker()
    {
        $this->ownerAndStaffOnly();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Card $card)
    {
        $this->authChecker();
        if($card->vendor_id != $this->getCompany()->id){
            abort(404);
        }
        
       
        $items=Movments::where('vendor_id', $this->getCompany()->id)->where('loyalycard_id',$card->id)->orderBy('id', 'desc');
        $items=$items->paginate(config('settings.paginate'));

        return view($this->view_path.'index',
            ['card'=>$card,'setup' => [
            //'usefilter'=>false,
            'title'=>__($this->titlePlural),
            'action_link'=>route('loyalty.cards.index'),
            'action_name'=>__('crud.back'),
            'items'=>$items,
            'item_names'=>$this->titlePlural,
            'webroute_path'=>$this->webroute_path,
            'fields'=>[],
           
            'filterFields'=>[],
            'custom_table'=>true,
            //'parameter_name'=>$this->parameter_name,
            //'parameters'=>count($_GET) != 0,
        ]]);
    }

    /**
     * Display movments per user
     * 
     */
    public function perUser(){
        $items=Movments::orderBy('id', 'desc');
        $items=$items->whereHas('card', function ($query) {
            $query->where('client_id', auth()->user()->id);
        });

        $items=$items->paginate(config('settings.paginate'));

        return view($this->view_path.'per_user_index',
            ['setup' => [
            //'usefilter'=>false,
            'title'=>__('Transactions'),
            'items'=>$items,
            'item_names'=>$this->titlePlural,
            'webroute_path'=>$this->webroute_path,
            'fields'=>[],
           
            'filterFields'=>[],
            'custom_table'=>true,
            //'parameter_name'=>$this->parameter_name,
            //'parameters'=>count($_GET) != 0,
        ]]);
}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->authChecker();


        return view('general.form', ['setup' => [
            'title'=>__('crud.new_item', ['item'=>__($this->title)]),
            'action_link'=>route($this->webroute_path.'index'),
            'action_name'=>__('crud.back'),
            'iscontent'=>true,
            'action'=>route($this->webroute_path.'store'),
        ],
        'fields'=>$this->getFields() ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->authChecker();

        $vendor=$this->getCompany();
        
        //Create new client user
        $password=Str::random(8);
        $client = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($password),
            'active' => 1,
            'api_token' => Str::random(80)
        ]);
        $client->save();
        $client->assignRole('client');
        

        //Create the movment
        $item = $this->provider::create([
            'movment_id' => $request->movment_id,
            'client_id' =>$client->id,
            'vendor_id' => $vendor->id,
            'points' => $request->points
        ]);

        $item->save();

        //Send notification to the client for his new movment account LoyaltyMovmentCreated
        $client->notify(new LoyaltyMovmentCreated($client,$item,$vendor,$password));

        return redirect()->route($this->webroute_path.'index')->withStatus(__('crud.item_has_been_added', ['item'=>__($this->title)]));
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Movments  $movments
     * @return \Illuminate\Http\Response
     */
    public function edit(Movment $movment)
    {
        $this->authChecker();
        if($movment->vendor_id != $this->getCompany()->id){
            abort(404);
        }


        $fields = $this->getFields();
        $fields[0]['value'] = $movment->client->name;
        $fields[1]['value'] = $movment->client->email;
        $fields[2]['value'] = $movment->client->phone;
        $fields[3]['value'] = $movment->movment_id;
        $fields[4]['value'] = $movment->points;
        $fields[4]['name'] = __('Points');

        $parameter = [];
        $parameter[$this->parameter_name] = $movment->id;

        return view($this->view_path.'edit', ['setup' => [
            'title'=>__('crud.edit_item_name', ['item'=>__($this->title), 'name'=>$movment->movment_id." - ".$movment->client->name]),
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
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Movments  $movments
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authChecker();
        $item = $this->provider::findOrFail($id);
        $item->name = $request->name;
        $item->code = $request->code;
        $item->type = $request->type;
        $item->price = $request->type == 0 ? $request->price_fixed : $request->price_percentage;
        $item->active_from = $request->active_from;
        $item->active_to = $request->active_to;
        $item->limit_to_num_uses = $request->limit_to_num_uses;

        $item->update();

        return redirect()->route($this->webroute_path.'index')->withStatus(__('crud.item_has_been_updated', ['item'=>__($this->title)]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Movments  $movments
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->authChecker();
        $item = $this->provider::findOrFail($id);
        $item->delete();
        return redirect()->route($this->webroute_path.'index')->withStatus(__('crud.item_has_been_removed', ['item'=>__($this->title)]));
    }
    
}
