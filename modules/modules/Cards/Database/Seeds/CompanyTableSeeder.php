<?php

namespace Modules\Cards\Database\Seeds;

use App\Restorant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\User;

class CompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $text1="Unlock exclusive discounts, rewards, and special offers by joining our loyalty program today!";
        $text2="As a member, you'll earn points for every purchase you make that can be redeemed for discounts on future purchases.";

        //Company owner s
        $demoOwnerId=DB::table('users')->insertGetId([
            'name' => 'Pizza owner',
            'email' =>  'owner@example.com',
            'password' => Hash::make('secret'),
            'api_token' => Str::random(80),
            'email_verified_at' => now(),
            'phone' =>  '',
            'created_at' => now(),
            'updated_at' => now(),
            'plan_id'=> 2,
        ]);

        $demoOwnerId2=DB::table('users')->insertGetId([
            'name' => 'Sport Shop owner',
            'email' =>  'owner2@example.com',
            'password' => Hash::make('secret'),
            'api_token' => Str::random(80),
            'email_verified_at' => now(),
            'phone' =>  '',
            'created_at' => now(),
            'updated_at' => now(),
            'plan_id'=> 2,
        ]);

        //Demo owner for jewwelry shopw
        $demoOwnerId3=DB::table('users')->insertGetId([
            'name' => 'Jewelry Shop owner',
            'email' =>  'owner3@example.com',
            'password' => Hash::make('secret'),
            'api_token' => Str::random(80),
            'email_verified_at' => now(),
            'phone' =>  '',
            'created_at' => now(),
            'updated_at' => now(),
            'plan_id'=> 2,
        ]);

        //Demo owner for Beauty salon
        $demoOwnerId4=DB::table('users')->insertGetId([
            'name' => 'Beauty Salon owner',
            'email' =>  'owner4@example.com',
            'password' => Hash::make('secret'),
            'api_token' => Str::random(80),
            'email_verified_at' => now(),
            'phone' =>  '',
            'created_at' => now(),
            'updated_at' => now(),
            'plan_id'=> 2,
        ]);

        //Assign owner role
        $demoOwner=User::find($demoOwnerId);
        $demoOwner->assignRole('owner');

        $demoOwner2=User::find($demoOwnerId2);
        $demoOwner2->assignRole('owner');

        $demoOwner3=User::find($demoOwnerId3);
        $demoOwner3->assignRole('owner');

        $demoOwner4=User::find($demoOwnerId4);
        $demoOwner4->assignRole('owner');

        // Pizza Restaurant
        $lastRestaurantId=DB::table('companies')->insertGetId([
            'name'=>'Leuka Pizza',
            'is_featured'=>1,
            'active'=>1,
            'logo'=>asset('default').'/ai/pizza_logo.png',
            'cover'=>asset('default').'/ai/pizza_hero.png',
            'city_id'=>null,
            'subdomain'=>'leukapizza', // strtolower(preg_replace('/[^A-Za-z0-9]/', '', $restorant['name'])),
            'user_id'=>$demoOwnerId,
            'created_at' => now(),
            'updated_at' => now(),
            'address' => '6 Yukon Drive Raeford, NC 28376',
            'phone' => '(530) 625-9694',
            'whatsapp_phone' => '+38971605048',
            'description'=>'italian, pasta, pizza',
            'minimum'=>10
        ]);
        $vendor=Restorant::find($lastRestaurantId);
        $vendor->setConfig('loyalty_subtitle','Join our loyalty program and');
        $vendor->setConfig('loyalty_heading','Earn points for every order made');
        $vendor->setConfig('initial_loyalty_text1',$text1);
        $vendor->setConfig('initial_loyalty_text2',$text2);

        //Sport Shop
        $lastRestaurantId2=DB::table('companies')->insertGetId([
            'name'=>'New Power Sport',
            'is_featured'=>1,
            'active'=>1,
            'logo'=>asset('default').'/ai/sport_logo.png',
            'cover'=>asset('default').'/ai/sport_hero.png',
            'city_id'=>null,
            'subdomain'=>'sportshop', // strtolower(preg_replace('/[^A-Za-z0-9]/', '', $restorant['name'])),
            'user_id'=>$demoOwnerId2,
            'created_at' => now(),
            'updated_at' => now(),
            'address' => '6 Yukon Drive Raeford, NC 28376',
            'phone' => '(530) 625-9694',
            'whatsapp_phone' => '+38971605048',
            'description'=>'sport, shoes, clothes',
            'minimum'=>10
        ]);
        $vendor2=Restorant::find($lastRestaurantId2);
        $vendor2->setConfig('loyalty_subtitle','Look at our loyalty program');
        $vendor2->setConfig('loyalty_heading','You can be a part of it');
        $vendor2->setConfig('initial_loyalty_text1',$text1);
        $vendor2->setConfig('initial_loyalty_text2',$text2);


        //Jewelry Shop
        $lastRestaurantId3=DB::table('companies')->insertGetId([
            'name'=>'Bland Jewelry Shop',
            'is_featured'=>1,
            'active'=>1,
            'logo'=>asset('default').'/ai/jewelry_logo.png',
            'cover'=>asset('default').'/ai/jewelry_hero.png',
            'city_id'=>null,
            'subdomain'=>'blandjewelry', // strtolower(preg_replace('/[^A-Za-z0-9]/', '', $restorant['name'])),
            'user_id'=>$demoOwnerId3,
            'created_at' => now(),
            'updated_at' => now(),
            'address' => '6 Yukon Drive Raeford, NC 28376',
            'phone' => '(530) 625-9694',
            'whatsapp_phone' => '+38971605048',
            'description'=>'jewelry, gold, silver',
            'minimum'=>10
        ]);
        $vendor3=Restorant::find($lastRestaurantId3);
        $vendor3->setConfig('loyalty_subtitle','Not just diamonds');
        $vendor3->setConfig('loyalty_heading','But also your points are forever');
        $vendor3->setConfig('initial_loyalty_text1',$text1);
        $vendor3->setConfig('initial_loyalty_text2',$text2);

        //Beauty Salon
        $lastRestaurantId4=DB::table('companies')->insertGetId([
            'name'=>'Beauty Salon',
            'is_featured'=>1,
            'active'=>1,
            'logo'=>asset('default').'/ai/beauty_logo.png',
            'cover'=>asset('default').'/ai/beauty_hero.png',
            'city_id'=>null,
            'subdomain'=>'beautysalon', // strtolower(preg_replace('/[^A-Za-z0-9]/', '', $restorant['name'])),
            'user_id'=>$demoOwnerId4,
            'created_at' => now(),
            'updated_at' => now(),
            'address' => '6 Yukon Drive Raeford, NC 28376',
            'phone' => '(530) 625-9694',
            'whatsapp_phone' => '+38971605048',
            'description'=>'beauty, hair, nails',
            'minimum'=>10
        ]);
        $vendor4=Restorant::find($lastRestaurantId4);
        $vendor4->setConfig('loyalty_subtitle','Loyalty program');
        $vendor4->setConfig('loyalty_heading','That will make you happy');
        $vendor4->setConfig('initial_loyalty_text1',$text1);
        $vendor4->setConfig('initial_loyalty_text2',$text2);

        //PIZZA
        $pizzaCate=[[
            'name'=>'Classic Pizzas',
            'percent'=>10,
            'staticpoints'=>5,
            'threshold'=>10
        ],
        [
            'name'=>'Gourmet Pizzas',
            'percent'=>20,
            'staticpoints'=>6,
            'threshold'=>15
        ],
        [
            'name'=>'Specialty Pizzas',
            'percent'=>20,
            'staticpoints'=>5,
            'threshold'=>20
        ]];
        
        //SPORT
        $sportCate=[[
            'name'=>'Shoes',
            'percent'=>10,
            'staticpoints'=>5,
            'threshold'=>100
        ],
        [
            'name'=>'Clothes',
            'percent'=>20,
            'staticpoints'=>6,
            'threshold'=>150
        ],
        [
            'name'=>'Accessories',
            'percent'=>20,
            'staticpoints'=>5,
            'threshold'=>150
        ]];
        
        //JEWELRY
        $jewelryCate=[[
            'name'=>'Gold',
            'percent'=>2,
            'staticpoints'=>5,
            'threshold'=>1000
        ],
        [
            'name'=>'Silver',
            'percent'=>5,
            'staticpoints'=>6,
            'threshold'=>1600
        ],
        [
            'name'=>'Diamonds',
            'percent'=>1,
            'staticpoints'=>5,
            'threshold'=>1700
        ]];

        //BEAUTY Salon
        $beautyCate=[[
            'name'=>'Hair',
            'percent'=>10,
            'staticpoints'=>5,
            'threshold'=>100
        ],
        [
            'name'=>'Nails',
            'percent'=>20,
            'staticpoints'=>6,
            'threshold'=>160
        ],
        [
            'name'=>'Makeup',
            'percent'=>20,
            'staticpoints'=>5,
            'threshold'=>180
        ]];

        $allCats=[];
        $allCats[$lastRestaurantId]=$pizzaCate;
        $allCats[$lastRestaurantId2]=$sportCate;
        $allCats[$lastRestaurantId3]=$jewelryCate;
        $allCats[$lastRestaurantId4]=$beautyCate;


        foreach ($allCats as $vendor_id => $categories) {
            foreach ($categories as $key => $category) {
                DB::table('categories')->insert([
                    'name'=>$category['name'],
                    'restorant_id'=> $vendor_id,
                    'percent'=>$category['percent'],
                    'staticpoints'=>$category['staticpoints'],
                    'threshold'=>$category['threshold'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            
        }




        Model::reguard();
    }
}
