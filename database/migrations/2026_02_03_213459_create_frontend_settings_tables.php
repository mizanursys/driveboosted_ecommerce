<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            // Header & Footer
            $table->string('announcement_text')->nullable();
            $table->text('marquee_text')->nullable();
            $table->text('footer_description')->nullable();
            
            // Social Links
            $table->string('social_facebook')->nullable();
            $table->string('social_instagram')->nullable();
            $table->string('social_youtube')->nullable();
            $table->string('social_tiktok')->nullable();
            
            // Contact
            $table->string('contact_phone')->nullable();
            $table->string('contact_email')->nullable();
            
            // Homepage Showcase
            $table->string('showcase_image')->nullable();
            $table->string('showcase_title')->nullable();
            $table->text('showcase_description')->nullable();
            $table->string('showcase_btn_text')->nullable();
            $table->string('showcase_btn_link')->nullable();

            // Stats (Grouped for simplicity)
            $table->string('stats_1_value')->nullable();
            $table->string('stats_1_label')->nullable();
            $table->string('stats_2_value')->nullable();
            $table->string('stats_2_label')->nullable();
            $table->string('stats_3_value')->nullable();
            $table->string('stats_3_label')->nullable();
            $table->string('stats_4_value')->nullable();
            $table->string('stats_4_label')->nullable();

            $table->timestamps();
        });

        Schema::create('hero_slides', function (Blueprint $table) {
            $table->id();
            $table->string('image');
            $table->string('subtitle')->nullable();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('button_text')->nullable();
            $table->string('button_link')->nullable();
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hero_slides');
        Schema::dropIfExists('site_settings');
    }
};
