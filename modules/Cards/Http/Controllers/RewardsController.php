<?php

namespace Modules\Cards\Http\Controllers;

use App\Models\Posts;
use App\Http\Controllers\Controller;
use App\Models\Com;
use Illuminate\Http\Request;
use Modules\Coupons\Models\Coupons;

class RewardsController extends Controller
{
    protected $imagePath = "";
    protected $type = 'reward';
    protected $title="";
    protected $itemName="";
    protected $indexRoute='loyaltyawards.index';
    protected $editRoute='loyaltyawards.edit';
    protected $deleteRoute='loyaltyawards.delete';
    protected $createRoute='loyaltyawards.create';
    protected $storeRoute='loyaltyawards.store';
    protected $updateRoute='loyaltyawards.update';

     public function __construct() {
        $this->title=__('Rewards');
        $this->itemName=__('Reward');
        $this->imagePath = config('app.images_upload_path');
    }
    
     /**
     * Get Fields
     */
    protected function getFields(Posts $post=null)
    {
        $dataToReturn=[];
        array_push($dataToReturn,['ftype'=>'image', 'name'=>__('Image'), 'id'=>'image']);
        array_push($dataToReturn,['ftype'=>'input', 'name'=>'Title', 'id'=>'title', 'placeholder'=>__('Enter title'), 'required'=>true]);
        array_push($dataToReturn,['ftype'=>'input', 'name'=>'Description', 'id'=>'description', 'placeholder'=>__('Enter description'), 'required'=>true]);
        array_push($dataToReturn,['ftype'=>'input', 'name'=>'Text after redeem', 'id'=>'subtitle', 'placeholder'=>__('Enter subtitle'), 'required'=>true]);
        array_push($dataToReturn,['ftype'=>'input', 'editclass'=>'col-2', 'type'=>"number", 'name'=>"Points needed", 'id'=>'points', 'placeholder'=>__('Enter points needed'), 'required'=>false]);
        array_push($dataToReturn,['ftype'=>'select','name'=>"Reward Type", 'id'=>'coupon_type', 'data'=>["fixed"=>'Fixed', "percentage"=>'Percentage',"physical"=>'Physical product',"digital"=>'Digital product'], 'required'=>true]);
        array_push($dataToReturn,['ftype'=>'input', 'editclass'=>'col-2', 'type'=>"number", 'name'=>"Value for the discount", 'id'=>'coupon_value', 'placeholder'=>__('Enter percent or value'), 'required'=>true]);
        array_push($dataToReturn,['ftype'=>'input','editclass'=>'col-2','type'=>'date', 'name'=>'Active to', 'id'=>'active_to', 'required'=>true,'placeholder'=>__('Select date')]);
        array_push($dataToReturn,['ftype'=>'input','editclass'=>'col-2','type'=>'color', 'name'=>'Color', 'id'=>'color', 'required'=>true,'placeholder'=>__('Select color')]);
        //array_push($dataToReturn,['ftype'=>'input', 'name'=>'Link Name', 'id'=>'link_name', 'placeholder'=>__('Enter link name'), 'required'=>false]);
        //array_push($dataToReturn,['ftype'=>'input', 'name'=>'Link ', 'id'=>'link', 'placeholder'=>__('Enter link URL'), 'required'=>false]);
        array_push($dataToReturn,['ftype'=>'input','type'=>'hidden', 'name'=>'Type', 'id'=>'type', 'placeholder'=>__('Enter type'), 'required'=>true,'value'=>$this->type]);


        if($post){
            $dataToReturn[0]['value']=strlen($post->image)>3?$post->image_link:null;
            $dataToReturn[1]['value']=$post->title;
            $dataToReturn[2]['value']=$post->description;
            $dataToReturn[3]['value']=$post->subtitle;
            $dataToReturn[4]['value']=$post->points;
            $dataToReturn[5]['value']=$post->coupon_type;
            $dataToReturn[6]['value']=$post->coupon_value;
            $dataToReturn[7]['value']=$post->active_to;
            $dataToReturn[8]['value']=$post->color;
            $dataToReturn[9]['value']=$post->type;
        }


        return $dataToReturn;
    }

    public function getCreateRules(){
        $rules=[
            'title' => ['required', 'string', 'max:255'],
        ];
        return $rules;
    }

    public function validateAccess()
    {
        if (!auth()->user()->hasRole(['admin','owner','staff'])) {
            abort(404);
        }
    }

