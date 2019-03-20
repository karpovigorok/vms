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
use \App\Models\Comment as Comment;
use App\Models\Video;
use App\Models\Favorite;

class UserProfileHeader extends AbstractWidget
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
    public function run($user)
    {
        //dd($user->id);
        $data = array(
            'user' => $user,
            'count_uploaded_videos' => Video::where('user_id', $user->id)->count(),
            'count_user_comments' => Comment::where('approved', '=', '1')->where('commented_id', $user->id)->count(),
            'count_favorited_by_user' => Favorite::where('user_id', '=', $user->id)->count(),
        );

        return view('Theme::widgets.user-profile-header', $data);
    }
}