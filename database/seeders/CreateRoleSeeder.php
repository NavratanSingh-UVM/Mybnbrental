<?php

namespace Database\Seeders;

use App\Models\CancellationSlabFees;
use App\Models\CancellentionPolicy;
use App\Models\CancellentionReason;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class CreateRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role=Role::create([
            'name'=>'Owner',
        ]);
        $role=Role::create([
            'name'=>'Traveller',
        ]);

        CancellentionPolicy::create([
            'name'=>'48 Hour Policy',
            'description'=>"All travelers who cancel their reservation within 48 hours of booking will get back 100% of the amount they've paid. ",
            'note'=>"Travelers must cancel by 11:59pm on the cut-off day before check-in to receive a refund. All times are specific to your property's time zone"
        ]);
        CancellentionPolicy::create([
            'name'=>'Relaxed Policy',
            'description'=>"All travelers who cancel at least 14 days before their check-in date will get back 100% of the amount they've paid. If they cancel having 13 days before check-in will not get a refund",
            'note'=>"Travelers must cancel by 11:59pm on the cut-off day before check-in to receive a refund. All times are specific to your property's time zone"
        ]);
        CancellentionPolicy::create([
            'name'=>'Moderate Policy',
            'description'=>"All travelers who cancel at least 30 days before check-in will get back 100% of the amount they've paid. If the reservation is cancelled between 14 and 30 days before check-in, they'll get back 50%. Otherwise, the traveller will not get a refund.",
            'note'=>"Travelers must cancel by 11:59pm on the cut-off day before check-in to receive a refund. All times are specific to your property's time zone"
        ]);
        CancellentionPolicy::create([
            'name'=>'Firm Policy',
            'description'=>": All travelers who cancel at least 60 days before their check-in date will get back 100% of the amount they've paid. If they cancel between 30 and 60 days before check-in, they'll get back 50% refund, Otherwise, they won't get a refund.",
            'note'=>"Travelers must cancel by 11:59pm on the cut-off day before check-in to receive a refund. All times are specific to your property's time zone"
        ]);
        CancellentionPolicy::create([
            'name'=>'Strict Policy',
            'description'=>"All travelers who cancel at least 60 days before their check-in date will get back 100% of the amount they've paid. If the traveller cancels after that point, they will not get a refund. ",
            'note'=>"Travelers must cancel by 11:59pm on the cut-off day before check-in to receive a refund. All times are specific to your property's time zone"
        ]);
        CancellentionPolicy::create([
            'name'=>'No Refund Policy',
            'description'=>"All travelers who cancel any time after the booking is confirmed will not get a refund.  ",
            'note'=>"Travelers must cancel by 11:59pm on the cut-off day before check-in to receive a refund. All times are specific to your property's time zone"
        ]);

        CancellationSlabFees::create([
            'cancelletion_polices_id'=>'1',
            'days_period'=>'48 Hours',
            'rates_in_percent'=>"100",
        ]);
        CancellationSlabFees::create([
            'cancelletion_polices_id'=>'2',
            'days_period'=>'14 days',
            'rates_in_percent'=>"100",
        ]);
        CancellationSlabFees::create([
            'cancelletion_polices_id'=>'3',
            'days_period'=>'30 days',
            'rates_in_percent'=>"100",
        ]);
        CancellationSlabFees::create([
            'cancelletion_polices_id'=>'3',
            'days_period'=>'14-30 days',
            'rates_in_percent'=>"50",
        ]);
        CancellationSlabFees::create([
            'cancelletion_polices_id'=>'4',
            'days_period'=>'60 days',
            'rates_in_percent'=>"100",
        ]);
        CancellationSlabFees::create([
            'cancelletion_polices_id'=>'4',
            'days_period'=>'30-60 days',
            'rates_in_percent'=>"50",
        ]);
        CancellationSlabFees::create([
            'cancelletion_polices_id'=>'5',
            'days_period'=>'60 days',
            'rates_in_percent'=>"100",
        ]);

        CancellentionReason::create([
            'name'=>'Change in Plans',
        ]);
        CancellentionReason::create([
            'name'=>'Unexpected schedule changes',
        ]);
        CancellentionReason::create([
            'name'=>'Personal reasons',
        ]);
        CancellentionReason::create([
            'name'=>'Health Issues',
        ]);
        CancellentionReason::create([
            'name'=>'Medical emergency',
        ]);
        CancellentionReason::create([
            'name'=>'Illness or injury',
        ]);
        CancellentionReason::create([
            'name'=>'Travel Restrictions',
        ]);
        CancellentionReason::create([
            'name'=>'Government-imposed restrictions',
        ]);
        CancellentionReason::create([
            'name'=>'Border closures',
        ]);
        CancellentionReason::create([
            'name'=>'Work Commitments',
        ]);
        CancellentionReason::create([
            'name'=>'Unexpected work-related obligations',
        ]);
        CancellentionReason::create([
            'name'=>'Last-minute business trips',
        ]);
        CancellentionReason::create([
            'name'=>'Financial Constraints',
        ]);
        CancellentionReason::create([
            'name'=>'Unforeseen financial difficulties',
        ]);
        CancellentionReason::create([
            'name'=>'Job loss',
        ]);
        CancellentionReason::create([
            'name'=>'Family Emergency',
        ]);
        CancellentionReason::create([
            'name'=>'Death or serious illness in the family',
        ]);
        CancellentionReason::create([
            'name'=>'Other family emergencies',
        ]);
        CancellentionReason::create([
            'name'=>'Weather or Natural Disasters',
        ]);
        CancellentionReason::create([
            'name'=>'Severe weather conditions',
        ]);
        CancellentionReason::create([
            'name'=>'Natural disasters affecting travel plans',
        ]);
        CancellentionReason::create([
            'name'=>'Accommodation Issues',
        ]);
        CancellentionReason::create([
            'name'=>'Problems with the rental property',
        ]);
        CancellentionReason::create([
            'name'=>'Unexpected maintenance or construction',
        ]);
        CancellentionReason::create([
            'name'=>'Transportation Issues',
        ]);
        CancellentionReason::create([
            'name'=>'Flight cancellations or delays',
        ]);
        CancellentionReason::create([
            'name'=>'Car rental problems',
        ]);
        CancellentionReason::create([
            'name'=>'Unexpected Events',
        ]);
        CancellentionReason::create([
            'name'=>'Other',
        ]);
    }
}
