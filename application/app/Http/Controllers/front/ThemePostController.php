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
use App\User as User;
use App\Models\VideoCategory;
use App\Models\PostCategory;
use App\Models\Post;
use App\Libraries\ThemeHelper;
use App\Models\Page;
//SEO
use Arcanedev\SeoHelper\Entities\Title;
use Arcanedev\SeoHelper\Entities\Description;
use Arcanedev\SeoHelper\Entities\Keywords;
use Arcanedev\SeoHelper\Entities\MiscTags;
use Arcanedev\SeoHelper\Entities\Webmasters;
use Arcanedev\SeoHelper\Entities\OpenGraph\Graph;
use Arcanedev\SeoHelper\Entities\Twitter\Card;

class ThemePostController extends \BaseController {

    private $_posts_per_page = 5;
    private $_enable_post_comments = false;
    private $_post_comments_per_page = 50;
    private $_settings;

    public function __construct()
    {
        $this->middleware('secure');
        //$settings = Setting::first();
        $this->_settings = ThemeHelper::getSystemSettings();
        //$this->_posts_per_page = $this->_settings->posts_per_page;
        $this->_enable_post_comments =  $this->_settings->enable_post_comments;
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
        $post = Post::where('slug', '=', $slug)->first();
        
        //Make sure post is active
        if((!Auth::guest() && Auth::user()->role == 'admin') || $post->active){

            $author = User::find($post->user_id);

            $title = new Title;
            $title->set(($post->hasSeo() && $post->seo->title != '')?$post->seo->title:$post->title);
            $title->setSeparator('|');
            $title->setSiteName($this->_settings->website_name);

            $description = new Description;
            $description->set(($post->hasSeo() && $post->seo->description != '')?$post->seo->description:$this->_settings->website_description);

            $keywords = new Keywords;
            $keywords->set(($post->hasSeo() && !is_null($post->seo->keywords))?$post->seo->keywords->toArray(): []);


            $data_misc_tags = [
                //'canonical' => true,
                'robots'    => ($post->hasSeo() && isset($post->seo->noindex)?$post->seo->noindex:false),  // true (for local environment) and false (for production environment)
                'default'   => [
                    'viewport'  => 'width=device-width, initial-scale=1.0', // Responsive design thing
                ],
            ];

            $meta_misc_tags = new MiscTags($data_misc_tags);

            $openGraph = new Graph;
            $openGraph->setType('website');
            //
            if($post->hasSeo() && isset($post->seo->extras['og']['title']) && mb_strlen($post->seo->extras['og']['title']) > 0) {
                $openGraph->setTitle($post->seo->extras['og']['title']);
            }
            else {
                $openGraph->setTitle($title->getTitleOnly());
            }

            if($post->hasSeo() && isset($post->seo->extras['og']['description']) && mb_strlen($post->seo->extras['og']['description']) > 0) {
                $openGraph->setDescription($post->seo->extras['og']['description']);
            }
            else {
                $openGraph->setDescription(mb_substr($description->getContent(), 0, $description->getMax()));
            }
            $openGraph->setSiteName($title->getSiteName());
            $openGraph->setUrl(url()->current());
            if($post->hasSeo() && isset($post->seo->extras['og']['image']) && mb_strlen($post->seo->extras['og']['image']) > 0) {
                $openGraph->setImage($post->seo->extras['og']['image']);
            }
            else {
                $openGraph->setImage(url(ImageHandler::getImage($post->image)));
            }


            $openGraph->setImage(($post->hasSeo() && isset($post->seo->extras['og']['image']))?$post->seo->extras['og']['image']:url(ImageHandler::getImage($post->image, '800x400')));
            $openGraph->addProperty('locale', LaravelGettext::getLocale());



            $twitter_card = new Card;
            $twitter_card->setType('summary');
            //$twitter_card->setSite('@Arcanedev');         // Or just 'Arcanedev'
            if(($post->hasSeo() && isset($post->seo->extras['tc']['title']) && strlen($post->seo->extras['tc']['title']))) {
                $twitter_card->setTitle($post->seo->extras['tc']['title']);
            }
            else {
                $twitter_card->setTitle($title->getTitleOnly());
            }


            if($post->hasSeo() && strlen($post->seo->extras['tc']['description']) && isset($post->seo->extras['tc']['description'])) {
                $twitter_card->setDescription($post->seo->extras['tc']['description']);
            }
            else {
                $twitter_card->setDescription(mb_substr($description->getContent(), 0, $description->getMax()));
            }

            $twitter_card->addMeta('url', url()->current());

            if($post->hasSeo() && isset($post->seo->extras['tc']['image']) && strlen($post->seo->extras['tc']['image']) > 0) {
                $twitter_card->addImage($post->seo->extras['tc']['image']);
            }
            else {
                $twitter_card->addImage(url(ImageHandler::getImage($post->image)));
            }



            $seo_data = array(
                'noindex' => ($post->hasSeo() && isset($post->seo->noindex)?$post->seo->noindex:false),
                'meta_title' => $title,
                'meta_description' => $description,
                'meta_keywords' => $keywords,
                'meta_misc_tags' => $meta_misc_tags,
                'openGraph' => $openGraph,
                'twitter_card' => $twitter_card,
            );
            $data = array(
                    'post' => $post, 
                    'author' => $author,
                    'menu' => Menu::orderBy('order', 'ASC')->get(),
                    'video_categories' => VideoCategory::all(),
                    'post_categories' => PostCategory::all(),
                    'theme_settings' => ThemeHelper::getThemeSettings(),
                    'pages' => Page::where('active', '=', 1)->get(),
                    'enable_post_comments' => $this->_enable_post_comments,
                    'post_comments_per_page' => $this->_post_comments_per_page
                );
            $data['seo'] = $seo_data;
            if($this->_enable_post_comments) {
                $data['comments'] = \App\Models\Comment::with('user')
                    ->where('commentable_id', $post->id)
                    ->where('commentable_type', 'Post')
                    ->where('approved', 1)->get()
                    ->sortByDesc('created_at');
            }
            return View::make('Theme::post', $data);

        } else {
            return Redirect::to('posts')->with(array('note' => _i('Sorry, this post is no longer active.'), 'note_type' => 'error'));
        }
    }


