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
use App\Libraries\ThemeHelper;


class AdminThemesController extends \AdminBaseController {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */

	public function index()
	{
		$data = array(
			'admin_user' => Auth::user(),
			'themes' => \App\Libraries\ThemeHelper::get_themes(),
			'active_theme' => ThemeHelper::getSystemSettings()->theme
			);
		return View::make('admin.themes.index', $data);
	}

	public function activate($slug)
	{
		$settings = ThemeHelper::getSystemSettings();
		$settings->theme = $slug;
        ThemeHelper::createOrUpdateThemeSetting('system', 'settings', $settings);
		return Redirect::to('admin/themes')->with(array('note' => _i('Successfully Activated') . ' ' . ucfirst($slug), 'note_type' => 'success'));
	}

}