<?php

namespace Modules\Cards\Database\Seeds;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class ClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        //Client
        $demoClientId=DB::table('users')->insertGetId([
            'name' => 'Demo Client',
            'email' =>  'client@example.com',
            'password' => Hash::make('secret'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
            'plan_id'=> 2,
        ]);
        $client=User::find($demoClientId);
        $client->assignRole('client');
        $client->setConfig('city','New York');

        for ($i=0; $i < 4; $i++) { 
            //Create the card
            $demoCardId=DB::table('loyalycards')->insertGetId([
                'vendor_id' => $i+1,
                'client_id' => $demoClientId,
                'points' =>  rand(1000,5000),
                'card_id' => rand(1000,9999)."-".rand(1000,9999)."-".rand(1000,9999)."-".rand(1000,9999),
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        Model::reguard();
    }
}
