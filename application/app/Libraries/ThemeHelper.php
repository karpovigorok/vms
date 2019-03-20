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
namespace App\Libraries;

use App\Models\Setting;
use App\Models\ThemeSetting;
use Illuminate\Support\Facades\Log;

class ThemeHelper {

	public static function getThemeSettings() {

		// Get the Active Theme and the Theme Settings
		$active_theme = Setting::first()->theme;
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

}