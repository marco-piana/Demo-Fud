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
         //if project is not in demo mode, don't insert demo data
         if(!config('settings.is_demo',false)){
            return;
        }

        if(config('settings.app_code_name')!='loyalty'){
            return;
        }

        Model::unguard();

        //Insert Features 
        $this->call(FeaturesTableSeeder::class);

        //Insert pricing plans
        $this->call(PricingPlansTableSeeder::class);

        
        //Insert company
        $this->call(CompanyTableSeeder::class);

        //Insert client
        $this->call(ClientTableSeeder::class);

        //Insert fAQ Seeder
        $this->call(FAQTableSeeder::class);

        //Insert awards
        $this->call(AwardsTableSeeder::class);


        // $this->call("OthersTableSeeder");

        Model::reguard();
    }
}
