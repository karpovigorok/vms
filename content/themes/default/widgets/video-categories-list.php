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
/**
 * Project: vms.
 * User: Igor Karpov
 * Email: mail@noxls.net
 * Date: 29.07.18
 * Time: 0:54
 */
?>
<!-- categories -->
<div class="widgetBox clearfix">
    <div class="widgetTitle">
        <h5><?php echo _i('Categories');?></h5>
    </div>
    <div class="widgetContent clearfix">
        <ul>
            <?php
            foreach($video_categories as $category):
                $num_videos = App\Models\Video::where('video_category_id', $category->id)->count();
                ?>
            <li class="cat-item">
                <a href="<?php echo ($settings->enable_https) ? secure_url('videos/category') : URL::to('videos/category'); ?><?php echo '/' . $category->slug; ?>"><?php echo $category->name; ?> (<?php echo $num_videos;?>)</a>
            </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>
<!-- end categories -->
