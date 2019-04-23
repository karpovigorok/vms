<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<?php namespace App\Providers;


use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Routing\Router;
use \Auth as Auth;
use \View as View;
use \Redirect as Redirect;
use \Plugin as Plugin;
use \App\Models\PluginData as PluginData;
use \Input as Input;


class RouteServiceProvider extends ServiceProvider
{

    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = null;

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
        $settings = \App\Libraries\ThemeHelper::getSystemSettings();

        if($_SERVER['DOCUMENT_ROOT'] != '') {
            $root_dir = rtrim($_SERVER['DOCUMENT_ROOT'], '/') . '/';
        }
        else {
            $root_dir = __DIR__ . '/../../public/';
        }

        if (\Cookie::get('theme')) {
            $theme = \Crypt::decrypt(\Cookie::get('theme'));
            define('THEME', $theme);
        } else {
            if ($settings->theme):
                $theme = $settings->theme;
                if (!defined('THEME')) define('THEME', $theme);
            endif;
        }

        if(!empty($settings->system_email)) {
            \Config::set('mail.from', ['address' => $settings->system_email, 'name' => $settings->website_name]);
        }

        if(!empty($settings->mail_username)) {
            \Config::set('mail.username', $settings->mail_username);
        }
        if(!empty($settings->mail_password)) {
            \Config::set('mail.password', $settings->mail_password);
        }

        if(!empty($settings->mail_host)) {
            \Config::set('mail.host', $settings->mail_host);
        }

        if(!empty($settings->mail_port)) {
            \Config::set('mail.port', $settings->mail_port);
        }

        @include($root_dir . 'content/themes/' . $theme . '/functions.php');

        View::addNamespace('Theme', $root_dir . 'content/themes/' . $theme);

        View::addNamespace('plugins', 'content/plugins/');

        try {

            $plugins = Plugin::where('active', '=', 1)->get();

            //print_r($plugins); die();
            foreach ($plugins as $plugin) {
                $plugin_name = $plugin->slug;
                $include_file = 'content/plugins/' . $plugin_name . '/functions.php';

                // Create Settings Route for Plugin

                Route::group(array('before' => 'admin'), function () {

                    Route::get('admin/plugin/{plugin_name}', function ($plugin_name) {
                        $plugin_data = PluginData::where('plugin_slug', '=', $plugin_name)->get();

                        $data = array();

                        foreach ($plugin_data as $plugin):
                            $data[$plugin->key] = $plugin->value;
                        endforeach;


                        return View::make('plugins::' . $plugin_name . '.settings', $data);
                    });

                    Route::post('admin/plugin/{plugin_name}', function ($plugin_name) {
                        $input = Input::all();
                        foreach ($input as $key => $value) {
                            $pluginData = PluginData::where('plugin_slug', '=', $plugin_name)->where('key', '=', $key)->first();

                            if (!empty($pluginData->id)) {
                                $pluginData->value = $value;
                                $pluginData->save();
                            } else {
                                $pluginData = new PluginData;
                                $pluginData->plugin_slug = $plugin_name;
                                $pluginData->key = $key;
                                $pluginData->value = $value;
                                $pluginData->save();
                            }
                        }

                        return Redirect::to('/admin/plugin/' . $plugin_name)->with(array('note' => 'Successfully updated plugin information', 'note_type' => 'success'));
                    });

                });

                if (file_exists($include_file)) {

                    include($include_file);
                }

            }

        } catch (Exception $e) {
            die('error in RouteServiceProvider.php with plugins');
        }


        Route::group(['middleware' => ['admin']], function () {
            if (!Auth::guest() && (Auth::user()->role == 'admin' || Auth::user()->role == 'demo')) {

            } else {
                return Redirect::to('/login');
            }
        });

//        Route::prefix('api')
//            ->middleware('api')
//            ->as('api.')
//            ->namespace($this->namespace."\\API")
//            ->group(base_path('routes/api.php'));


//		Route::filter('demo', function()
//		{
//			if (!Auth::guest() && Auth::user()->role == 'demo'){
//				return Redirect::back()->with(array('note' => 'Sorry, unfortunately this functionality is not available in demo accounts', 'note_type' => 'error'));
//			}
//		});


    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router $router
     * @return void
     */
    public function map(Router $router)
    {
        $router->group(['namespace' => $this->namespace], function ($router) {
            require base_path('routes/web.php');
        });
    }

}