    public function index()
    {
        $this->validateAccess();
        return view('crud.posts.index', ['setup' => [
            'iscontent' => true,
            'title' => $this->title,
            'action_link' => route($this->createRoute,['type'=>$this->type]),
            'edit_link' => $this->editRoute,
            'delete_link'=>$this->deleteRoute,
            'action_name' => __('Add new'),
            'items' => Posts::where('post_type', $this->type)->where('vendor_id',$this->getCompany()->id)->get(),
            'item_names' => $this->title,
            'breadcrumbs' => [
                [$this->title, route($this->indexRoute,['type'=>$this->type])],
            ],
        ]]);
    }

    public function peruser(){

        $items=Coupons::where('user_id',auth()->user()->id)->orderBy('id', 'desc');
        $items=$items->paginate(config('settings.paginate'));

        return view('cards::awards.per_user_index',
           
            [ 'setup' => [
            //'usefilter'=>false,
            'title'=>__('Your awards'),
            'items'=>$items,
            'item_names'=>__('Awards'),
            'webroute_path'=>'',
            'fields'=>[],
           
            'filterFields'=>[],
            'custom_table'=>true,
            //'parameter_name'=>$this->parameter_name,
            //'parameters'=>count($_GET) != 0,
        ]]);
    }

    public function create()
    {
        $this->validateAccess();
        return view('general.form', ['setup' => [
                'title'=>__('crud.add_new_item', ['item'=>__($this->itemName)]),
                'action_link' => route($this->indexRoute),
                'action_name' => __('Back'),
                'iscontent' => true,
                'action' => route($this->storeRoute),
                'breadcrumbs' => [
                    [$this->title, route($this->indexRoute)],
                    [__('New'), null],
                ],
            ],
            'fields'=>$this->getFields(null)
        ]);
    }

    public function store(Request $request)
    {
        $this->validateAccess();
        //Validate first
        $request->validate($this->getCreateRules());

        $post = Posts::create([
            'post_type' => $this->type,
            'title' => $request->title,
            'description' => $request->description,
            'image'=>'',
            'points'=>$request->points,
            'subtitle'=>$request->subtitle,
            'coupon_type'=>$request->coupon_type,
            'coupon_value'=>$request->coupon_value,
            'active_to'=>$request->active_to,
            'color'=>$request->color,
            'vendor_id'=>$this->getCompany()->id
        ]);

        $post->save();

        if ($request->hasFile('image')) {
            $post->image = $this->saveImageVersions(
                $this->imagePath,
                $request->image,
                [
                    ['name'=>'large'],
                ]
            );
            $post->update();
        }

        return redirect()->route($this->indexRoute)->withStatus(__('crud.item_has_been_added', ['item'=>$this->itemName]));
    }

    public function destroy(Posts $post)
    {
        $this->validateAccess();
        $post->delete();

        return redirect()->route($this->indexRoute)->withStatus(__('Item was deleted.'));
    }

    public function edit(Posts $post)
    {
        
        $this->validateAccess();
        $fields = $this->getFields($post);
        $itemName=$this->itemName;
        $title=$this->title;
        return view('general.form', ['setup' => [
            'title' => __('crud.edit_item_name', ['item'=>$itemName, 'name'=>$post->title]),
            'action_link' => route($this->indexRoute,['type'=>$post->post_type]),
            'action_name' => __('Back'),
            'iscontent' => true,
            'isupdate' => true,
            'action' => route($this->updateRoute, ['post' => $post->id]),
            'breadcrumbs' => [
                //[__('Landing Page'), route('admin.landing')],
                [$title, route($this->indexRoute,['type'=>$post->post_type])],
                [$post->title, null],
            ],
        ],
        'fields'=>$fields, ]);
    }

    public function update(Request $request, Posts $post)
    {
        $this->validateAccess();

        $post->title = $request->title;
        if($request->has('subtitle')){
            $post->subtitle = $request->subtitle;
        }
        if($request->has('description')){
            $post->description = $request->description;
        }
        if($request->has('link')){
            $post->link = $request->link;
        }
        if($request->has('link_name')){
            $post->link_name = $request->link_name;
        }

        if($request->has('points')){
            $post->points = $request->points;
        }
        if($request->has('coupon_type')){
            $post->coupon_type = $request->coupon_type;
        }
        if($request->has('coupon_value')){
            $post->coupon_value = $request->coupon_value;
        }
        if($request->has('active_to')){
            $post->active_to = $request->active_to;
        }
        if($request->has('color')){
            $post->color = $request->color;
        }

    

        if ($request->hasFile('image')) {
            $post->image = $this->saveImageVersions(
                $this->imagePath,
                $request->image,
                [
                    ['name'=>'large'],
                ]
            );
        }

        $post->update();

        return redirect()->route($this->indexRoute,['type'=>$post->post_type])->withStatus(__('Item was updated'));
    }

}