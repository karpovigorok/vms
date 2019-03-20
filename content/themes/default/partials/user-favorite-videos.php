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
                    <h4><?php echo _i('Favorite Videos');?></h4>
                </div>
                <?php foreach ($favorites as $favorite):
                    $video = $favorite->video();
                    ?>
                <div class="profile-video">
                    <div class="media-object">
                        <div class="media-object-section media-img-content">
                            <div class="video-img">
                                <img src="<?php echo ImageHandler::getImage($video->image, "170x150"); ?>" alt="<?php echo $video->title;?>">
                            </div>
                        </div>
                        <div class="media-object-section media-video-content">
                            <div class="video-content">
                                <h5><a href="<?php echo ($settings->enable_https) ? secure_url('video') : URL::to('video') . '/' . $video->id; ?>"><?php echo $video->title; ?></a></h5>
                                <p><?php echo $video->description; ?></p>
                            </div>
                            <div class="video-detail clearfix">
                                <div class="video-stats">
                                    <span><i class="fa fa-check-square-o"></i><?php echo _i('published');?></span>
                                    <span><i class="fa fa-clock-o"></i><?php echo date("d F , Y", strtotime($video->created_at)); ?></span>
                                    <span><i class="fa fa-eye"></i><?php echo $video->views; ?></span>
                                </div>
                                <?php

                                if(Auth::check() && Auth::user()->id == $favorite->user_id):?>
                                <div class="video-btns">
                                    <form method="post" action="/favorite" class="favorite-form">
                                        <button type="submit" name="unfav"><i class="fa fa-heart-o"></i><?php echo _i('Unfavorite');?></button>
                                        <input type="hidden" name="video_id" id="video_id"
                                               value="<?php echo $video->id; ?>">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                                        <input type="hidden" name="authenticated" id="authenticated"
                                               value="<?php echo intval(Auth::check()); ?>">
                                    </form>
                                </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    </section><!-- End single post description -->
</div><!-- end left side content area -->
<script src="http://malsup.github.com/jquery.form.js"></script>
<script>
    $(document).ready(function () {
        $(".favorite-form").submit(function () {
            if ($('#authenticated').val() == 1) {
                $(this).ajaxSubmit();
                $('#favorite-button').toggleClass('active');
                return false;
            } else {
                window.location = '/signup';
            }
        });
    });
</script>
