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
    <style>
        level {
            background: #4BB543;
        }
    </style>
    <section class="category-content">
        <div class="row">
            <!-- left side content area -->
            <div class="large-8 columns">
                <section class="content content-with-sidebar">
                    <!-- newest video -->
                    <div class="main-heading removeMargin">
                        <div class="row secBg padding-14 removeBorderBottom">
                            <div class="medium-8 small-8 columns">
                                <div class="head-title">
                                    <i class="fa fa-film"></i>
                                    <?php if (isset($page_title)): ?>
                                        <h4><?php echo $page_title ?> <?php if (isset($page_description)): ?>
                                                <span><?php echo $page_description ?></span><?php endif; ?></h4>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row secBg">
                        <div class="large-12 columns">
                            <?php if(sizeof($videos) > 0):?>
                            <div class="row column head-text clearfix">
                                <div class="grid-system pull-right show-for-large">
                                    <a class="secondary-button grid-default" href="#"><i class="fa fa-th"></i></a>
                                    <a class="secondary-button current grid-medium" href="#"><i
                                            class="fa fa-th-large"></i></a>
                                    <a class="secondary-button list" href="#"><i class="fa fa-th-list"></i></a>
                                </div>
                            </div>
                            <div class="tabs-content" data-tabs-content="newVideos">
                                <div class="tabs-panel is-active" id="new-all">
                                    <div class="row list-group">
                                        <?php echo View::make('Theme::partials.video-loop', ['videos' => $videos, 'class' => "item large-4 medium-6 columns grid-medium"])->render();?>
                                    </div>
                                </div>
                            </div>
                            <div class="clear"></div>
                            <div class="pagination"><?php echo $videos->appends(Request::only('s'))->render(); ?></div>
                            <?php else:?>
                                <h4><?php echo _i('No videos added yet.');?></h4>
                            <?php endif; ?>
                        </div>
                    </div>
                </section>
                <?php echo Widget::run('adv-horizontal'); ?>
            </div>
            <!-- end left side content area -->
            <!-- sidebar -->
            <div class="large-4 columns">
                <aside class="secBg sidebar">
                    <div class="row">

                        <div class="large-12 medium-7 medium-centered columns">
                            <?php echo Widget::run('search'); ?>
                        </div>
                        <div class="large-12 medium-7 medium-centered columns">
                            <?php echo Widget::run('socialFans'); ?>
                        </div>
                        <div class="large-12 medium-7 medium-centered columns">
                            <?php echo Widget::run('slideVideos', ['excluded_video_ids' => isset($excluded_video_ids)?$excluded_video_ids:[]]); ?>
                        </div>
                        <div class="large-12 medium-7 medium-centered columns">
                            <?php echo Widget::run('videoCategoriesList'); ?>
                        </div>
                        <div class="large-12 medium-7 medium-centered columns">
                            <?php echo Widget::run('adv'); ?>
                        </div>
                        <div class="large-12 medium-7 medium-centered columns">
                            <?php echo Widget::run('recentComments'); ?>
                        </div>
                        <div class="large-12 medium-7 medium-centered columns">
                            <?php echo Widget::run('tagsCloud'); ?>
                        </div>
                        <div class="large-12 medium-7 medium-centered columns">
                            <?php echo Widget::run('newsletter'); ?>
                        </div>
                    </div>
                </aside>
            </div>
            <!-- end sidebar -->
        </div>
    </section><!-- End Category Content-->
<?php include('includes/footer.php'); ?>