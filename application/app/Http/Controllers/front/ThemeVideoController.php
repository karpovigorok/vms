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
use App\Models\Setting;
use App\Models\VideoCategory;
use App\Models\PostCategory;
use App\Models\Tag;
use App\Models\VideoTag;
use App\Models\Favorite;
use App\Models\Page;
use App\Libraries\ThemeHelper;
use Arcanedev\SeoHelper\Entities\Title;
use Arcanedev\SeoHelper\Entities\Description;
use Arcanedev\SeoHelper\Entities\Keywords;
use Arcanedev\SeoHelper\Entities\MiscTags;
use Arcanedev\SeoHelper\Entities\Webmasters;
use Arcanedev\SeoHelper\Entities\OpenGraph\Graph;
use Arcanedev\SeoHelper\Entities\Twitter\Card;
//$settings = \App\Models\Setting::first();

class ThemeVideoController extends \BaseController {

    private $_videos_per_page = 12;
    private $_enable_video_comments = false;
    private $_settings;


    public function __construct()
    {
        $this->middleware('secure');
        $this->_settings = Setting::first();
        $this->_enable_video_comments = $this->_settings->enable_video_comments;

        parent::__construct();
    }

    /**
     * Display the specified video.
     *
     * @param  int  $id
     * @return Response
     */
    public function index($id)
    {
        $video = Video::with('tags')->with('user')->findOrFail($id);

        //Make sure video is active
        if((!Auth::guest() && Auth::user()->role == 'admin') || $video->active){
            $favorited = false;
            if(!Auth::guest()):
                $favorited = Favorite::where('user_id', '=', Auth::user()->id)->where('video_id', '=', $video->id)->first();
            endif;

            $view_increment = $this->handleViewCount($id);
            $video->getTagsIds();

            $where = ['active' => 1, ['id', '!=', $video->id]];
            if(isset($video->category->id)) {
                $where['video_category_id'] = $video->category->id;
            }
            $related_videos = Video::with('user')
                ->where($where)
                ->where('id', '<>', $video->id)
                ->orderBy('created_at', 'DESC')
                ->limit(6)
                ->get();

            $title = new Title;
            $title->set(($video->hasSeo() && $video->seo->title != '')?$video->seo->title:$video->title);
            $title->setSeparator('|');
            $title->setSiteName($this->_settings->website_name);

            $description = new Description;
            $description->set(($video->hasSeo() && $video->seo->description != '')?$video->seo->description:$video->description);

            $keywords = new Keywords;
            $keywords->set(($video->hasSeo() && !is_null($video->seo->keywords))?$video->seo->keywords->toArray(): $video->getTagsVal());


            $data_misc_tags = [
                //'canonical' => true,
                'robots'    => ($video->hasSeo() && isset($video->seo->noindex)?$video->seo->noindex:false),  // true (for local environment) and false (for production environment)
                'default'   => [
                    'viewport'  => 'width=device-width, initial-scale=1.0', // Responsive design thing
                ],
            ];

            $meta_misc_tags = new MiscTags($data_misc_tags);

            if($video->hasSeo()) {
                $webmasters_data = array();
                if($video->seo->extras['webmasters']['google'] != '') {
                    $webmasters_data['google'] = $video->seo->extras['webmasters']['google'];
                }
                if($video->seo->extras['webmasters']['bing'] != '') {
                    $webmasters_data['bing'] = $video->seo->extras['webmasters']['bing'];
                }
                if($video->seo->extras['webmasters']['alexa'] != '') {
                    $webmasters_data['alexa'] = $video->seo->extras['webmasters']['alexa'];
                }
                if($video->seo->extras['webmasters']['pinterest'] != '') {
                    $webmasters_data['pinterest'] = $video->seo->extras['webmasters']['pinterest'];
                }
                if($video->seo->extras['webmasters']['yandex'] != '') {
                    $webmasters_data['yandex'] = $video->seo->extras['webmasters']['yandex'];
                }
                if(sizeof($webmasters_data)) {
                    $webmasters = new Webmasters($webmasters_data);
                }
            }
            $openGraph = new Graph;
            $openGraph->setType('website');
            //
            if($video->hasSeo() && isset($video->seo->extras['og']['title']) && mb_strlen($video->seo->extras['og']['title']) > 0) {
                $openGraph->setTitle($video->seo->extras['og']['title']);
            }
            else {
                $openGraph->setTitle($title->getTitleOnly());
            }

            if($video->hasSeo() && isset($video->seo->extras['og']['description']) && mb_strlen($video->seo->extras['og']['description']) > 0) {
                $openGraph->setDescription($video->seo->extras['og']['description']);
            }
            else {
                $openGraph->setDescription(mb_substr($description->getContent(), 0, $description->getMax()));
            }
            $openGraph->setSiteName($title->getSiteName());
            $openGraph->setUrl(url()->current());
            if($video->hasSeo() && isset($video->seo->extras['og']['image']) && mb_strlen($video->seo->extras['og']['image']) > 0) {
                $openGraph->setImage($video->seo->extras['og']['image']);
            }
            else {
                $openGraph->setImage(url(ImageHandler::getImage($video->image, '800x400')));
            }


            $openGraph->setImage(($video->hasSeo() && isset($video->seo->extras['og']['image']))?$video->seo->extras['og']['image']:url(ImageHandler::getImage($video->image, '800x400')));
            $openGraph->addProperty('locale', LaravelGettext::getLocale());



            $twitter_card = new Card;
            $twitter_card->setType('summary');
            //$twitter_card->setSite('@Arcanedev');         // Or just 'Arcanedev'
            if(($video->hasSeo() && isset($video->seo->extras['tc']['title']) && strlen($video->seo->extras['tc']['title']))) {
                $twitter_card->setTitle($video->seo->extras['tc']['title']);
            }
            else {
                $twitter_card->setTitle($title->getTitleOnly());
            }


            if($video->hasSeo() && strlen($video->seo->extras['tc']['description']) && isset($video->seo->extras['tc']['description'])) {
                $twitter_card->setDescription($video->seo->extras['tc']['description']);
            }
            else {
                $twitter_card->setDescription(mb_substr($description->getContent(), 0, $description->getMax()));
            }

            $twitter_card->addMeta('url', url()->current());

            if($video->hasSeo() && isset($video->seo->extras['tc']['image']) && strlen($video->seo->extras['tc']['image']) > 0) {
                $twitter_card->addImage($video->seo->extras['tc']['image']);
            }
            else {
                $twitter_card->addImage(url(ImageHandler::getImage($video->image, '800x400')));
            }



            $seo_data = array(
                'noindex' => ($video->hasSeo() && isset($video->seo->noindex)?$video->seo->noindex:false),
                'meta_title' => $title,
                'meta_description' => $description,
                'meta_keywords' => $keywords,
                'meta_misc_tags' => $meta_misc_tags,
                'openGraph' => $openGraph,
                'twitter_card' => $twitter_card,
            );
            if(isset($webmasters)) {
                $seo_data['webmasters'] = $webmasters;
            }



            $data = array(
                'video' => $video,
                'menu' => Menu::orderBy('order', 'ASC')->get(),
                'view_increment' => $view_increment,
                'favorited' => $favorited,
                'related_videos' => $related_videos,
                'post_categories' => PostCategory::all(),
                'theme_settings' => ThemeHelper::getThemeSettings(),
                'pages' => Page::where('active', '=', 1)->get(),
                'enable_video_comments' => $this->_enable_video_comments,
                //'video_comments_per_page' => $this->_video_comments_per_page,

                );

            $data['seo'] = $seo_data;

            $data['excluded_video_ids'] = array();
            array_push($data['excluded_video_ids'], $video->id);
            foreach($related_videos as $related_video) {
                array_push($data['excluded_video_ids'], $related_video->id);
            }
//            if($this->_enable_video_comments) {
//                $data['comments'] = \App\Models\Comment::with('user')
//                    ->where('commentable_id', $video->id)
//                    ->where('commentable_type', 'Video')
//                    ->where('approved', 1)->get()
//                    ->sortByDesc('created_at');
//            }


            //dd($data['comments']);
            return View::make('Theme::video', $data);

        } else {
            return Redirect::to('videos')->with(array('note' => _i('Sorry, this video is no longer active.'), 'note_type' => 'error'));
        }
    }

