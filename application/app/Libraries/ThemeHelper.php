<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<?php
namespace App\Libraries;

use App\Models\ThemeSetting;
use Illuminate\Support\Facades\Log;

class ThemeHelper {

    /**
     * predefined system settings
     */

    private static $_system_settings = [
        'website_name' => 'VMS',
        'website_description' => 'Your Premium Video CMS',
        'logo' => 'logo.png',
        'favicon' => 'favicon.png',
        'system_email' => '',
        'demo_mode' => 0,
        'enable_https' => 0,
        'theme' => 'default',
        'facebook_page_id' => '',
        'google_page_id' => '',
        'twitter_page_id' => '',
        'youtube_page_id' => '',
        'google_tracking_id' => '',
        'google_tag_id' => '',
        'google_oauth_key' => '',
        'google_secret_key'  => '',
        'google_api_key' => '',
        'videos_per_page' => 12,
        'posts_per_page' => 12,
        'free_registration' => 1,
        'activation_email' => 0,
        'premium_upgrade' => 1,
        'locale' => 'en_EN',
        'enable_video_comments' => 1,
        'enable_post_comments' => 1,
        'enable_anonymous_comments' => 1,
        'enable_google_captcha_comments' => 0,
        'video_comments_per_page' => 10,
        'post_comments_per_page' => 10,
        'instagram_page_id' => '',
        'vimeo_page_id' => '',
        'webmasters_google', 'webmasters_bing', 'webmasters_alexa', 'webmasters_yandex',
        'mail_host', 'mail_port', 'mail_username', 'mail_password'

    ];

	public static function getThemeSettings() {

		// Get the Active Theme and the Theme Settings
		$active_theme = ThemeHelper::getSystemSettings()->theme;
		$theme_settings = ThemeSetting::where('theme_slug', '=', $active_theme)->get();

		// Create an empty array to fill with theme settings
		$key_values = array();

		// loop through each key value and put into array accordingly
		foreach($theme_settings as $setting){
			$key_values[$setting->key] = $setting->value;
		}

		return (object) $key_values;
	}

	public static function getThemeSetting($setting, $default){
		if(isset($setting) && !empty($setting)){
			return $setting;
		} else {
			return $default;
		}
	}

	public static function get_themes() {
		$themes = array();
		$theme_folder = 'content/themes';
		$themes_dir = @ opendir( $theme_folder);
		if ( $themes_dir ) {
			while (($folder = readdir( $themes_dir ) ) !== false ) {
				if( @is_readable("$theme_folder/$folder/home.php") && is_readable("$theme_folder/$folder/config.json") ){
					$theme_config = file_get_contents("$theme_folder/$folder/config.json");
					$theme_config = json_decode($theme_config, true);
					$theme_config['slug'] = $folder;
					array_push($themes, (object) $theme_config);
				}
			}
			closedir( $themes_dir );
		}
		return (object) $themes;
	}

	public static function get_theme_config($slug){
        Log::debug('theme folder: ' . THEME_DIR);
		if( @is_readable(THEME_DIR . "/home.php") && is_readable(THEME_DIR . "/config.json") ){
			$theme_config = file_get_contents(THEME_DIR . "/config.json");
			$theme_config = json_decode($theme_config, true);
			$theme_config['slug'] = $slug;
            return $theme_config;
		}
        return false;
	}

    public static function createOrUpdateThemeSetting($theme_slug, $key, $value){

        $theme_setting = ThemeSetting::where('theme_slug', '=', $theme_slug)->where('key', '=', $key)->first();

        if(!is_string($value)) {
            if(is_array($value)) {
                $value = (object)$value;
            }
            if($theme_setting) {
                $current_theme_setting = json_decode($theme_setting->value);
                $current_theme = isset($current_theme_setting->theme)?$current_theme_setting->theme:'';
            }
            if((!isset($value->theme) || $value->theme == '') && $current_theme != '') {
                $value->theme = $current_theme;
            }
            $value = json_encode($value);
        }


        $setting = array(
            'theme_slug' => $theme_slug,
            'key' => $key,
            'value' => $value
        );



        if (isset($theme_setting->id))
        {
            $theme_setting->update($setting);
            $theme_setting->save();
        }
        else
        {
            ThemeSetting::create($setting);
        }
    }

    public static function getSystemSettings() {
        $system_settings = ThemeSetting::where('theme_slug', 'system')->where('key', 'settings')->first();
        if($system_settings && isset($system_settings->value)) {
            $system_settings = json_decode($system_settings->value);
        }
        else {
            $system_settings = (object) self::$_system_settings;
        }
        if (!isset($system_settings->theme) || $system_settings->theme == '') {
            $system_settings->theme = 'default';
        }
        return $system_settings;


	}

}