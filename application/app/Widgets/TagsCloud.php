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
use \App\Widgets\Tag;
use DB;

class TagsCloud extends AbstractWidget
{
    /**
     * Treat this method as a controller action.
     * Return view() or other content to display.
     */
    public function run()
    {
        $data['tags'] = DB::table('tag_video')
                ->join('tags', 'tags.id', '=', 'tag_video.tag_id')
                ->select('tag_id', 'name',  DB::raw('count(*) as tags_count'))
                ->groupBy('tag_id')
                ->orderBy('tags_count', 'DESC')
                ->limit(20)
                ->get();

        return view('Theme::widgets.tags-cloud', $data);
    }
}