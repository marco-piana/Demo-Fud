<?php

namespace Modules\Tablereservations\Database\Seeds;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Modules\Contacts\Models\Contact;
use Modules\Tablereservations\Models\Reservation;

class TestReservationSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // Create 2 customers
        $demoContact1=Contact::create([
            'name' => 'Daniel Dimov',
            'phone' =>  '+38978203673',
            'avatar'=> 'https://secure.gravatar.com/avatar/e2909c35cdbad84bf2b6059fe7eab2444cd6bd9fbf8af59918a1d0f4901c8ad2?s=128',
            'company_id'=>1
        ]);

        //Contact 2
        $demoContact2=Contact::create([
            'name' => 'Aleksandra Dimova',
            'phone' =>  '+38978514084',
            'avatar'=> 'https://ca.slack-edge.com/T0JNGF37X-U109XCZC1-a1e054cf2aa3-512',
            'company_id'=>1
        ]);

        //Contact 3 - Emily Davis
        $demoContact3=Contact::create([
            'name' => 'Emily Davis',
            'phone' =>  '+38671246011',
            'avatar'=> 'https://mobidonia-demo.imgix.net/img/testimonials/femaletestimonials/3.png?w=100&h=100',
            'company_id'=>1
        ]);

         //Contact 4
         $demoContact4=Contact::create([
            'name' => 'Alex Johnson',
            'phone' =>  '+38671246022',
            'avatar'=> 'https://mobidonia-demo.imgix.net/img/testimonials/maletestimonials/3.png?w=100&h=100',
            'company_id'=>1
        ]);

        //Create 1 reservation for tomorrow and one for the day after tomorrow using th Reservation module
        $reservation1 = Reservation::create([
            'customer_id' => $demoContact1->id,
            'table_id' => 1,
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' =>"09:00",
            'status' => 'confirmed',
            'company_id' => 1,
            'reservation_code' => 123456,
            'number_of_guests' => 2,

        ]);

        $reservation1a = Reservation::create([
            'customer_id' => $demoContact2->id,
            'table_id' => 3,
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' =>"13:00",
            'status' => 'confirmed',
            'company_id' => 1,
            'reservation_code' => 123458,
            'number_of_guests' => 2,
            'special_requests' => 'Please seat us in a quiet corner.',

        ]);

        $reservation2 = Reservation::create([
            'customer_id' => $demoContact1->id,
            'table_id' => 11,
            'reservation_date' => now()->addDays(2)->format('Y-m-d'),
            'reservation_time' =>"20:00",
            'status' => 'pending',
            'company_id' => 1,
            'reservation_code' => 123457,
            'number_of_guests' => 2,
            'special_requests' => 'VIP table',

        ]);

        $reservation2a = Reservation::create([
            'customer_id' => $demoContact2->id,
            'table_id' => 12,
            'reservation_date' => now()->addDays(2)->format('Y-m-d'),
            'reservation_time' =>"18:00",
            'status' => 'pending',
            'company_id' => 1,
            'reservation_code' => 123459,
            'number_of_guests' => 2,
            'special_requests' => 'Outdoor view',

        ]);

        $reservation3 = Reservation::create([
            'customer_id' => $demoContact3->id,
            'table_id' => 4,
            'reservation_date' => now()->addDay()->format('Y-m-d'),
            'reservation_time' =>"00:10",
            'expected_leave'=>now()->addDays(2),
            'expected_occupancy'=>60*24-10,
            'status' => 'seated',
            'company_id' => 1,
            'reservation_code' => 123460,
            'number_of_guests' => 4,
            'special_requests' => 'Demo reservation - whole table - whole day',

        ]);

        $reservation3 = Reservation::create([
            'customer_id' => $demoContact4->id,
            'table_id' => 4,
            'reservation_date' => now()->addDays(3)->format('Y-m-d'),
            'reservation_time' =>"16:00",
            //'expected_leave'=>now()->addDays(2),
            'expected_occupancy'=>60,
            'status' => 'pending',
            'company_id' => 1,
            'reservation_code' => 123462,
            'number_of_guests' => 4,
            'special_requests' => 'Nothing in particular',

        ]);

        $company=Company::findOrFail(1);

        $company->setConfig('plain_token',"wi9DM0WGlvjtSzx7O8mXB6rEHOIWXbZzQPGZtyzd8622eb1d");


        //The Personal Access Tokens
        DB::table('personal_access_tokens')->insertGetId([
            'tokenable_type' =>'App\Models\User',
            'tokenable_id' => 2,
            'name' => 'Blandai',
            'token' => '1b823baa3f0ae42edcedd2160a9ceb3c8186823254bf835a421e8aef0cfdb912',
            'abilities' => '["*"]',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        

         
        

        Model::reguard();


    }
   
}