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

//namespace App\Http\Controllers\front;
use App\Models\Video;
use App\Models\VideoCategory;
use App\Models\PostCategory;
use App\Libraries\ThemeHelper;
use App\Models\Page;
use Arcanedev\SeoHelper\Entities\Webmasters;
use Arcanedev\SeoHelper\Entities\Title;
use Arcanedev\SeoHelper\Entities\Description;

class ThemeHomeController extends \BaseController {

    private $_num_recent_videos = 8;
    private $_num_popular_videos = 8;
    private $_num_featured_videos = 8;
    private $_settings;

	public function __construct()
	{
		$this->middleware('secure');
		$this->_settings = ThemeHelper::getSystemSettings();
        parent::__construct();
	}

	/*
	|--------------------------------------------------------------------------
	| Home Controller
	|--------------------------------------------------------------------------
	*/

	public function index()
	{
        $theme_settings = ThemeHelper::getThemeSettings();

        $excluded_video_ids = array();
		if(\Input::get('theme')){
			\Cookie::queue('theme', \Input::get('theme'), 100);
			return Redirect::to('/')->withCookie(cookie('theme', \Input::get('theme'), 100));
		}
        $featured_videos = Video::with('category')->where(['active' => '1', 'featured' => '1'])->orderBy('created_at', 'DESC')->limit($this->_num_featured_videos)->get();
        foreach($featured_videos as $featured_video) {
            array_push($excluded_video_ids, $featured_video->id);
        }

        $recent_videos =
            Video::with('favorite')
                ->where('active', '=', '1')
                ->whereNotIn('videos.id', $excluded_video_ids)
                ->orderBy('created_at', 'DESC')->limit($this->_num_recent_videos)->get();
        foreach($recent_videos as $recent_video) {
            array_push($excluded_video_ids, $recent_video->id);
        }
        //find popular videos and exclude featured
        $popular_videos =
            Video::with('favorite')
                ->where('active', '=', '1')
                ->whereNotIn('videos.id', $excluded_video_ids)
                ->orderByLikesCount()->limit($this->_num_popular_videos)->get();
        foreach($popular_videos as $popular_video) {
            array_push($excluded_video_ids, $popular_video->id);
        }

        $title = new Title;
        $title->set($this->_settings->website_name);
        $description = new Description;
        $description->set($this->_settings->website_description);

        $seo_data = array(
            'meta_title' => $title,
            'meta_description' => $description,
        );



        $webmasters_data = array();
        if(!empty($this->_settings->webmasters_google)) {
            $webmasters_data['google'] = $this->_settings->webmasters_google;
        }
        if(!empty($this->_settings->webmasters_bing)) {
            $webmasters_data['bing'] = $this->_settings->webmasters_bing;
        }
        if(!empty($this->_settings->webmasters_alexa)) {
            $webmasters_data['alexa'] = $this->_settings->webmasters_alexa;
        }
        if(!empty($this->_settings->webmasters_yandex)) {
            $webmasters_data['yandex'] = $this->_settings->webmasters_yandex;
        }

        if(sizeof($webmasters_data)) {
            $webmasters = new Webmasters($webmasters_data);
        }
        if(isset($webmasters)) {
            $seo_data['webmasters'] = $webmasters;
        }

		$data = array(
			'recent_videos' => $recent_videos,
            'featured_videos' => $featured_videos,
            'popular_videos' => $popular_videos,
			'current_page' => 1,
			'menu' => Menu::orderBy('order', 'ASC')->get(),
			'pagination_url' => '/videos',
			'video_categories' => VideoCategory::all(),
			'post_categories' => PostCategory::all(),
			'theme_settings' => $theme_settings,
			'pages' => Page::where('active', '=', 1)->get(),
            'number_videos_posted' => Video::where('active', 1)->count(),
            'excluded_video_ids' => $excluded_video_ids,
			);
        if(isset($seo_data)) {
            $data['seo'] = $seo_data;
        }
		//dd($data['featured_videos']);
        if(isset($theme_settings->homepage_file) && substr($theme_settings->homepage_file, 0, 4) == 'home') {
            $homepage_template = $theme_settings->homepage_file;
        }
        else {
            $homepage_template = 'home';
        }


		return View::make('Theme::' . $homepage_template, $data);
	}

}