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
use \App\User as User;
use App\Models\VideoCategory;
use App\Models\PostCategory;
use App\Libraries\ThemeHelper;
use App\Models\Page;
use Arcanedev\SeoHelper\Entities\Title;
use Arcanedev\SeoHelper\Entities\Description;

class ThemePageController extends \BaseController {

    private $_settings;
    public function __construct()
    {
        $this->middleware('secure');
        $this->_settings = ThemeHelper::getSystemSettings();
        parent::__construct();
    }

    /**
     * Display the specified post.
     *
     * @param  int  $id
     * @return Response
     */
    public function index($slug)
    {
        $page = Page::where('slug', '=', $slug)->first();
            
        //Make sure page is active
        if((!Auth::guest() && Auth::user()->role == 'admin') || $page->active){
            $author = User::find($page->user_id);

            $title = new Title;
            $title->set($page->title)
                ->setSeparator('|')
                ->setSiteName($this->_settings->website_name);
            $description = new Description;
            $description->set($page->title . '-' . $this->_settings->website_name);

            $seo_data = array(
                'meta_title' => $title,
                'meta_description' => $description,
            );

            $data = array(
                    'page' => $page, 
                    'author' => $author,
                    'menu' => Menu::orderBy('order', 'ASC')->get(),
                    'video_categories' => VideoCategory::all(),
                    'post_categories' => PostCategory::all(),
                    'theme_settings' => ThemeHelper::getThemeSettings(),
                    'pages' => Page::where('active', '=', 1)->get(),
                    'seo' => $seo_data,
                );
            return View::make('Theme::page', $data);

        } else {
            return Redirect::to('pages')->with(array('note' => _i('Sorry, this page is no longer active.'), 'note_type' => 'error'));
        }
    }

    /*
     * Page That shows the latest video list
     *
     */
    public function pages()
    {
        $data = array(
                'pages' => Page::orderBy('created_at', 'DESC')->get(),
                'page_title' => 'Pages',
                'page_description' => 'All Pages',
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'video_categories' => VideoCategory::all(),
                'post_categories' => PostCategory::all(),
                'theme_settings' => ThemeHelper::getThemeSettings(),
                'pages' => Page::where('active', '=', 1)->get(),
            );

        return View::make('Theme::page-list', $data);
    }

}