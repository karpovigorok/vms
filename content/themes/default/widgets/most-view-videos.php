<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.0
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov
    * @website https://noxls.net
    *
*/?>
<?php if(isset($most_view_videos) && sizeof($most_view_videos)):?>
<!-- most view Widget -->
<div class="widgetBox">
    <div class="widgetTitle">
        <h5><?php echo _i('Most View Videos');?></h5>
    </div>
    <div class="widgetContent">
        <?php
        foreach($most_view_videos as $video): ?>
            <div class="video-box thumb-border">
                <div class="video-img-thumb">
                    <img src="<?php echo ImageHandler::getImage($video->image, '300x190')  ?>" alt="<?php echo htmlspecialchars($video->title); ?>">
                    <a href="<?php echo ($settings->enable_https) ? secure_url('video') : URL::to('video') ?><?php echo '/' . $video->id ?>" class="hover-posts">
                        <span><i class="fa fa-play"></i>Watch Video</span>
                    </a>
                </div>
                <div class="video-box-content">
                    <h6><a href="<?php echo ($settings->enable_https) ? secure_url('video') : URL::to('video') ?><?php echo '/' . $video->id ?>"><?php echo $video->title; ?></a></h6>
                    <p>
                        <span><i class="fa fa-clock-o"></i><?php echo TimeHelper::time_elapsed_string($video->created_at); ?></span>
                        <span><i class="fa fa-eye"></i><?php echo $video->views . ' ' . _n('view', 'views', $video->views); ?></span>
                    </p>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>
<!-- end most view Widget -->
<?php endif;?>