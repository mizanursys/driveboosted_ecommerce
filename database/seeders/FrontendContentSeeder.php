<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FrontendContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Site Settings
        \App\Models\SiteSetting::truncate();
        \App\Models\SiteSetting::create([
            'announcement_text' => 'WORLDWIDE SHIPPING • PREMIUM AUTOMOTIVE PERFORMANCE • EST. 2026',
            'marquee_text' => 'WINTER CLEARANCE SALE: SAVE UP TO 15%',
            'footer_description' => 'Elite automotive care and precision surface engineering. We redefine automotive aesthetics through scientific protocols and artisanal dedication.',
            'social_facebook' => '#',
            'social_instagram' => '#',
            'social_youtube' => '#',
            'social_tiktok' => '#',
            'showcase_image' => 'https://images.unsplash.com/photo-1619642751034-765dfdf7c58e?auto=format&fit=crop&q=80&w=2000',
            'showcase_title' => 'ENGINEERED PRECISION_',
            'showcase_description' => "Drive Boosted operates at the intersection of high-performance chemical engineering and artisanal automotive care. We don't just detail; we preserve, protect, and perfect every micron of your vehicle's surface.",
            'showcase_btn_text' => 'OUR MISSION',
            'showcase_btn_link' => '#story',
            'stats_1_value' => '5K+', 'stats_1_label' => 'Cars Perfected',
            'stats_2_value' => '9H', 'stats_2_label' => 'Standard Hardness',
            'stats_3_value' => '10Y+', 'stats_3_label' => 'Protection Life',
            'stats_4_value' => '100%', 'stats_4_label' => 'Artisanal Finish',
        ]);

        // 2. Hero Slides
        \App\Models\HeroSlide::truncate();
        
        \App\Models\HeroSlide::create([
            'image' => 'https://images.unsplash.com/photo-1621370211603-9bb64be084cd?auto=format&fit=crop&q=80&w=2000',
            'subtitle' => 'PROTOCOL_01 / RESTORATION',
            'title' => 'BEYOND GLOSS.',
            'description' => 'Precision surface engineering for the elite automotive enthusiast. We restore what time has taken.',
            'button_text' => 'EXPLORE GEAR',
            'button_link' => '/catalog',
            'order' => 1,
            'is_active' => true,
        ]);

        \App\Models\HeroSlide::create([
            'image' => 'https://images.unsplash.com/photo-1616763355548-1b606f439f86?auto=format&fit=crop&q=80&w=2000',
            'subtitle' => '02 / PERMANENT ARMOR',
            'title' => 'CERAMIC GUARD.',
            'description' => 'Scientific covalent bonding providing hydrophobic depth that lasts for years. Unmatched protection.',
            'button_text' => 'CERAMIC SERIES',
            'button_link' => '/catalog?category=ceramic',
            'order' => 2,
            'is_active' => true,
        ]);
    }
}
