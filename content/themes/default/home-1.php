<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<?php include('includes/header.php'); ?>
<!-- Template: <?php echo basename(__FILE__); ?> -->
    <!-- layerslider -->
<!--    <section id="slider">-->
<!--        <div id="full-slider-wrapper">-->
<!--            <div id="layerslider" style="width:100%;height:500px;">-->
<!--                <div class="ls-slide" data-ls="transition2d:1;timeshift:-1000;">-->
<!--                    <img src="images/sliderimages/bg.png" class="ls-bg" alt="Slide background"/>-->
<!--                    <h3 class="ls-l" style="left:50px; top:135px; padding: 15px; color: #444444;font-size: 24px;font-family: 'Open Sans'; font-weight: bold; text-transform: uppercase;" data-ls="offsetxin:0;durationin:2500;delayin:500;durationout:750;easingin:easeOutElastic;rotatexin:90;transformoriginin:50% bottom 0;offsetxout:0;rotateout:-90;transformoriginout:left bottom 0;">World’s Biggest</h3>-->
<!--                    <h1 class="ls-l" style="left: 63px; top:185px;background: #e96969;padding:0 10px; opacity: 1; color: #ffffff; font-size: 36px; font-family: 'Open Sans'; text-transform: uppercase; font-weight: bold;" data-ls="offsetxin:left;durationin:3000; delayin:800;durationout:850;rotatexin:90;rotatexout:-90;">Powerfull Video Theme</h1>-->
<!--                    <p class="ls-l" style="font-weight:600;left:62px; top:250px; opacity: 1;width: 450px; color: #444; font-size: 14px; font-family: 'Open Sans';" data-ls="offsetyin:top;durationin:4000;rotateyin:90;rotateyout:-90;durationout:1050;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been .</p>-->
<!--                    <a href="#" class="ls-l button" style="border-radius:4px;text-align:center;left:63px; top:315px;background: #444;color: #ffffff;font-family: 'Open Sans';font-size: 14px;display: inline-block; text-transform: uppercase; font-weight: bold;" data-ls="durationout:850;offsetxin:90;offsetxout:-90;duration:4200;fadein:true;fadeout:true;">Buy This Theme</a>-->
<!--                    <img class="ls-l" src="images/sliderimages/layer1.png" alt="layer 1" style="top:55px; left:700px;" data-ls="offsetxin:right;durationin:3000; delayin:600;durationout:850;rotatexin:-90;rotatexout:90;">-->
<!--                    <img class="ls-l ls-linkto-2" style="top:400px;left:50%;white-space: nowrap;" data-ls="offsetxin:-50;delayin:1000;rotatein:-40;offsetxout:-50;rotateout:-40;" src="images/sliderimages/left.png" alt="">-->
<!--                    <img class="ls-l ls-linkto-2" style="top:400px;left:52%;white-space: nowrap;" data-ls="offsetxin:50;delayin:1000;offsetxout:50;" src="images/sliderimages/right.png" alt="">-->
<!--                </div>-->
<!--                <div class="ls-slide" data-ls="transition2d:1;timeshift:-1000;">-->
<!--                    <img src="images/sliderimages/bg2.png" class="ls-bg" alt="Slide background"/>-->
<!--                    <h3 class="ls-l" style="left:50%; top:150px; padding: 15px; color: #444444;font-size: 24px;font-family: 'Open Sans'; font-weight: bold; text-transform: uppercase;" data-ls="offsetxin:0;durationin:2500;delayin:500;durationout:750;easingin:easeOutElastic;rotatexin:90;transformoriginin:50% bottom 0;offsetxout:0;rotateout:-90;transformoriginout:left bottom 0;">Betube is a World’s Biggest</h3>-->
<!--                    <h1 class="ls-l" style="left: 50%; top:200px;background: #e96969;padding:0 10px; opacity: 1; color: #ffffff; font-size: 36px; font-family: 'Open Sans'; text-transform: uppercase; font-weight: bold;" data-ls="offsetxin:left;durationin:3000; delayin:800;durationout:850;rotatexin:90;rotatexout:-90;">Boost your video Website</h1>-->
<!--                    <p class="ls-l" style="text-align:center; font-weight:600;left:50%; top:265px; opacity: 1;width: 450px; color: #444; font-size: 14px; font-family: 'Open Sans';" data-ls="offsetyin:top;durationin:4000;rotateyin:90;rotateyout:-90;durationout:1050;">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been .</p>-->
<!--                    <a href="#" class="ls-l button" style="border-radius:4px;text-align:center;left:50%; top:315px;background: #444;color: #ffffff;font-family: 'Open Sans';font-size: 14px;display: inline-block; text-transform: uppercase; font-weight: bold;" data-ls="durationout:850;offsetxin:90;offsetxout:-90;duration:4200;fadein:true;fadeout:true;">Buy This Theme</a>-->
<!--                    <img class="ls-l ls-linkto-1" style="top:400px;left:50%;white-space: nowrap;" data-ls="offsetxin:-50;delayin:1000;rotatein:-40;offsetxout:-50;rotateout:-40;" src="images/sliderimages/left.png" alt="">-->
<!--                    <img class="ls-l ls-linkto-1" style="top:400px;left:52%;white-space: nowrap;" data-ls="offsetxin:50;delayin:1000;offsetxout:50;" src="images/sliderimages/right.png" alt="">-->
<!--                </div>-->
<!--            </div>-->
<!--        </div>-->
<!--    </section>-->
    <!--end slider-->
    <?php if(sizeof($featured_videos) > 0):?>
    <!-- Premium Videos -->
    <section id="premium">
        <div class="row">
            <div class="heading clearfix">
                <div class="large-11 columns">
                    <h4><i class="fa fa-play-circle-o"></i><?php echo _i('Premium Videos');?></h4>
                </div>
                <div class="large-1 columns">
                    <div class="navText show-for-large">
                        <a class="prev secondary-button"><i class="fa fa-angle-left"></i></a>
                        <a class="next secondary-button"><i class="fa fa-angle-right"></i></a>
                    </div>
                </div>
            </div>
        </div>
        <div id="owl-demo" class="owl-carousel carousel" data-car-length="4" data-items="4" data-loop="true" data-nav="false" data-autoplay="true" data-autoplay-timeout="3000" data-dots="false" data-auto-width="false" data-responsive-small="1" data-responsive-medium="2" data-responsive-xlarge="5">
            <?php foreach($featured_videos as $video):?>
            <div class="item">
                <figure class="premium-img">
                    <img src="<?php echo ImageHandler::getImage($video->image, '370x220')  ?>" alt="<?php echo $video->title; ?>">
                    <figcaption>
                        <h5><?php
                            if(mb_strlen($video->title) > 45):
                                echo mb_substr($video->title, 0, 45) . '...';
                            else:
                                echo $video->title;
                            endif;
                            ?></h5>
                        <?php if(isset($video->category->name)):?>
                            <p><?php echo $video->category->name; ?></p>
                        <?php endif;?>
                    </figcaption>
                </figure>
                <a href="<?php echo ($settings->enable_https) ? secure_url('video') : URL::to('video') . '/' . $video->id; ?>" class="hover-posts">
                    <span><i class="fa fa-play"></i><?php echo _i('watch video');?></span>
                </a>
            </div>
            <?php endforeach;?>
        </div>
    </section><!-- End Premium Videos -->
    <?php endif;?>
    <!-- Category -->
    <?php if(isset($video_categories) && sizeof($video_categories) && $number_videos_posted > 0):?>
        <section id="category">
            <div class="row secBg">
                <div class="large-12 columns">
                    <div class="column row">
                        <div class="heading category-heading clearfix">
                            <div class="cat-head pull-left">
                                <i class="fa fa-folder-open"></i>
                                <h4><?php echo _i('Browse Videos By Category');?></h4>
                            </div>
                            <div>
                                <div class="navText pull-right show-for-large">
                                    <a class="prev secondary-button"><i class="fa fa-angle-left"></i></a>
                                    <a class="next secondary-button"><i class="fa fa-angle-right"></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- category carousel -->
                    <div id="owl-demo-cat" class="owl-carousel carousel" data-autoplay="true" data-autoplay-timeout="3000" data-autoplay-hover="true" data-car-length="5" data-items="6" data-dots="false" data-loop="true" data-auto-width="true" data-margin="10">
                        <?php foreach($video_categories as $category): ?>
                            <div class="item-cat item thumb-border">
                                <figure class="premium-img">
                                    <?php $thumb = $category->thumb?:'default.png';?>

                                    <img src="<?php echo ImageHandler::getImage($thumb, "185x130");  ?>" alt="carousel" width="185">
                                    <a href="<?php echo ($settings->enable_https) ? secure_url('videos/category') : URL::to('videos/category'); ?><?php echo '/' . $category->slug; ?>" class="hover-posts">
                                        <span><i class="fa fa-search"></i></span>
                                    </a>
                                </figure>
                                <h6><a href="/videos/category/<?php echo $category->slug; ?>"><?php echo $category->name; ?></a></h6>
                            </div>
                        <?php endforeach; ?>
                    </div><!-- end carousel -->
                    <p></p>
                </div>
            </div>
        </section><!-- End Category -->
    <?php endif;?>

