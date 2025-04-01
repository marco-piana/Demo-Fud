<?php

namespace Modules\Tablereservations\Database\Seeds;

use App\Models\Company;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;

class LandingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();


        $features = [
            [
                'type' => 'feature',
                'title' => '{"en":"Powerful and easy to use"}',
                'subtitle' => '{"en":"Say goodbye to chaotic papers and spreadsheets. Keep your bookings organized and streamline your planning by viewing all your reservations in one centralized dashboard.."}',
                'description'=>'{"en":"Centralized booking management,Avoid overbooking,Flexible reservation handling,Cross-device accessibility"}',
                'image' => 'https://mobidonia-demo.imgix.net/img/reservation_pop_10.png'
            ],
            [
                'type' => 'feature',
                'title' => '{"en":"AI Voice  Agents "}',
                'subtitle' => '{"en":"The next generation of restaurant reservations. 24/7 AI Phone Agent that can handle all your restaurant reservations. Never miss a booking, even during peak hour or when you are closed."}',
                'description'=>'{"en":"24/7 reservation availability,Multilingual support,Real-time system integration,Improved booking accuracy"}',
                'image' => 'https://mobidonia-demo.imgix.net/img/ai_phone_reservations_10.png'
            ],
            [
                'type' => 'feature',
                'title' => '{"en":"Keep guests informed"}',
                'subtitle' => '{"en":"Save time, reduce no-shows and build loyalty with timely, automated communication via email and WhatsApp that keeps guests in the loop. Everything automated, no manual work needed."}',
                'description'=>'{"en":"Automated reminders,Customizable templates,Reduce no-shows,Instant confirmations"}',
                'image' => 'https://mobidonia-demo.imgix.net/img/phone_notify_10.png'
            ],
            [
                'type' => 'feature',
                'title' => '{"en":"Website booking widget"}',
                'subtitle' => '{"en":"Provide a seamless booking experience by embedding our responsive booking widget into your restaurant website."}',
                'description'=>'{"en":"Easy embedding,Increase direct bookings,Customizable design,Mobile-responsive,Real-time availability"}',
                'image' => 'https://mobidonia-demo.imgix.net/img/web_widget_10.png'
            ],
            [
                'type' => 'feature',
                'title' => '{"en":"Table Management"}',
                'subtitle' => '{"en":"Efficiently manage your restaurant\'s floor plan with our intuitive table management system. Easily assign, move, and combine tables to accommodate various party sizes and optimize your seating capacity."}',
                'description'=>'{"en":"Interactive floor plan,Drag-and-drop functionality,Table status tracking,Capacity optimization"}',
                'image' => 'https://mobidonia-demo.imgix.net/img/floor_plan_10.png'
            ],
            [
                'type' => 'feature',
                'title' => '{"en":"Analytics and Reporting"}',
                'subtitle' => '{"en":"Gain valuable insights into your restaurant\'s performance with our comprehensive analytics and reporting tools. Track reservation trends and peak hours to make data-driven decisions."}',
                'description'=>'{"en":"Customizable reports,Reservation trends analysis,Customer behavior insights,Performance metrics"}',
                'image' => 'https://mobidonia-demo.imgix.net/img/statistics_10.png'
            ],
        ];
        
        $faq = [
            [
                'type' => 'faq',
                'title' => '{"en":"How does the online table booking system work?"}',
                'description' => '{"en":"Our online table booking system allows your customers to easily reserve tables through your restaurant\'s website or app. They can select the date, time, and party size, and the system will show available slots. You\'ll receive real-time notifications for new bookings and can manage them through an intuitive dashboard."}'
            ],
            [
                'type' => 'faq',
                'title' => '{"en":"Can I customize the booking widget to match my restaurant\'s branding?"}',
                'description' => '{"en":"Absolutely! Our booking widget is fully customizable. You can adjust colors, fonts, and styles to match your restaurant\'s branding. This ensures a seamless experience for your customers and maintains your unique identity."}'
            ],
            [
                'type' => 'faq',
                'title' => '{"en":"How does the system handle peak hours and special events?"}',
                'description' => '{"en":"Our system allows you to set different availability for peak hours, weekends, and special events. You can easily adjust the number of available tables, set minimum party sizes, or even close bookings for private events. This flexibility ensures you maintain control over your restaurant\'s capacity at all times."}'
            ],
            [
                'type' => 'faq',
                'title' => '{"en":"Is there a way to manage walk-ins alongside online reservations?"}',
                'description' => '{"en":"Yes, our system provides a comprehensive view of all your reservations, including walk-ins. You can easily add walk-in customers to the system, ensuring you have an accurate overview of your restaurant\'s occupancy at any given time."}'
            ],
            [
                'type' => 'faq',
                'title' => '{"en":"Can the system integrate with my existing POS or restaurant management software?"}',
                'description' => '{"en":"Our table booking system is designed to integrate with a wide range of POS and restaurant management software. We offer APIs and plugins for many popular systems, allowing for seamless data flow between your booking system and other tools you use to run your restaurant."}'
            ]
        ];
        // You can now use the $faqs array in your PHP application to display the frequently asked questions.
        

        $testimonials = [
            [
                'type' => 'testimonial',
                'title' => '{"en":"John Doe"}',
                'subtitle' => '{"en":"Owner, Bistro Bliss"}',
                'description' => '{"en":"This system transformed our reservations. It\'s user-friendly, intuitive, and the support is incredibly responsive. A game-changer for our busy restaurant!"}',
                'image'=>'https://mobidonia-demo.imgix.net/img/testimonials/maletestimonials/1.png?w=100&h=100',
                'review'=>"male"
            ],
            [
                'type' => 'testimonial',
                'title' => '{"en":"Jane Smith"}',
                'subtitle' => '{"en":"Manager, Gourmet"}',
                'description' => '{"en":"A game-changer for our restaurant. Highly effective, customizable, and significantly improved our efficiency and customer satisfaction!"}',
                'image'=>'https://mobidonia-demo.imgix.net/img/testimonials/femaletestimonials/1.png?w=100&h=100',
                'review'=>"female"
            ],
            [
                'type' => 'testimonial',
                'title' => '{"en":"David Williams"}',
                'subtitle' => '{"en":"Owner, Sunset Cafe"}',
                'description' => '{"en":"Managing reservations is now effortless. Outstanding results, improved operations. The platform\'s simplicity and support are invaluable."}',
                'image'=>'https://mobidonia-demo.imgix.net/img/testimonials/maletestimonials/2.png?w=100&h=100',
                'review'=>"male"
            ],
            [
                'type' => 'testimonial',
                'title' => '{"en":"Susan Brown"}',
                'subtitle' => '{"en":"GM, Fusion Flavors"}',
                'description' => '{"en":"A must-have for restaurants. Streamlined booking, helpful analytics. Intuitive platform with top-notch support. Couldn\'t be happier!"}',
                'image'=>'https://mobidonia-demo.imgix.net/img/testimonials/femaletestimonials/2.png?w=100&h=100',
                'review'=>"female"
            ],
            [
                'type' => 'testimonial',
                'title' => '{"en":"Alex Johnson"}',
                'subtitle' => '{"en":"Bar Manager, Tipsy"}',
                'description' => '{"en":"Exceptional customer support. Always ready to assist. Greatly improved our bar\'s reservation handling. Highly recommend!"}',
                'image'=>'https://mobidonia-demo.imgix.net/img/testimonials/maletestimonials/3.png?w=100&h=100',
                'review'=>"male"
            ],
            [
                'type' => 'testimonial',
                'title' => '{"en":"Emily Davis"}',
                'subtitle' => '{"en":"Owner, Seaside"}',
                'description' => '{"en":"Significantly improved operations. Waitlist feature eases walk-in management. Customers love online booking. Fantastic for any restaurant!"}',
                'image'=>'https://mobidonia-demo.imgix.net/img/testimonials/femaletestimonials/3.png?w=100&h=100',
                'review'=>"female"
            ],
            [
                'type' => 'testimonial',
                'title' => '{"en":"Michael Miller"}',
                'subtitle' => '{"en":"Chef, Culinary"}',
                'description' => '{"en":"Excellent tool. Easy to use, efficient reservation management. Customizable table layouts are particularly helpful for our unique space."}',
                'image'=>'https://mobidonia-demo.imgix.net/img/testimonials/maletestimonials/4.png?w=100&h=100',
                'review'=>"male"
            ],
            [
                'type' => 'testimonial',
                'title' => '{"en":"Sarah Thompson"}',
                'subtitle' => '{"en":"Owner, Cozy Diner"}',
                'description' => '{"en":"Incredible results for our diner. Automated features reduced no-shows. Easy to use with great support. Highly recommend!"}',
                'image'=>'https://mobidonia-demo.imgix.net/img/testimonials/femaletestimonials/4.png?w=100&h=100',
                'review'=>"female"
            ],
            [
                'type' => 'testimonial',
                'title' => '{"en":"Robert Anderson"}',
                'subtitle' => '{"en":"Manager, Skyline"}',
                'description' => '{"en":"Boosted customer experience. Easy website integration for reservations. Floor plan management optimizes space. Significant business impact!"}',
                'image'=>'https://mobidonia-demo.imgix.net/img/testimonials/maletestimonials/5.png?w=100&h=100',
                'review'=>"male"
            ],
            [
                'type' => 'testimonial',
                'title' => '{"en":"Jennifer Lee"}',
                'subtitle' => '{"en":"Owner, Asian Fusion"}',
                'description' => '{"en":"This reservation system transformed our busy restaurant. Efficient table management and reduced wait times. Customers love the easy online booking!"}',
                'image'=>'https://mobidonia-demo.imgix.net/img/testimonials/femaletestimonials/5.png?w=100&h=100',
                'review'=>"female"
            ],
            [
                'type' => 'testimonial',
                'title' => '{"en":"Daniel Martinez"}',
                'subtitle' => '{"en":"Manager, Tapas Bar"}',
                'description' => '{"en":"Incredible tool for our tapas bar. Simplified group bookings and special events. The analytics help us make informed decisions. Highly recommend!"}',
                'image'=>'https://mobidonia-demo.imgix.net/img/testimonials/maletestimonials/6.png?w=100&h=100',
                'review'=>"male"
            ],
            [
                'type' => 'testimonial',
                'title' => '{"en":"Rachel Kim"}',
                'subtitle' => '{"en":"Owner, Sushi Express"}',
                'description' => '{"en":"Game-changer for our sushi restaurant. Streamlined reservations, reduced no-shows, and improved table turnover. The customer support is outstanding!"}',
                'image'=>'https://mobidonia-demo.imgix.net/img/testimonials/femaletestimonials/6.png?w=100&h=100',
                'review'=>"female"
            ],
            [
                'type' => 'testimonial',
                'title' => '{"en":"Thomas Wilson"}',
                'subtitle' => '{"en":"GM, Steakhouse Prime"}',
                'description' => '{"en":"This system elevated our steakhouse operations. The customizable features fit our unique needs perfectly. Saw a significant increase in online bookings."}',
                'image'=>'https://mobidonia-demo.imgix.net/img/testimonials/maletestimonials/7.png?w=100&h=100',
                'review'=>"male"
            ],
            [
                'type' => 'testimonial',
                'title' => '{"en":"Olivia Chen"}',
                'subtitle' => '{"en":"Owner, Vegan Delights"}',
                'description' => '{"en":"Perfect for our vegan restaurant. Easy to manage dietary preferences and special requests. The waitlist feature is a lifesaver during peak hours!"}',
                'image'=>'https://mobidonia-demo.imgix.net/img/testimonials/femaletestimonials/7.png?w=100&h=100',
                'review'=>"female"
            ],
            [
                'type' => 'testimonial',
                'title' => '{"en":"Emily Davis"}',
                'subtitle' => '{"en":"Owner, Seaside"}',
                'description' => '{"en":"Significantly improved operations. Waitlist feature eases walk-in management. Customers love online booking. Fantastic for any restaurant!"}',
                'image'=>'https://mobidonia-demo.imgix.net/img/testimonials/femaletestimonials/7.png?w=100&h=100',
                'review'=>"female"
            ],
            [
                'type' => 'testimonial',
                'title' => '{"en":"Emily Davis"}',
                'subtitle' => '{"en":"Owner, Seaside"}',
                'description' => '{"en":"Significantly improved operations. Waitlist feature eases walk-in management. Customers love online booking. Fantastic for any restaurant!"}',
                'image'=>'https://mobidonia-demo.imgix.net/img/testimonials/maletestimonials/8.png?w=100&h=100',
                'review'=>"male"
            ]
        ];
        
        // You can now use the $testimonials array in your PHP application as needed.
        


    
        
        

        $content = array_merge($faq, $testimonials,$features);
        
        

        foreach ($content as $key => $element) {
            
            DB::table('posts')->insert([
                'post_type' => $element['type'],
                'title' => $element['title'],
                'image' => isset($element['image'])?$element['image']:null,
                'description' => $element['description'],
                'link'=>isset($element['link'])?$element['link']:null,
                'subtitle' => isset($element['subtitle'])?$element['subtitle']:null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        Model::reguard();
    }
}
