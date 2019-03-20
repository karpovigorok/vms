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

use \App\User as User;
use Carbon\Carbon as Carbon;
use \App\Models\Video;
use \App\Models\Post;
use \App\Models\Setting;
use Illuminate\Http\Request;
//use App\Http\Controllers\AdminBaseController as AdminBaseController;

class AdminController extends \AdminBaseController {

	/**
	 * Setup the layout used by the controller.
	 *
	 * @return void
	 */

	public function index(Request $request)
	{
		$start = (new Carbon('now'))->hour(0)->minute(0)->second(0);
		$end = (new Carbon('now'))->hour(23)->minute(59)->second(59);

		$total_subscribers = count(User::where('active', '=', 1)->where('role', '=', 'subscriber')->where('stripe_active', '=', 1)->get());
		$new_subscribers = count(User::where('active', '=', 1)->where('role', '=', 'subscriber')->where('stripe_active', '=', 1)->whereBetween('created_at', [$start, $end])->get());
		$total_videos = count(Video::where('active', '=', 1)->get());
		$total_posts = count(Post::where('active', '=', 1)->get());

		$settings = Setting::first();


		$data = array(
			'admin_user' => Auth::user(),
			'total_subscribers' => $total_subscribers,
			'new_subscribers' => $new_subscribers,
			'total_videos' => $total_videos,
			'total_posts' => $total_posts,
			'settings' => $settings
			);
		return View::make('admin.index', $data);
	}


	public function settings_form(){
		$settings = Setting::first();
		$user = Auth::user();
		$data = array(
			'settings' => $settings,
			'admin_user'	=> $user,
			);
		return View::make('admin.settings.index', $data);
	}

}