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
<?php if(isset($widget_recent_videos) && sizeof($widget_recent_videos)):?>
<div class="widgetBox">
    <div class="widgetTitle">
        <h5><?php echo _i('Recent Videos');?></h5>
    </div>
    <div class="widgetContent">
        <?php foreach ($widget_recent_videos as $widget_recent_video): ?>
        <div class="media-object">
            <div class="media-object-section">
                <div class="recent-img">
                    <img src="<?php echo ImageHandler::getImage($widget_recent_video->image, '80x80')  ?>" alt="<?php echo htmlspecialchars($widget_recent_video->title); ?>">
                    <a href="<?php echo ($settings->enable_https) ? secure_url('video') : URL::to('video') ?><?php echo '/' . $widget_recent_video->id ?>" class="hover-posts">
                        <span><i class="fa fa-play"></i></span>
                    </a>
                </div>
            </div>
            <div class="media-object-section">
                <div class="media-content">
                    <h6><a href="<?php echo ($settings->enable_https) ? secure_url('video') : URL::to('video') ?><?php echo '/' . $widget_recent_video->id ?>">
                            <?php echo $widget_recent_video->title; ?>
                        </a>
                    </h6>
                    <p>
                        <i class="fa fa-clock-o"></i><span><?php echo TimeHelper::time_elapsed_string($widget_recent_video->created_at); ?></span>
                    </p>
                </div>
            </div>
        </div>
        <?php endforeach;?>
    </div>
</div>
<?php endif;?>