<?php

namespace Modules\Tablereservations\Database\Seeds;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

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

       
        //Company owner 
        $demoOwnerId=DB::table('users')->insertGetId([
            'name' => 'Company owner',
            'email' =>  'owner@example.com',
            'password' => Hash::make('secret'),
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
            'plan_id'=> 2,
        ]);

        //Assign owner role
        $demoOwner=User::find($demoOwnerId);
        $demoOwner->assignRole('owner');

      

        // Pizza
        $id=DB::table('companies')->insertGetId([
            'name'=>'Pizza Restaurant',
            'is_featured'=>1,
            'active'=>1,
            'logo'=>asset('uploads').'/default/reservations/pizza_logo.png',
            'cover'=>asset('uploads').'/default/reservations/pizza_hero.png',
            'subdomain'=>'leukapizza',
            'user_id'=>$demoOwnerId,
            'created_at' => now(),
            'updated_at' => now(),
            'address' => '6 Yukon Drive Raeford, NC 28376',
            'phone' => '(530) 625-9694',
            'whatsapp_phone' => '+38971203673',
            'description'=>'italian, pasta, pizza',
            'minimum'=>10
        ]);
        //$id=Company::find($lastCompanyId);




        $planInside = [
            [
                'x' => 90.14,
                'y' => 59.02,
                'w' => 120.0,
                'h' => 87.0,
                'rounded' => 'no',
            ],
            [
                'x' => 87.65,
                'y' => 173.37,
                'w' => 120.0,
                'h' => 87.0,
                'rounded' => 'no',
            ],
            [
                'x' => 86.12,
                'y' => 285.06,
                'w' => 120.0,
                'h' => 87.0,
                'rounded' => 'no',
            ],
            [
                'x' => 82.89,
                'y' => 401.49,
                'w' => 121.19,
                'h' => 87.0,
                'rounded' => 'no',
            ],
            [
                'x' => 317.66,
                'y' => 191.56,
                'w' => 193.5,
                'h' => 156.62,
                'rounded' => 'yes',
            ],
            [
                'x' => 600.66,
                'y' => 295.35,
                'w' => 120.0,
                'h' => 120.0,
                'rounded' => 'yes',
            ],
            [
                'x' => 595.45,
                'y' => 141.78,
                'w' => 120.0,
                'h' => 120.0,
                'rounded' => 'yes',
            ],
            [
                'x' => 874.8,
                'y' => 45.66,
                'w' => 120.0,
                'h' => 87.0,
                'rounded' => 'no',
            ],
            [
                'x' => 874.59,
                'y' => 177.19,
                'w' => 120.0,
                'h' => 191.45,
                'rounded' => 'no',
            ],
            [
                'x' => 871.71,
                'y' => 418.7,
                'w' => 120.0,
                'h' => 87.0,
                'rounded' => 'no',
            ],
        ];

        $planTerrase = [
            [
                'x' => 487.37,
                'y' => 284.18,
                'w' => 246.98,
                'h' => 87.0,
                'rounded' => 'no',
            ],
            [
                'x' => 222.27,
                'y' => 285.05,
                'w' => 242.19,
                'h' => 87.0,
                'rounded' => 'no',
            ],
            [
                'x' => 223.63,
                'y' => 86.4,
                'w' => 120.0,
                'h' => 120.0,
                'rounded' => 'yes',
            ],
            [
                'x' => 420.13,
                'y' => 88.23,
                'w' => 120.0,
                'h' => 120.0,
                'rounded' => 'yes',
            ],
            [
                'x' => 614.11,
                'y' => 90.74,
                'w' => 120.0,
                'h' => 120.0,
                'rounded' => 'yes',
            ],
        ];
        $areas = [['name' => 'Inside', 'count' => 10, 'plan' => $planInside], ['name' => 'Terrasse', 'count' => 5, 'plan' => $planTerrase]];
        foreach ($areas as $key => $restoarea) {
            $lastAreaID = DB::table('restoareas')->insertGetId([
                'name' => $restoarea['name'],
                'company_id' => $id,
            ]);

            for ($i = 0; $i < $restoarea['count']; $i++) {
                DB::table('tables')->insertGetId([
                    'name' => 'Table '.($i + 1),
                    'company_id' => $id,
                    'restoarea_id' => $lastAreaID,
                    'x' => $restoarea['plan'][$i]['x'],
                    'y' => $restoarea['plan'][$i]['y'],
                    'w' => $restoarea['plan'][$i]['w'],
                    'h' => $restoarea['plan'][$i]['h'],
                    'rounded' => $restoarea['plan'][$i]['rounded'],
                ]);
            }
        }
        $planInside = [
                    [
                        'x' => 90.14,
                        'y' => 59.02,
                        'w' => 120.0,
                        'h' => 87.0,
                        'rounded' => 'no',
                    ],
                    [
                        'x' => 87.65,
                        'y' => 173.37,
                        'w' => 120.0,
                        'h' => 87.0,
                        'rounded' => 'no',
                    ],
                    [
                        'x' => 86.12,
                        'y' => 285.06,
                        'w' => 120.0,
                        'h' => 87.0,
                        'rounded' => 'no',
                    ],
                    [
                        'x' => 82.89,
                        'y' => 401.49,
                        'w' => 121.19,
                        'h' => 87.0,
                        'rounded' => 'no',
                    ],
                    [
                        'x' => 317.66,
                        'y' => 191.56,
                        'w' => 193.5,
                        'h' => 156.62,
                        'rounded' => 'yes',
                    ],
                    [
                        'x' => 600.66,
                        'y' => 295.35,
                        'w' => 120.0,
                        'h' => 120.0,
                        'rounded' => 'yes',
                    ],
                    [
                        'x' => 595.45,
                        'y' => 141.78,
                        'w' => 120.0,
                        'h' => 120.0,
                        'rounded' => 'yes',
                    ],
                    [
                        'x' => 874.8,
                        'y' => 45.66,
                        'w' => 120.0,
                        'h' => 87.0,
                        'rounded' => 'no',
                    ],
                    [
                        'x' => 874.59,
                        'y' => 177.19,
                        'w' => 120.0,
                        'h' => 191.45,
                        'rounded' => 'no',
                    ],
                    [
                        'x' => 871.71,
                        'y' => 418.7,
                        'w' => 120.0,
                        'h' => 87.0,
                        'rounded' => 'no',
                    ],
                ];

                $planTerrase = [
                    [
                        'x' => 487.37,
                        'y' => 284.18,
                        'w' => 246.98,
                        'h' => 87.0,
                        'rounded' => 'no',
                    ],
                    [
                        'x' => 222.27,
                        'y' => 285.05,
                        'w' => 242.19,
                        'h' => 87.0,
                        'rounded' => 'no',
                    ],
                    [
                        'x' => 223.63,
                        'y' => 86.4,
                        'w' => 120.0,
                        'h' => 120.0,
                        'rounded' => 'yes',
                    ],
                    [
                        'x' => 420.13,
                        'y' => 88.23,
                        'w' => 120.0,
                        'h' => 120.0,
                        'rounded' => 'yes',
                    ],
                    [
                        'x' => 614.11,
                        'y' => 90.74,
                        'w' => 120.0,
                        'h' => 120.0,
                        'rounded' => 'yes',
                    ],
                ];




        Model::reguard();
    }
}
