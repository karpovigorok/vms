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
use App\Models\Video;

use Arrilot\Widgets\AbstractWidget;

class SlideVideos extends AbstractWidget
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

        $data['slide_videos'] = Video::where(['active' => '1', 'featured' => '1'])
            ->whereNotIn('id', $this->config['excluded_video_ids'])
            ->orderBy('updated_at', 'DESC')
            ->limit($this->config['num_videos'])->get();
        return view('Theme::widgets.slide-videos', $data);
    }
}