<?php

namespace Modules\Cards\Http\Controllers;

use App\Models\Posts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PagesController extends RewardsController
{
    protected $imagePath = "";
    protected $type = 'loyaltypage';
    protected $title="";
    protected $itemName="";
    protected $indexRoute='loyaltypages.index';
    protected $editRoute='loyaltypages.edit';
    protected $deleteRoute='loyaltypages.delete';
    protected $createRoute='loyaltypages.create';
    protected $storeRoute='loyaltypages.store';
    protected $updateRoute='loyaltypages.update';

     public function __construct() {
        $this->title=__('Pages');
        $this->itemName=__('Page');
        $this->imagePath = config('app.images_upload_path');
    }
    
     /**
     * Get Fields
     */
    protected function getFields(Posts $post=null)
    {
        $dataToReturn=[];
        array_push($dataToReturn,['ftype'=>'input', 'name'=>'Title', 'id'=>'title', 'placeholder'=>__('Enter title'), 'required'=>true]);
        array_push($dataToReturn,['ftype'=>'textarea', 'name'=>'Content', 'id'=>'description', 'placeholder'=>__('Enter content'), 'required'=>true]);
        array_push($dataToReturn,['ftype'=>'input','type'=>'hidden', 'name'=>'Type', 'id'=>'type', 'placeholder'=>__('Enter type'), 'required'=>true,'value'=>$this->type]);


        if($post){
            $dataToReturn[0]['value']=$post->title;
            $dataToReturn[1]['value']=$post->description;
            $dataToReturn[2]['value']=$post->type;
        }

        return $dataToReturn;
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

}