    /*
     * Page That shows the latest posts list
     *
     */
    public function posts()
    {   
        $page = Input::get('page');
        if( !empty($page) ){
            $page = Input::get('page');
        } else {
            $page = 1;
        }

        $data = array(
            'posts' => Post::where('active', '=', '1')->orderBy('created_at', 'DESC')->paginate($this->_posts_per_page),
            'current_page' => $page,
            'page_title' => 'All Posts',
            'page_description' => 'Page ' . $page,
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'pagination_url' => '/posts',
            'video_categories' => VideoCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::where('active', '=', 1)->get(),
            'enable_post_comments' => $this->_enable_post_comments,
            );

        return View::make('Theme::post-list', $data);
    }

    public function category($category)
    {
        $page = Input::get('page');
        if( !empty($page) ){
            $page = Input::get('page');
        } else {
            $page = 1;
        }

        $cat = PostCategory::where('slug', '=', $category)->first();
        $data = array(
            'posts' => Post::where('active', '=', '1')->where('post_category_id', '=', $cat->id)->orderBy('created_at', 'DESC')->paginate($this->_posts_per_page),
            'current_page' => $page,
            'category' => $cat,
            'page_title' => 'Posts - ' . $cat->name,
            'page_description' => 'Page ' . $page,
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'pagination_url' => '/posts/category/' . $category,
            'video_categories' => VideoCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::where('active', '=', 1)->get(),
            'enable_post_comments' => $this->_enable_post_comments,
        );

        return View::make('Theme::post-list', $data);
    }


}