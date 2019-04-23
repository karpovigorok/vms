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

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use App\Models\Comment;
use App\Libraries\ThemeHelper;

class RecentComments extends AbstractWidget
{

    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
    ];


    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $settings = ThemeHelper::getSystemSettings();
        if($settings->enable_video_comments) {
            $sidebar_recent_comments = Comment::with('user')
                ->where(['approved' => '1', 'commentable_type' => 'App\Models\Video', 'parent_id' => null])
                //->groupBy('commentable_id')
                ->orderBy('created_at', 'DESC')
                ->limit(6)
                ->get();

            return view('Theme::widgets.recent-comments', ['sidebar_recent_comments' => $sidebar_recent_comments]);
        }
        else {
            return '';
        }

    }
}