<?php if($number_videos_posted > 0):?>
    <!-- main content -->
    <section class="content">
        <!-- newest video -->
        <div class="main-heading">
            <div class="row secBg padding-14">
                <div class="medium-12 small-12 columns">
                    <div class="head-title">
                        <i class="fa fa-film"></i>
                        <h4><?php echo _i('Newest Videos');?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row secBg">
            <div class="large-12 columns">
                <div class="row column head-text clearfix">
                    <p class="pull-left"><?php echo _i('All Videos');?> : <span><?php echo $number_videos_posted;?> <?php echo _i('Videos posted');?></span></p>
                    <div class="grid-system pull-right show-for-large">
                        <a class="secondary-button current grid-default" href="#"><i class="fa fa-th"></i></a>
                        <a class="secondary-button grid-medium" href="#"><i class="fa fa-th-large"></i></a>
                        <a class="secondary-button list" href="#"><i class="fa fa-th-list"></i></a>
                    </div>
                </div>
                <div class="tabs-content" data-tabs-content="newVideos">
                    <div class="tabs-panel is-active" id="new-all">
                        <div class="row list-group">
                            <?php echo View::make('Theme::partials.video-loop', ['videos' => $recent_videos, 'class' => "item large-3 medium-6 columns group-item-grid-default"])->render();?>
                        </div>
                    </div>

                </div>
                <div class="text-center row-btn">
                    <a class="button radius" href="/videos"><?php echo _i('View All Video');?></a>
                </div>
            </div>
        </div>
    </section>
