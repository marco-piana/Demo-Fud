<?php

namespace Modules\Cards\Database\Seeds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FeaturesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $features = [
            ['title'=>'{"en":"Award based system"}', 'description'=>'{"en":"Create different awards for your clients They can use their earned points to get the award they like."}', 'image'=>asset('uploads').'/default/loyalty/icons/gift.svg'],
            ['title'=>'{"en":"Points into discount"}', 'description'=>'{"en":"You client can use their points to make discount coupons that later they will use in your venue"}', 'image'=>asset('uploads').'/default/loyalty/icons/ordering.svg'],
            ['title'=>'{"en":"Let them love your brand"}', 'description'=>'{"en":"Transparent loyalty program, that will turn your customers into loyal customers"}', 'image'=>asset('uploads').'/default/loyalty/icons/like.svg'],
            ['title'=>'{"en":"Stay connected with customers"}', 'description'=>'{"en":"Get to know your customers. Their spending habits and award usage"}', 'image'=>asset('uploads').'/default/loyalty/icons/customers.svg'],
            //['title'=>'{"en":"Views & orders analytics"}', 'description'=>'{"en":"Get detailed report about your orders and earning. Track your business as it grows with us.."}', 'image'=>asset('social').'/default/loyalty/icons/analytics.svg'],
            //['title'=>'{"en":"Know your customers"}', 'description'=>'{"en":"You are creating a direct bound with your customers. Loyal customer, will know where to find you next time. "}', 'image'=>asset('social').'/default/loyalty/icons/customers.svg'],
        ];

        foreach ($features as $key => $feature) {
            DB::table('posts')->insert([
                'post_type' => 'feature',
                'subtitle' => isset($feature['subtitle'])?$feature['subtitle']:"",
                'title' => $feature['title'],
                'description' => $feature['description'],
                'image' => $feature['image'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // $this->call("OthersTableSeeder");

        Model::reguard();
    }
}
