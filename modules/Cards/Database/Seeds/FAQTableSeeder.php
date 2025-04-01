<?php

namespace Modules\Cards\Database\Seeds;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FAQTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $faqs = [
            ['title'=>'{"en":"What is a customer loyalty program?"}', 'description'=>'{"en":"A customer loyalty program is a marketing strategy designed to reward and retain loyal customers. It typically involves offering a rewards system or benefits to customers in exchange for their continued patronage. This can be done through a variety of means, such as offering points for purchases that can be redeemed for discounts or other perks, providing exclusive access to promotions or special events, or offering personalized experiences or services. The goal of a customer loyalty program is to encourage customers to continue doing business with a company, in the hope that this will lead to increased customer retention and long-term profitability."}'],
            ['title'=>'{"en":"Why do I need a customer loyalty program?"}', 'description'=>'{"en":"A customer loyalty program can be an effective way to retain and grow your customer base. Overall, a customer loyalty program can be an effective way to differentiate your business from competitors, improve customer satisfaction, and increase customer retention and lifetime value."}'],
            ['title'=>'{"en":"Do loyalty program members spend more?"}', 'description'=>'{"en":"It is often thought that loyalty program members tend to spend more than non-members, although the extent to which this is true can vary depending on the specific loyalty program and the behavior of individual customers. Some research has suggested that loyalty program members may be more likely to make larger purchases and to purchase more frequently, as they may be motivated by the potential rewards or benefits that they can earn through the program. Additionally, loyalty program members may be more loyal to the brand, which can lead to increased spending over time. However, it is important to note that the impact of a loyalty program on customer spending habits can vary widely, and may depend on factors such as the perceived value of the rewards or benefits offered, the clarity and fairness of the programs terms and conditions, and the overall customer experience. Therefore, it is important for companies to carefully consider the design and implementation of their loyalty programs in order to maximize their effectiveness in driving customer spending."}'],

        ];

        foreach ($faqs as $key => $faq) {
            DB::table('posts')->insert([
                'post_type' => 'faq',
                'title' => $faq['title'],
                'description' => $faq['description'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

         //Now make the FAQs per vendors
        $faqsVendors = [
            ['title'=>'{"en":"Where can i get my loyalty card?"}', 'description'=>'{"en":"You can get it at any of our stores."}'],
            ['title'=>'{"en":"How I can spend my loyalty points?"}', 'description'=>'{"en":"You can convert them into award/gift or convert them in a coupon code"}'],
            ['title'=>'{"en":"Where I can redeem the awards?"}', 'description'=>'{"en":"You can redeem them in any of our stores."}'],
            ['title'=>'{"en":"Can I transfer my points to other card"}', 'description'=>'{"en":"Unfortunately this action is not allowed"}'],
        ];
        for ($i=1; $i < 5; $i++) { 
            foreach ($faqsVendors as $key => $faqVendor) {
                DB::table('posts')->insert([
                    'post_type' => 'loyaltyfaq',
                    'vendor_id' => $i,
                    'title' => $faqVendor['title'],
                    'description' => $faqVendor['description'],
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

       


        Model::reguard();
    }
}
