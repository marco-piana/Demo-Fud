<?php

namespace Modules\Cards\Database\Seeds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CardsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if(config('app.isloyalty')){

            //Update setting table , row with id 1
            //Settings
            DB::table('settings')->update([
                'id' => 1,
                'description' => 'Loyalty program at its finest',
                'restorant_details_cover_image'=>'/default/emptycover.jpg'
            ]);


            //Insert Features 
            $this->call(FeaturesTableSeeder::class);

            //Insert pricing plans
            $this->call(PricingPlansTableSeeder::class);

            if(config('settings.demo_data',true)){
                //Insert company
                $this->call(CompanyTableSeeder::class);

                //Insert client
                $this->call(ClientTableSeeder::class);

                //Insert fAQ Seeder
                $this->call(FAQTableSeeder::class);

                //Insert awards
                $this->call(AwardsTableSeeder::class);
            }

            
            
        }

        
        

        // $this->call("OthersTableSeeder");

        Model::reguard();
    }
}
