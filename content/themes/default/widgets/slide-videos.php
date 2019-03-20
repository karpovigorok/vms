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
 * Date: 21.08.18
 * Time: 0:33
 */
?>
<?php if(sizeof($slide_videos)):?>
<!-- slide video -->
<div class="large-12 medium-7 medium-centered columns">
    <section class="widgetBox">
        <div class="row">
            <div class="large-12 columns">
                <div class="column row">
                    <div class="heading category-heading clearfix">
                        <div class="cat-head pull-left">
                            <h4><?php echo _i('Featured videos');?></h4>
                        </div>
                        <div class="sidebar-video-nav">
                            <div class="navText pull-right">
                                <a class="prev secondary-button"><i class="fa fa-angle-left"></i></a>
                                <a class="next secondary-button"><i class="fa fa-angle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- slide Videos-->
                <div id="owl-demo-video" class="owl-carousel carousel" data-car-length="1" data-items="1" data-loop="true" data-nav="false" data-autoplay="true" data-autoplay-timeout="3000" data-dots="false">

                    <?php foreach ($slide_videos as $video):?>
                    <div class="item item-video thumb-border">
                        <figure class="premium-img">
                            <img src="<?php echo ImageHandler::getImage($video->image, '300x190')  ?>" alt="<?php echo htmlspecialchars($video->title); ?>">
                            <a href="<?php echo ($settings->enable_https) ? secure_url('video') : URL::to('video') ?><?php echo '/' . $video->id ?>" class="hover-posts">
                                <span><i class="fa fa-play"></i></span>
                            </a>
                        </figure>
                        <div class="video-des">
                            <h6><a href="<?php echo ($settings->enable_https) ? secure_url('video') : URL::to('video') ?><?php echo '/' . $video->id ?>"><?php echo $video->title;?></a></h6>
                            <div class="post-stats clearfix">
                                <!--p class="pull-left">
                                    <i class="fa fa-clock-o"></i>
                                    <span><?php echo date("F jS, Y", strtotime($video->created_at)); ?></span>
                                </p-->
                                <p class="pull-left">
                                    <i class="fa fa-eye"></i>
                                    <span><?php echo $video->views . ' ' . _n('view', 'views', $video->views); ?> </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach;?>
                </div><!-- end carousel -->
            </div>
        </div>
    </section><!-- End Category -->
</div><!-- End slide video -->
<?php endif;?>