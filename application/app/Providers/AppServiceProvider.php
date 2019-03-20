<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.0
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov
    * @website https://noxls.net
    *
*/?>
<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use \App\Models\Setting;
use \App\Models\VideoCategory;
use \App\Models\PostCategory;
use \App\Models\Page as Page;

use \App\Libraries\ThemeHelper;

class AppServiceProvider extends ServiceProvider {

	/**
	 * Bootstrap any application services.
	 *
	 * @return void
	 */
	public function boot()
	{
	    $settings = Setting::first();
	    $theme = $settings->theme;
	    $theme_settings = ThemeHelper::getThemeSettings();
	    $menu = \Menu::orderBy('order', 'ASC')->get();
	    $video_categories = VideoCategory::all();
	    $post_categories = PostCategory::all();
	    $pages = Page::all();
		//
		view()->share('settings', $settings);
		view()->share('theme', $theme);
		view()->share('theme_settings', $theme_settings);
		view()->share('menu', $menu);
		view()->share('video_categories', $video_categories);
		view()->share('post_categories', $post_categories);
		view()->share('pages', $pages);

	}

	/**
	 * Register any application services.
	 *
	 * This service provider is a great spot to register your various container
	 * bindings with the application. As you can see, we are registering our
	 * "Registrar" implementation here. You can add your own bindings too!
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app->bind(
			'Illuminate\Contracts\Auth\Registrar',
			'App\Services\Registrar'
		);
	}

}
