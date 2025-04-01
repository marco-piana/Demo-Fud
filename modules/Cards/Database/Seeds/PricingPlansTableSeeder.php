<?php

namespace Modules\Cards\Database\Seeds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PricingPlansTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

         //Whatsapp
         DB::table('plan')->insert([
            'name' => 'Lite',
            'limit_items'=>0,
            'limit_orders'=>0,
            'price'=>15,
            'paddle_id'=>'',
            'description'=>'30 days trial',
            'features'=>'Up to 1000 clients, 5 team members, Email only support, Data export',
            'created_at' => now(),
            'updated_at' => now(),
            'enable_ordering'=>2,
        ]);

        DB::table('plan')->insert([
            'name' => 'Pro',
            'limit_items'=>0,
            'limit_orders'=>0,
            'price'=>25,
            'paddle_id'=>'',
            'period'=>1,
            'description'=>'30 days trial',
            'features'=>'Unlimited clients, Unlimited team members, Phone and email support, Data export',
            'created_at' => now(),
            'updated_at' => now(),
            'enable_ordering'=>1,
        ]);

        // $this->call("OthersTableSeeder");

        Model::reguard();
    }
}
