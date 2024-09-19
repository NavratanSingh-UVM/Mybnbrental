<?php

namespace Database\Seeders;

use App\Models\BusinessCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BusinessCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BusinessCategory::create([
            'name'=>'Restraunts & Bar'
        ]);
        BusinessCategory::create([
            'name'=>'Car rental'
        ]);
        BusinessCategory::create([
            'name'=>'Gym'
        ]);
        BusinessCategory::create([
            'name'=>'Muesuem'
        ]);
        BusinessCategory::create([
            'name'=>'Golf'
        ]);
        BusinessCategory::create([
            'name'=>'Yacht Rental'
        ]);
        BusinessCategory::create([
            'name'=>'Boat Tour'
        ]);
        BusinessCategory::create([
            'name'=>'Beauty & Wellness'
        ]);
        BusinessCategory::create([
            'name'=>'Wedding & Events'
        ]);
        BusinessCategory::create([
            'name'=>'Apparels & Accessories'
        ]);
        BusinessCategory::create([
            'name'=>'Shopping'
        ]);
        BusinessCategory::create([
            'name'=>'Bike Rentals'
        ]);
        BusinessCategory::create([
            'name'=>'Local Shop'
        ]);
        BusinessCategory::create([
            'name'=>'Astrologer'
        ]);
        BusinessCategory::create([
            'name'=>'Bakery'
        ]);
        BusinessCategory::create([
            'name'=>'Cabs Services'
        ]);
        BusinessCategory::create([
            'name'=>'Health'
        ]);
        BusinessCategory::create([
            'name'=>'Spiritual Centres '
        ]);
        BusinessCategory::create([
            'name'=>'Church'
        ]);
        BusinessCategory::create([
            'name'=>'Yoga Centres'
        ]);
        BusinessCategory::create([
            'name'=>'Fishing'
        ]);
        BusinessCategory::create([
            'name'=>'Camping'
        ]);
        BusinessCategory::create([
            'name'=>'Travel Agency'
        ]);
        BusinessCategory::create([
            'name'=>'Spa'
        ]);
        BusinessCategory::create([
            'name'=>'Salon'
        ]);
        BusinessCategory::create([
            'name'=>'Clubs'
        ]);
    }
}