    /*
     * Page That shows the latest video list
     *
     */
    public function videos()
    {   
        $page = Input::get('page');
        if( !empty($page) ){
            $page = Input::get('page');
        } else {
            $page = 1;
        }
        $excluded_video_ids = array();

        $videos = Video::with('favorite')->where('active', '=', '1')->orderBy('created_at', 'DESC')->paginate($this->_videos_per_page);
        foreach($videos as $video) {
            array_push($excluded_video_ids, $video->id);
        }

        $data = array(
            'videos' => $videos,
            'page_title' => _i('All Videos') . '. ',
            'page_description' => _i('Page') . ' ' . $page,
            'current_page' => $page,
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'pagination_url' => '/videos',
            'video_categories' => VideoCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::where('active', '=', 1)->get(),
            'excluded_video_ids' => $excluded_video_ids,
            );
        return View::make('Theme::video-list', $data);
    }


    public function tag($tag)
    {

        $tag_name = $tag;
        if(!isset($tag)){
            return Redirect::to('videos');
        }
        $tag = Tag::where('name', '=', $tag)->first();
        if(is_null($tag)) {
            abort(404);
        }

        $page = Input::get('page');
        if( !empty($page) ){
            $page = Input::get('page');
        } else {
            $page = 1;
        }

        $excluded_video_ids = array();
        $tag_array = array();
        $tags = VideoTag::where('tag_id', '=', $tag->id)->get();

        if($tags->count()) {
            foreach($tags as $key => $tag_val){
                array_push($tag_array, $tag_val->video_id);
            }
        }

        $videos = Video::where('active', '=', '1')->whereIn('id', $tag_array)->paginate($this->_videos_per_page);
        foreach($videos as $video) {
            array_push($excluded_video_ids, $video->id);
        }

        $data = array(
            'videos' => $videos,
            'current_page' => $page,
            'page_title' => _i('Videos tagged with') . ': &laquo;' . $tag->name . '&raquo;.',
            'page_description' => _i('Page') . ' ' . $page,
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'pagination_url' => '/videos/tags/' . $tag->name,
            'video_categories' => VideoCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::where('active', '=', 1)->get(),
            'excluded_video_ids' => $excluded_video_ids,
            );

        return View::make('Theme::video-list', $data);
    }

