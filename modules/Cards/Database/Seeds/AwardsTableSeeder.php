<?php

namespace Modules\Cards\Database\Seeds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AwardsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $awards = [
            ['coupon_type'=>'physical','coupon_value'=>0,'vendor_id' => 1,'color'=>'purple','image'=>asset('uploads').'/default/loyalty/ai/pizza_slice.png','points'=>100,'title'=>'{"en":"Get a free pizza"}', 'description'=>'{"en":"Get any pizza from our menu. You can choose any size and any toppings."}'],
            ['coupon_type'=>'physical','coupon_value'=>0,'vendor_id' => 1,'color'=>'gray','image'=>asset('uploads').'/default/loyalty/ai/pizza_and_drink.png','points'=>150,'title'=>'{"en":"Pizza slice + dessert"}', 'description'=>'{"en":"Pizza slice, Drink And Chocolate cup cake"}'],
            ['coupon_type'=>'percentage','coupon_value'=>50,'vendor_id' => 1,'color'=>'purple','image'=>asset('uploads').'/default/loyalty/ai/pizza_slice_50.png','points'=>200,'title'=>'{"en":"50% discount"}', 'description'=>'{"en":"Get 50% discount on your next order."}'],

            ['coupon_type'=>'physical','coupon_value'=>0,'vendor_id' => 2,'color'=>'purple','image'=>asset('uploads').'/default/loyalty/ai/sport_logo.png','points'=>100,'title'=>'{"en":"Sweatshirt"}','description'=>'{"en":"Last collection sweatshirt."}'],
            ['coupon_type'=>'physical','coupon_value'=>0,'vendor_id' => 2,'color'=>'gray','image'=>asset('uploads').'/default/loyalty/ai/sport_combo.png','points'=>170,'title'=>'{"en":"Combo"}','description'=>'{"en":"SOR Designed trainers and sweatshirt."}'],
            ['coupon_type'=>'percentage','coupon_value'=>50,'vendor_id' => 2,'color'=>'purple','image'=>asset('uploads').'/default/loyalty/ai/sport_disc.png','points'=>300,'title'=>'{"en":"50% discount"}','description'=>'{"en":"Get 50% discount on your next order."}'],

            ['coupon_type'=>'physical','coupon_value'=>0,'vendor_id' => 4,'color'=>'purple','image'=>asset('uploads').'/default/loyalty/ai/nails.png','points'=>100,'title'=>'{"en":"Nails makeover"}', 'description'=>'{"en":"Get unique design on your nails"}'],
            ['coupon_type'=>'physical','coupon_value'=>0,'vendor_id' => 4,'color'=>'purple','image'=>asset('uploads').'/default/loyalty/ai/hair.png','points'=>150,'title'=>'{"en":"Hair treatment"}', 'description'=>'{"en":"Let your hair shine with our special treatment"}'],
            ['coupon_type'=>'percentage','coupon_value'=>30,'vendor_id' => 4,'color'=>'purple','image'=>asset('uploads').'/default/loyalty/ai/bea_30.png','points'=>75,'title'=>'{"en":"30% discount"}','description'=>'{"en":"Get 30% discount on your next visit."}'],
            
            ['coupon_type'=>'fixed','coupon_value'=>100,'vendor_id' => 3,'color'=>'purple','image'=>asset('uploads').'/default/loyalty/ai/ring.png','points'=>100,'title'=>'{"en":"Diamond ring"}', 'description'=>'{"en":"Get 1% discount on the world largest 189K diamond ring."}'],
            ['coupon_type'=>'fixed','coupon_value'=>100,'vendor_id' => 3,'color'=>'gray','image'=>asset('uploads').'/default/loyalty/ai/bracelet.png','points'=>120,'title'=>'{"en":"Golden bracelet"}', 'description'=>'{"en":"Get 2% discount on this amazing one of a kind golden bracelet."}'],
            ['coupon_type'=>'percentage','coupon_value'=>30,'vendor_id' => 3,'color'=>'purple','image'=>asset('uploads').'/default/loyalty/ai/j_30.png','points'=>3000,'title'=>'{"en":"30% discount"}','description'=>'{"en":"Get 30% discount on your next visit."}'],
        ];

        foreach ($awards as $key => $award) {
            DB::table('posts')->insert([
                'vendor_id' => $award['vendor_id'],
                'points'=>$award['points'],
                'image'=>$award['image'],
                'color'=>$award['color'],
                'coupon_value'=>$award['coupon_value'],
                'coupon_type'=>$award['coupon_type'],
                'post_type' => 'reward',
                'title' => $award['title'],
                'description' => $award['description'],
                'active_to' => Carbon::now()->addYear(),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // $this->call("OthersTableSeeder");

        Model::reguard();
    }
}
