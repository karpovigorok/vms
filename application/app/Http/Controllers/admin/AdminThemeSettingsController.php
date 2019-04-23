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

use \Redirect as Redirect;
use Illuminate\Http\Request;
use App\Libraries\ThemeHelper;
use Illuminate\Support\Facades\File;

class AdminThemeSettingsController extends \AdminBaseController {

	public function theme_settings(){
		$settings = ThemeHelper::getSystemSettings();
		$user = Auth::user();
		$data = array(
			'settings' => $settings,
			'admin_user'	=> $user,
			);
		return View::make('admin.settings.theme_settings', $data);
	}

	public function theme_settings_form(){
		$settings = ThemeHelper::getSystemSettings();
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
		$active_theme = ThemeHelper::getSystemSettings()->theme;

		$input = Input::all();
        if(isset($input['_token'])) {
            unset($input['_token']);
        }
        if(isset($input['homepage_file']) && substr($input['homepage_file'], 0, 4) !== 'home') {
            unset($input['homepage_file']);
        }
		foreach($input as $key => $value){
            ThemeHelper::createOrUpdateThemeSetting($active_theme, $key, trim($value));
		}

		return Redirect::to('/admin/theme_settings');
	}

    public function delete_logo(Request $request) {
        if($request->ajax()) {
            $settings = ThemeHelper::getSystemSettings();
            $settings->logo = '';
            ThemeHelper::createOrUpdateThemeSetting('system', 'settings', $settings);
        }
        else {
            abort(403);
        }
    }

    public function delete_favicon(Request $request) {
        if($request->ajax()) {
            $settings = ThemeHelper::getSystemSettings();
            $settings->favicon = '';
            ThemeHelper::createOrUpdateThemeSetting('system', 'settings', $settings);
        }
        else {
            abort(403);
        }
    }

 }