<?php

namespace Modules\Tablereservations\Database\Seeds;

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

         
         DB::table('plan')->insert([
            'name' => 'Basic',
            'limit_items'=>0,
            'limit_orders'=>0,
            'price'=>0,
            'paddle_id'=>'',
            'description'=>'Our Basic Plan is perfect for small restaurants, offering essential reservation tools to efficiently manage a focused customer base.',
            'features'=>'50 Reservations per month, Basic table management, Email notifications, Web widget, Basic Support',
            'created_at' => now(),
            'updated_at' => now(),
            'enable_ordering'=>0,
        ]);

        DB::table('plan')->insert([
            'name' => 'Premium',
            'limit_items'=>0,
            'limit_orders'=>0,
            'price'=>49,
            'paddle_id'=>'',    
            'period'=>1,
            'description'=>'The Premium Plan offers ultimate flexibility and AI-powered features for growth-focused restaurants, with unlimited reservations and advanced management tools.',
            'features'=>'Unlimited reservations, Advanced table management, AI-powered phone reservations, WhatsApp notifications, Analytics and reporting, Priority Support',
            'created_at' => now(),
            'updated_at' => now(),
            'enable_ordering'=>1,
        ]);

        Model::reguard();
    }
}
