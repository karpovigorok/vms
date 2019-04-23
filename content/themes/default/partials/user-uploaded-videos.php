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
 * Date: 20.08.18
 * Time: 23:48
 */
?>
<!-- right side content area -->
<div class="large-8 columns profile-inner">
    <!-- single post description -->
    <section class="profile-videos">
        <div class="row secBg">
            <div class="large-12 columns">
                <div class="heading">
                    <i class="fa fa-video-camera"></i>
                    <h4><?php echo _i('My Videos');?></h4>
                </div>
                <?php if (!sizeof($videos) > 0): ?>
                    <?php foreach ($videos as $video): ?>
                        <div class="profile-video">
                            <div class="media-object">
                                <div class="media-object-section media-img-content">
                                    <div class="video-img">
                                        <img src="<?php echo ImageHandler::getImage($video->image, "370x220"); ?>"
                                             alt="<?php echo $video->title;?>">
                                    </div>
                                </div>
                                <div class="media-object-section media-video-content">
                                    <div class="video-content">
                                        <h5>
                                            <a href="<?php echo ($settings->enable_https) ? secure_url('video') : URL::to('video') . '/' . $video->id; ?>"><?php echo $video->title; ?></a>
                                        </h5>
                                        <p><?php echo $video->description; ?></p>
                                    </div>
                                    <div class="video-detail clearfix">
                                        <div class="video-stats">
                                            <span><i class="fa fa-check-square-o"></i><?php echo _i('published');?></span>
                                            <span><i class="fa fa-clock-o"></i><?php echo date("d F , Y", strtotime($video->created_at)); ?></span>
                                            <span><i class="fa fa-eye"></i><?php echo $video->views; ?></span>
                                        </div>
                                        <div class="video-btns">
                                            <a class="video-btn"
                                               href="/user/<?php echo Auth::user()->username; ?>/video/<?php echo $video->id; ?>/edit"><i
                                                        class="fa fa-pencil-square-o"></i><?php echo _i('edit');?></a>
                                            <a class="video-btn" href="#"><i class="fa fa-trash"></i><?php echo _i('delete');?></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <div class="text-center margin-bottom-10">
                        <h1><?php echo _i('No Videos uploaded yet.');?></h1>
                        <a href="/user/<?php echo Auth::user()->username; ?>/upload" class="button"><i
                                    class="fa fa-plus-circle"></i> <?php echo _i('Add my first video.');?></a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </section><!-- End single post description -->
</div><!-- end left side content area -->
