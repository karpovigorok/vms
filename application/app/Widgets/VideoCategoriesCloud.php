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
/**
 * Project: vms.
 * User: Igor Karpov
 * Email: mail@noxls.net
 * Date: 27.08.18
 * Time: 22:20
 */

namespace App\Widgets;

use Arrilot\Widgets\AbstractWidget;
use \App\Widgets\Tag;
use \App\Models\VideoCategory;

class VideoCategoriesCloud extends AbstractWidget
{
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $data['video_categories'] = VideoCategory::all();
        return view('Theme::widgets.video-categories-cloud', $data);
    }
}