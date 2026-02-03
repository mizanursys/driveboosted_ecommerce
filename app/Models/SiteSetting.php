<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteSetting extends Model
{
    protected $fillable = [
        'announcement_text', 'marquee_text', 'footer_description',
        'social_facebook', 'social_instagram', 'social_youtube', 'social_tiktok',
        'contact_phone', 'contact_email',
        'showcase_image', 'showcase_title', 'showcase_description', 'showcase_btn_text', 'showcase_btn_link',
        'stats_1_value', 'stats_1_label',
        'stats_2_value', 'stats_2_label',
        'stats_3_value', 'stats_3_label',
        'stats_4_value', 'stats_4_label',
    ];
}