    public function category($category)
    {
        $page = Input::get('page');
        $cat = VideoCategory::where('slug', '=', $category)->first();
        if(is_null($cat)) {
            abort(404);
        }

        if( !empty($page) ){
            $page = Input::get('page');
        } else {
            $page = 1;
        }
        $excluded_video_ids = array();
        $parent_cat = VideoCategory::where('parent_id', '=', $cat->id)->first();

        if(!empty($parent_cat->id)){
            $parent_cat2 = VideoCategory::where('parent_id', '=', $parent_cat->id)->first();
            if(!empty($parent_cat2->id)){
                $videos = Video::where('active', '=', '1')->where('video_category_id', '=', $cat->id)->orWhere('video_category_id', '=', $parent_cat->id)->orWhere('video_category_id', '=', $parent_cat2->id)->orderBy('created_at', 'DESC')->paginate($this->_videos_per_page);
            } else {
                $videos = Video::where('active', '=', '1')->where('video_category_id', '=', $cat->id)->orWhere('video_category_id', '=', $parent_cat->id)->orderBy('created_at', 'DESC')->paginate($this->_videos_per_page);
            }
        } else {
            $videos = Video::where('active', '=', '1')->where('video_category_id', '=', $cat->id)->orderBy('created_at', 'DESC')->paginate($this->_videos_per_page);
        }
        foreach($videos as $video) {
            array_push($excluded_video_ids, $video->id);
        }



        $title = new Title;
        $title->set(($cat->hasSeo() && $cat->seo->title != '')?$cat->seo->title:$cat->name);
        $title->setSeparator('|');
        $title->setSiteName($this->_settings->website_name);

        $description = new Description;
        $description->set($cat->name . '. ' . (($cat->hasSeo() && $cat->seo->description != '')?$cat->seo->description:$this->_settings->website_description));

        $keywords = new Keywords;
        $keywords->set(($cat->hasSeo() && !is_null($cat->seo->keywords))?$cat->seo->keywords->toArray(): []);


        $data_misc_tags = [
            //'canonical' => true,
            'robots'    => ($cat->hasSeo() && isset($cat->seo->noindex)?$cat->seo->noindex:false),  // true (for local environment) and false (for production environment)
            'default'   => [
                'viewport'  => 'width=device-width, initial-scale=1.0', // Responsive design thing
            ],
        ];

        $meta_misc_tags = new MiscTags($data_misc_tags);
        $meta_misc_tags->add('canonical', url('videos/category/' . $cat->slug));

        if($cat->hasSeo()) {
            $webmasters_data = array();
            if($cat->seo->extras['webmasters']['google'] != '') {
                $webmasters_data['google'] = $cat->seo->extras['webmasters']['google'];
            }
            if($cat->seo->extras['webmasters']['bing'] != '') {
                $webmasters_data['bing'] = $cat->seo->extras['webmasters']['bing'];
            }
            if($cat->seo->extras['webmasters']['alexa'] != '') {
                $webmasters_data['alexa'] = $cat->seo->extras['webmasters']['alexa'];
            }
            if($cat->seo->extras['webmasters']['pinterest'] != '') {
                $webmasters_data['pinterest'] = $cat->seo->extras['webmasters']['pinterest'];
            }
            if($cat->seo->extras['webmasters']['yandex'] != '') {
                $webmasters_data['yandex'] = $cat->seo->extras['webmasters']['yandex'];
            }
            if(sizeof($webmasters_data)) {
                $webmasters = new Webmasters($webmasters_data);
            }
        }
        $openGraph = new Graph;
        $openGraph->setType('website');
        //
        if($cat->hasSeo() && isset($cat->seo->extras['og']['title']) && mb_strlen($cat->seo->extras['og']['title']) > 0) {
            $openGraph->setTitle($cat->seo->extras['og']['title']);
        }
        else {
            $openGraph->setTitle($title->getTitleOnly());
        }

        if($cat->hasSeo() && isset($cat->seo->extras['og']['description']) && mb_strlen($cat->seo->extras['og']['description']) > 0) {
            $openGraph->setDescription($cat->seo->extras['og']['description']);
        }
        else {
            $openGraph->setDescription(mb_substr($description->getContent(), 0, $description->getMax()));
        }
        $openGraph->setSiteName($title->getSiteName());
        $openGraph->setUrl(url()->current());
        if($cat->hasSeo() && isset($cat->seo->extras['og']['image']) && mb_strlen($cat->seo->extras['og']['image']) > 0) {
            $openGraph->setImage($cat->seo->extras['og']['image']);
        }
        else {
            $openGraph->setImage(url(ImageHandler::getImage($cat->thumb)));
        }
        $openGraph->addProperty('locale', LaravelGettext::getLocale());



        $twitter_card = new Card;
        $twitter_card->setType('summary');
        //$twitter_card->setSite('@Arcanedev');         // Or just 'Arcanedev'
        if(($cat->hasSeo() && isset($cat->seo->extras['tc']['title']) && strlen($cat->seo->extras['tc']['title']))) {
            $twitter_card->setTitle($cat->seo->extras['tc']['title']);
        }
        else {
            $twitter_card->setTitle($title->getTitleOnly());
        }


        if($cat->hasSeo() && strlen($cat->seo->extras['tc']['description']) && isset($cat->seo->extras['tc']['description'])) {
            $twitter_card->setDescription($cat->seo->extras['tc']['description']);
        }
        else {
            $twitter_card->setDescription(mb_substr($description->getContent(), 0, $description->getMax()));
        }

        $twitter_card->addMeta('url', url()->current());

        if($cat->hasSeo() && isset($cat->seo->extras['tc']['image']) && strlen($cat->seo->extras['tc']['image']) > 0) {
            $twitter_card->addImage($cat->seo->extras['tc']['image']);
        }
        else {
            $twitter_card->addImage(url(ImageHandler::getImage($cat->thumb)));
        }



        $seo_data = array(
            'noindex' => ($cat->hasSeo() && isset($cat->seo->noindex)?$cat->seo->noindex:false),
            'meta_title' => $title,
            'meta_description' => $description,
            'meta_keywords' => $keywords,
            'meta_misc_tags' => $meta_misc_tags,
            'openGraph' => $openGraph,
            'twitter_card' => $twitter_card,
        );
        if(isset($webmasters)) {
            $seo_data['webmasters'] = $webmasters;
        }

        $data = array(
            'videos' => $videos,
            'current_page' => $page,
            'category' => $cat,
            'page_title' => _i('Videos') . ' - ' . $cat->name . '. ',
            'page_description' => _i('Page') . ' ' . $page,
            'pagination_url' => '/videos/category/' . $category,
            'menu' => Menu::orderBy('order', 'ASC')->get(),
            'video_categories' => VideoCategory::all(),
            'post_categories' => PostCategory::all(),
            'theme_settings' => ThemeHelper::getThemeSettings(),
            'pages' => Page::where('active', '=', 1)->get(),
            'excluded_video_ids' => $excluded_video_ids,
            'seo' => $seo_data,
        );

        return View::make('Theme::video-list', $data);
    }

    public function handleViewCount($id){
        // check if this key already exists in the view_media session
        $blank_array = array();
        if (! array_key_exists($id, Session::get('viewed_video', $blank_array) ) ) {
            
            try{
                // increment view
                $video = Video::find($id);
                $video->views = $video->views + 1;
                $video->save();
                // Add key to the view_media session
                Session::put('viewed_video.'.$id, time());
                return true;
            } catch (Exception $e){
                return false;
            }
        } else {
            return false;
        }
    }

}