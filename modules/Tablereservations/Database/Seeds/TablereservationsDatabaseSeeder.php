<?php

namespace Modules\Tablereservations\Database\Seeds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class TablereservationsDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        if(config('settings.app_code_name')!='reservations'){
            return;
        }

        //if project is not in demo mode, don't insert demo data
        if(!config('settings.is_demo',false)){
            return;
        }
        
        //Insert Plans
        $this->call(PricingPlansTableSeeder::class);
        
        //Insert company
        $this->call(CompanyTableSeeder::class);

        //Insert Landing page data
        $this->call(LandingSeeder::class);

        //Insert the test reservation
        $this->call(TestReservationSeeder::class);

        Model::reguard();
    }
}
