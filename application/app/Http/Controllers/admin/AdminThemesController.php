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
use App\Models\Setting;


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
			'active_theme' => Setting::first()->theme
			);
		return View::make('admin.themes.index', $data);
	}

	public function activate($slug)
	{
		$settings = Setting::first();
		$settings->theme = $slug;
		$settings->save();
		return Redirect::to('admin/themes')->with(array('note' => _i('Successfully Activated') . ' ' . ucfirst($slug), 'note_type' => 'success'));
	}

}