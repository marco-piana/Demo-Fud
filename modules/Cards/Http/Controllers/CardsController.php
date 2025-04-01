<?php

namespace Modules\Cards\Http\Controllers;

use Modules\Cards\Models\Categories;
use Modules\Cards\Models\Movments;
use Modules\Cards\Models\Card;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Modules\Cards\Exports\ClientsExport;
use Modules\Cards\Notifications\LoyaltyCardCreated;
use Maatwebsite\Excel\Facades\Excel;

class CardsController extends Controller
{
    /**
     * Provide class.
     */
    private $provider = Card::class;

    /**
     * Web RoutePath for the name of the routes.
     */
    private $webroute_path = 'loyalty.cards.';

    /**
     * View path.
     */
    private $view_path = 'cards::cards.';

    /**
     * Parameter name.
     */
    private $parameter_name = 'card';

    /**
     * Title of this crud.
     */
    private $title = 'card';

    /**
     * Title of this crud in plural.
     */
    private $titlePlural = 'cards';

    private function getFields($class='col-md-4')
    {
        $fields=[];
        
        //Add name field
        $fields[0]=['class'=>$class, 'ftype'=>'input', 'name'=>'Name', 'id'=>'name', 'placeholder'=>'Enter name', 'required'=>true];

        //Add email field
        $fields[1]=['class'=>$class, 'ftype'=>'input','type'=>"email", 'name'=>'Email', 'id'=>'email', 'placeholder'=>'Enter email', 'required'=>true];

        //Add phone field
        $fields[2]=['class'=>$class, 'ftype'=>'input','type'=>"phone", 'name'=>'Phone', 'id'=>'phone', 'placeholder'=>'Enter phone', 'required'=>true];

        //Add card id field
        $fields[3]=['class'=>$class, 'ftype'=>'input', 'name'=>'Card id', 'id'=>'card_id', 'placeholder'=>'Enter card id', 'required'=>false];

        //Add card initial points field
        $fields[4]=['class'=>$class, 'ftype'=>'input', 'name'=>'Initial points', 'id'=>'points', 'placeholder'=>'Enter initial points','value'=>0, 'required'=>true];

        //Add client address
        $fields[5]=['class'=>$class, 'ftype'=>'input', 'name'=>'Address', 'id'=>'address', 'placeholder'=>'Enter address', 'required'=>false];
        
        //Add client city
        $fields[6]=['class'=>$class, 'ftype'=>'input', 'name'=>'City', 'id'=>'city', 'placeholder'=>'Enter city', 'required'=>false];

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
        unset($fields[5]);
        unset($fields[6]);

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
    public function index()
    {
        $this->authChecker();

        $items=Card::where('vendor_id', $this->getCompany()->id)->with('client')->orderBy('id', 'desc');
        if(isset($_GET['name'])){
            $items=$items->whereHas('client', function ($query) {
                $query->where('name',  'like', '%'.$_GET['name'].'%');
            });
        }
        if(isset($_GET['email'])){
            $items=$items->whereHas('client', function ($query) {
                $query->where('email',  'like', '%'.$_GET['email'].'%');
            });
        }
        if(isset($_GET['phone'])){
            $items=$items->whereHas('client', function ($query) {
                $query->where('phone',  'like', '%'.$_GET['phone'].'%');
            });
        }
        if(isset($_GET['card_id'])){
            $items=$items->where('card_id', 'like', '%'.$_GET['card_id'].'%');
        }
        if(isset($_GET['report'])){
            return $this->exportCSV($items->get());
        }

        $items=$items->paginate(config('settings.paginate'));

        return view($this->view_path.'index', ['setup' => [
            'usefilter'=>true,
            'title'=>__('crud.item_managment', ['item'=>__($this->titlePlural)]),
            'action_link'=>route($this->webroute_path.'create'),
            'action_name'=>__('crud.add_new_item', ['item'=>__($this->title)]),
            'action_link2'=>route($this->webroute_path.'index',['report'=>true]),
            'action_name2'=>__('Export'),
            'items'=>$items,
            'item_names'=>$this->titlePlural,
            'webroute_path'=>$this->webroute_path,
            'fields'=>$this->getFields(),
            'filterFields'=>$this->getFilterFields(),
            'custom_table'=>true,
            'parameter_name'=>$this->parameter_name,
            'parameters'=>count($_GET) != 0,
        ]]);
    }

    public function exportCSV($cardsToDownload){
        $items=[];
        foreach ($cardsToDownload as $key => $card) {
            $client=$card->client;
            $item = [
                'card'=>$card->card_id,
                'client_name'=>$client->name,
                'client_email'=>$client->email,
                'client_phone'=>$client->phone,
                'client_address'=>$client->getConfig('address',''),
                'client_city'=>$client->getConfig('city',''),
                'created'=>$client->created_at,
                'points'=>$card->points,
                'movements'=>$card->movments->count()
            ];
            array_push($items, $item);
        }

        return Excel::download(new ClientsExport($items), 'cards_'.time().'.csv', \Maatwebsite\Excel\Excel::CSV);
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
        $client->setConfig('address',$request->address);
        $client->setConfig('city',$request->city);

        

        //Create the card
        $item = $this->provider::create([
            'card_id' => $request->card_id,
            'client_id' =>$client->id,
            'vendor_id' => $vendor->id,
            'points' => $request->points
        ]);

        $item->save();

        //Send notification to the client for his new card account LoyaltyCardCreated
        $client->notify(new LoyaltyCardCreated($client,$item,$vendor,$password));

        return redirect()->route($this->webroute_path.'index')->withStatus(__('crud.item_has_been_added', ['item'=>__($this->title)]));
    }

    

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Cards  $cards
     * @return \Illuminate\Http\Response
     */
    public function edit(Card $card)
    {
        $this->authChecker();
        if($card->vendor_id != $this->getCompany()->id){
            abort(404);
        }


        $fields = $this->getFields();
        $fields[0]['value'] = $card->client->name;
        $fields[1]['value'] = $card->client->email;
        $fields[2]['value'] = $card->client->phone;
        $fields[3]['value'] = $card->card_id;
        $fields[4]['value'] = $card->points;
        $fields[4]['name'] = __('Points');
        $fields[5]['value'] = $card->client->getConfig('address','');
        $fields[6]['value'] = $card->client->getConfig('city','');

        $parameter = [];
        $parameter[$this->parameter_name] = $card->id;

        return view($this->view_path.'edit', ['setup' => [
            'title'=>__('crud.edit_item_name', ['item'=>__($this->title), 'name'=>$card->card_id." - ".$card->client->name]),
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
     * @param  \App\Cards  $cards
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->authChecker();
        $item = $this->provider::findOrFail($id);
        $item->points = $request->points;
        $item->card_id = $request->card_id;
        $item->update();

        $item->client->name = $request->name;
        $item->client->email = $request->email;
        $item->client->phone = $request->phone;
        $item->client->update();

        $item->client->setConfig('address',$request->address);
        $item->client->setConfig('city',$request->city);


        return redirect()->route($this->webroute_path.'index')->withStatus(__('crud.item_has_been_updated', ['item'=>__($this->title)]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Cards  $cards
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
       // $this->authChecker();
        //$item = $this->provider::findOrFail($id);
        //$item->delete();
        //return redirect()->route($this->webroute_path.'index')->withStatus(__('crud.item_has_been_removed', ['item'=>__($this->title)]));
    }
    
}
