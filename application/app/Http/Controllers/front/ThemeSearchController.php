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
use App\Models\Video;
use App\Models\Post;
use App\Models\Page;
use App\Models\VideoCategory;
use App\Models\PostCategory;
use App\Libraries\ThemeHelper;

class ThemeSearchController extends BaseController {

	public function __construct()
	{
		$this->middleware('secure');
        parent::__construct();
	}

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	*/

	public function index()
	{
		$search_value = Input::get('value');

		if(empty($search_value)){
			return Redirect::to('/');
		}
		$videos = Video::where('active', '=', 1)->where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->get();
		$posts = Post::where('active', '=', 1)->where('title', 'LIKE', '%'.$search_value.'%')->orderBy('created_at', 'desc')->get();

		$data = array(
			'videos' => $videos,
			'posts' => $posts,
			'search_value' => $search_value,
			'menu' => Menu::orderBy('order', 'ASC')->get(),
			'video_categories' => VideoCategory::all(),
			'post_categories' => PostCategory::all(),
			'theme_settings' => ThemeHelper::getThemeSettings(),
			'pages' => Page::where('active', '=', 1)->get(),
			);

		return View::make('Theme::search-list', $data);
	}

}