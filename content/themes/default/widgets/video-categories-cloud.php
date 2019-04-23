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
 * Date: 27.08.18
 * Time: 21:56
 */
?>
<div class="widgetBox">
    <div class="widgetTitle">
        <h5><?php echo _i('Video Categories');?></h5>
    </div>
    <div class="tagcloud">
        <?php foreach($video_categories as $category): ?>
            <a href="<?php echo ($settings->enable_https) ? secure_url('videos/category') : URL::to('videos/category'); ?><?php echo '/' . $category->slug; ?>"><?php echo $category->name; ?></a>
        <?php endforeach; ?>
    </div>
</div>

