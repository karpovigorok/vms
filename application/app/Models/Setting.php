<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.0
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov
    * @website https://noxls.net
    *
*/?>
<?php

namespace App\Models;

use Eloquent;

class Setting extends Eloquent
{
    protected $guarded = array();

    public static $rules = array();

    protected $fillable = array('website_name', 'website_description', 'logo', 'favicon', 'system_email', 'demo_mode',
        'enable_https', 'facebook_page_id', 'google_page_id', 'twitter_page_id', 'youtube_page_id', 'google_tracking_id',
        'google_tag_id', 'google_oauth_key', 'google_secret_key', 'google_api_key', 'videos_per_page', 'posts_per_page',
        'free_registration', 'activation_email', 'premium_upgrade', 'locale', 'enable_video_comments', 'enable_post_comments',
        'enable_anonymous_comments', 'enable_google_captcha_comments', 'video_comments_per_page', 'post_comments_per_page',
        'instagram_page_id', 'vimeo_page_id');
}