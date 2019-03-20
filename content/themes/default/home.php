<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.0
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov
    * @website https://noxls.net
    *
*/?>
<?php include('includes/header.php'); ?>
<!-- Template: <?php echo basename(__FILE__); ?> -->
<style type="text/css">
#home-content{
	margin-top:545px;
}
ul.video_list{
	margin:0px;
	padding:0px;
}

.video_list li{
	display:inline;
	list-style: none;
}
</style>

    <!-- verticle thumb slider -->
    <section id="verticalSlider">
        <div class="row">
            <div class="large-12 columns">
                <?php if(sizeof($featured_videos) > 0):?>
                <div class="thumb-slider">
                    <div class="main-image">
                        <?php foreach($featured_videos as $video):?>
                        <div class="image <?php echo $video->id; ?>">
                            <img src="<?php echo ImageHandler::getImage($video->image, '800x400'); ?>" alt="imaga">
                            <a href="<?php echo ($settings->enable_https) ? secure_url('video') : URL::to('video') . '/' . $video->id; ?>" class="hover-posts">
                                <span><i class="fa fa-play"></i><?php echo _i('Watch Video');?></span>
                            </a>

                        </div>
                        <?php endforeach;?>
                    </div>
                    <div class="thumbs">
                        <div class="thumbnails">
                            <?php foreach($featured_videos as $video):?>
                            <div class="ver-thumbnail" id="<?php echo $video->id; ?>">
                                <img src="<?php echo ImageHandler::getImage($video->image, '370x220')  ?>" alt="<?php echo $video->title; ?>">
                                <div class="item-title">
                                    <?php if(isset($video->category->name)):?>
                                    <span><?php echo $video->category->name; ?></span>
                                    <?php endif;?>
                                    <h6><?php echo $video->title; ?></h6>
                                </div>
                            </div>
                            <?php endforeach;?>
                        </div>
                        <a class="up" href="javascript:void(0)"><i class="fa fa-angle-up"></i></a>
                        <a class="down" href="javascript:void(0)"><i class="fa fa-angle-down"></i></a>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php endif;?>
            </div>
        </div>
    </section>
    <!-- Category -->
    <?php if(isset($video_categories) && sizeof($video_categories) && $number_videos_posted > 0):?>
    <section id="category" class="removeMargin whiteBg">
        <div class="row">
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
    <section class="mainContentv3">
        <div class="row">
            <!-- left side content area -->
            <div class="large-8 columns parentbg">
                <?php if($number_videos_posted > 0):?>
                <div class="sidebarBg"></div>
                <section class="content content-with-sidebar">
                    <!-- newest video -->
                    <div class="main-heading borderBottom">
                        <div class="row padding-14 ">
                            <div class="medium-8 small-8 columns">
                                <div class="head-title">
                                    <i class="fa fa-film"></i>
                                    <h4><?php echo _i('Newest Videos');?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="large-12 columns">
                            <div class="row column head-text clearfix">
                                <p class="pull-left"><?php echo _i('All Videos');?> : <span><?php echo $number_videos_posted;?> <?php echo _i('Videos posted');?></span></p>
                                <div class="grid-system pull-right show-for-large">
                                    <a class="secondary-button grid-default" href="#"><i class="fa fa-th"></i></a>
                                    <a class="secondary-button current grid-medium" href="#"><i class="fa fa-th-large"></i></a>
                                    <a class="secondary-button list" href="#"><i class="fa fa-th-list"></i></a>
                                </div>
                            </div>

                            <div class="tabs-content" data-tabs-content="newVideos">
                                <div class="tabs-panel is-active" id="new-all">
                                    <div class="row list-group">
                                        <?php echo View::make('Theme::partials.video-loop', ['videos' => $recent_videos, 'class' => "item large-4 medium-6 columns grid-medium"])->render();?>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center row-btn">
                                <a class="button radius" href="/videos"><?php echo _i('View All Video');?></a>
                            </div>
                        </div>
                    </div>
                </section>
                <?php echo Widget::run('adv-horizontal');?>

                <!-- popular video -->
                <section class="content content-with-sidebar">
                    <!-- popular Videos -->
                    <div class="main-heading borderBottom">
                        <div class="row padding-14">
                            <div class="medium-8 small-8 columns">
                                <div class="head-title">
                                    <i class="fa fa-star"></i>
                                    <h4><?php echo _i('Most Popular Videos');?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <?php if(sizeof($popular_videos)):?>
                        <div class="large-12 columns">
                            <div class="row column head-text clearfix">
                                <p class="pull-left"><?php echo _i('All Videos');?>: <span><?php echo $number_videos_posted;?> <?php echo _i('Videos posted');?></span></p>
                                <div class="grid-system pull-right show-for-large">
                                    <a class="secondary-button grid-default" href="#"><i class="fa fa-th"></i></a>
                                    <a class="secondary-button grid-medium" href="#"><i class="fa fa-th-large"></i></a>
                                    <a class="secondary-button current list" href="#"><i class="fa fa-th-list"></i></a>
                                </div>
                            </div>
                            <div class="tabs-content" data-tabs-content="popularVideos">
                                <div class="tabs-panel is-active" id="popular-all">
                                    <div class="row list-group">
                                        <?php echo View::make('Theme::partials.video-loop', ['videos' => $popular_videos, 'class' => "item large-4 medium-6 columns list"])->render();?>
                                    </div>
                                </div>
                            </div>
                            <div class="text-center row-btn">
                                <a class="button radius" href="/videos"><?php echo _i('View All Video');?></a>
                            </div>
                        </div>
                        <?php endif;?>
                    </div>
                    <?php echo Widget::run('adv-horizontal');?>
                </section><!-- End main content -->
                <?php else:?>
                    <h4><?php echo _i('No videos added yet.');?></h4>
                <?php endif;?>
            </div><!-- end left side content area -->
            <!-- sidebar -->
            <div class="large-4 columns">
                <aside class="sidebar">
                    <div class="sidebarBg"></div>
                    <?php include('includes/sidebar.php'); ?>
                </aside>
            </div><!-- end sidebar -->
        </div>
    </section>


			<?php //if(Auth::guest()): ?>
				<!--button class="btn btn-primary" onClick="window.location='/signup'" href="/signup"><?php echo \App\Libraries\ThemeHelper::getThemeSetting(@$theme_settings->home_button_text, 'Become a Member') ?></button-->
			<?php //else: ?>
				<!--button class="btn btn-primary" onClick="window.location='/videos'" href="/videos"><?php echo \App\Libraries\ThemeHelper::getThemeSetting(@$theme_settings->home_button_text_logged_in, 'Start Watching Videos Now') ?></button-->
			<?php // endif; ?>



<?php  include('includes/footer.php'); ?>