<?php endif;?>
<?php if(sizeof($popular_videos)):?>
    <section class="content">
        <!-- End newest video -->
        <!-- ad Section -->
        <?php echo Widget::run('adv-horizontal');?><!-- End ad Section -->

        <!-- popular Videos -->
        <div class="main-heading">
            <div class="row secBg padding-14">
                <div class="medium-12 small-12 columns">
                    <div class="head-title">
                        <i class="fa fa-star"></i>
                        <h4><?php echo _i('Most Popular Videos');?></h4>
                    </div>
                </div>
            </div>
        </div>
        <div class="row secBg">
            <div class="large-12 columns">
                <div class="row column head-text clearfix">
                    <p class="pull-left"><?php echo _i('All Videos');?>: <span><?php echo $number_videos_posted;?> <?php echo _i('Videos posted');?></span></p>
                    <div class="grid-system pull-right show-for-large">
                        <a class="secondary-button current grid-default" href="#"><i class="fa fa-th"></i></a>
                        <a class="secondary-button grid-medium" href="#"><i class="fa fa-th-large"></i></a>
                        <a class="secondary-button list" href="#"><i class="fa fa-th-list"></i></a>
                    </div>
                </div>
                <div class="tabs-content" data-tabs-content="popularVideos">
                    <div class="tabs-panel is-active" id="popular-all">
                        <div class="row list-group">
                            <?php echo View::make('Theme::partials.video-loop', ['videos' => $popular_videos, 'class' => "item large-3 medium-6 columns group-item-grid-default"])->render();?>
                        </div>
                    </div>
                </div>
                <div class="text-center row-btn">
                    <a class="button radius" href="/videos"><?php echo _i('View All Video');?></a>
                </div>
            </div>
        </div>
    </section><!-- End main content -->
<?php endif;?>
    <?php echo Widget::run('adv-horizontal');?><!-- End ad Section -->
<?php  include('includes/footer.php'); ?>