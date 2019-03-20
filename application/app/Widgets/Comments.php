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

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\Setting;

class Comments extends AbstractWidget
{
    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [];
    public $encryptParams = true;



    private $_video_comments_per_page = 50;

    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {

        $settings = Setting::first();
        if(isset($settings->videos_per_page) && $settings->videos_per_page > 0) {
            $this->_videos_per_page = $settings->videos_per_page;
        }

        if(isset($settings->video_comments_per_page) && $settings->video_comments_per_page > 0) {
            $this->_video_comments_per_page = $settings->video_comments_per_page;
        }

        //

//        $data = [];
//        dd($this->config);
        $article_id = $this->config['article_id'];


        if($this->config['type'] == 'video') {
            $article = \App\Models\Video::find($article_id);

        }
        elseif($this->config['type'] == 'post') {
            $article = \App\Models\Post::find($article_id);
        }

        $comments = \App\Models\Comment::with('user')
            ->where('commentable_id', $article->id)
            ->where('commentable_type', get_class($article))
            ->whereNull('parent_id')
            ->where('approved', 1);

        if($this->config['sort_order'] == "popular") {
            $comments = $comments->orderByLikesCount();
        }
        else {
            $comments = $comments->orderBy('created_at', 'DESC');
        }
        $comments = $comments->paginate($this->_video_comments_per_page);
        $data['sort_order'] = $this->config['sort_order'];
        $data['comments'] = $comments;
        $data['article'] = $article;
        $data['commentable_type'] = $this->config['type'];
        $data['video_comments_per_page'] = $this->_video_comments_per_page;
        return view('Theme::widgets.comments', $data);

    }

    public function placeholder()
    {
        return 'Loading...';
    }

    /**
     * Async and reloadable widgets are wrapped in container.
     * You can customize it by overriding this method.
     *
     * @return array
     */
    public function container()
    {
        return [
            'element'       => 'div',
            'attributes'    => 'class="comments-widget-container"',
        ];
    }
}
