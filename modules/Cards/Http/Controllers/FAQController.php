<?php

namespace Modules\Cards\Http\Controllers;

use App\Models\Posts;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FAQController extends RewardsController
{
    protected $type = 'loyaltyfaq';
    protected $title="";
    protected $itemName="";
    protected $indexRoute='loyaltyfaq.index';
    protected $editRoute='loyaltyfaq.edit';
    protected $deleteRoute='loyaltyfaq.delete';
    protected $createRoute='loyaltyfaq.create';
    protected $storeRoute='loyaltyfaq.store';
    protected $updateRoute='loyaltyfaq.update';

     public function __construct() {
        $this->title=__('FAQ');
        $this->itemName=__('FAQ');
        $this->imagePath = config('app.images_upload_path');
    }
    
     /**
     * Get Fields
     */
    protected function getFields(Posts $post=null)
    {
        $dataToReturn=[];
        array_push($dataToReturn,['ftype'=>'input', 'name'=>'Title', 'id'=>'title', 'placeholder'=>__('Enter title'), 'required'=>true]);
        array_push($dataToReturn,['ftype'=>'input', 'name'=>'Description', 'id'=>'description', 'placeholder'=>__('Enter description'), 'required'=>true]);
        array_push($dataToReturn,['ftype'=>'input','type'=>'hidden', 'name'=>'Type', 'id'=>'type', 'placeholder'=>__('Enter type'), 'required'=>true,'value'=>$this->type]);


        if($post){
            $dataToReturn[0]['value']=$post->title;
            $dataToReturn[1]['value']=$post->description;
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