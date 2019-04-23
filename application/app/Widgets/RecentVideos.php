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
use App\Models\Video;

class RecentVideos extends AbstractWidget
{

    /**
     * The configuration array.
     *
     * @var array
     */
    protected $config = [
        'num_videos' => 3,
        'excluded_video_ids' => [],
    ];


    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $widget_recent_videos = Video::where('active', '=', '1')
            ->whereNotIn('id', $this->config['excluded_video_ids'])
            ->orderBy('created_at', 'DESC')
            ->limit($this->config['num_videos'])
            ->get();

        return view('Theme::widgets.recent-videos', ['widget_recent_videos' => $widget_recent_videos]);
    }
}