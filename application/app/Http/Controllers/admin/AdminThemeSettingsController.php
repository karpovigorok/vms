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

use \Redirect as Redirect;
use Illuminate\Http\Request;
use App\Models\Setting;
use App\Models\ThemeSetting;
use App\Libraries\ThemeHelper;
use Illuminate\Support\Facades\File;
//use App\Models\Setting;;

class AdminThemeSettingsController extends \AdminBaseController {

	public function theme_settings(){
		$settings = Setting::first();
		$user = Auth::user();
		$data = array(
			'settings' => $settings,
			'admin_user'	=> $user,
			);
		return View::make('admin.settings.theme_settings', $data);
	}

	public function theme_settings_form(){
		$settings = Setting::first();
		$user = Auth::user();

        //dd(THEME_DIR);
        $home_files = File::files(THEME_DIR);
        $homepage_templates = [];
        if(sizeof($home_files)) {
            foreach($home_files as $home_file) {
                if(substr($home_file->getFileName(), 0, 4) == 'home') {
                    $homepage_templates[$home_file->getBasename('.php')] = $home_file->getBasename();
                }
            }
        }

		$data = array(
			'settings' => $settings,
			'admin_user'	=> $user,
			'theme_settings' => ThemeHelper::getThemeSettings(),
            'homepage_templates' => $homepage_templates,
			);
		return View::make('Theme::includes.settings', $data);
	}

	public function update_theme_settings(){
		// Get the Active Theme
		$active_theme = Setting::first()->theme;

		$input = Input::all();
        if(isset($input['_token'])) {
            unset($input['_token']);
        }
        if(isset($input['homepage_file']) && substr($input['homepage_file'], 0, 4) !== 'home') {
            unset($input['homepage_file']);
        }
		foreach($input as $key => $value){
			$this->createOrUpdateThemeSetting($active_theme, $key, trim($value));
		}

		return Redirect::to('/admin/theme_settings');
	}

	private function createOrUpdateThemeSetting($theme_slug, $key, $value){
       	
       	$setting = array(
        		'theme_slug' => $theme_slug,
        		'key' => $key,
        		'value' => $value
        	);

       	$theme_setting = ThemeSetting::where('theme_slug', '=', $theme_slug)->where('key', '=', $key)->first();

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

    public function delete_logo(Request $request) {
        if($request->ajax()) {
            $settings = Setting::first();
            $settings->logo = '';
            $settings->save();
        }
        else {
            abort(403);
        }
    }

    public function delete_favicon(Request $request) {
        if($request->ajax()) {
            $settings = Setting::first();
            $settings->favicon = '';
            $settings->save();
        }
        else {
            abort(403);
        }
    }

 }