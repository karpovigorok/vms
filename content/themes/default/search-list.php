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
    <section class="category-content">
        <div class="row">
            <!-- left side content area -->
            <div class="large-8 columns">
                <section class="content content-with-sidebar">
                    <!-- newest video -->
                    <div class="main-heading removeMargin">
                        <div class="row secBg padding-14 removeBorderBottom">
                            <div class="medium-8 small-12 columns">
                                <div class="head-title">
                                    <i class="fa fa-search"></i>
                                    <h4><?php echo _i('Search Results for “%s”', $search_value); ?></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php// dd();?>

                    <div class="row secBg">
                        <div class="large-12 columns">
                            <?php if($videos->count() > 0):?>
                            <div class="row column head-text clearfix">
                                <p class="pull-left"><?php echo _i('Search Results: <span>%s</span> matching', $videos->count()); ?></p>
                                <div class="grid-system pull-right show-for-large">
                                    <a class="secondary-button grid-default" href="#"><i class="fa fa-th"></i></a>
                                    <a class="secondary-button grid-medium" href="#"><i class="fa fa-th-large"></i></a>
                                    <a class="secondary-button current list" href="#"><i class="fa fa-th-list"></i></a>
                                </div>
                            </div>
                            <?php endif;?>
                            <div class="tabs-content" data-tabs-content="newVideos">
                                <div class="tabs-panel is-active" id="new-all">
                                    <div class="row list-group">
                                        <?php if ($videos->count() < 1): ?>
                                            <h4 class="text-center"><?php echo _i('No Video Search results found for %s', $search_value); ?></h4>
                                        <?php else: ?>
                                            <?php echo View::make('Theme::partials.video-loop', ['videos' => $videos, 'class' => "item large-4 medium-6 columns list"])->render(); ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            <div class="container search-results">
                                <?php if ($posts->count() < 1): ?>
                                    <h4 class="text-center"><?php echo _i('No Post Search results found for %s', $search_value); ?></h4>
                                <?php else: ?>
                                    <h3><?php echo _i('Post Search Results <span>for %s</span>', $search_value); ?></h3>
                                    <div class="row">
                                        <?php include('partials/post-loop.php'); ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </section>
                <?php echo Widget::run('adv-horizontal'); ?>
            </div><!-- end left side content area -->
            <!-- sidebar -->
            <div class="large-4 columns">
                <aside class="secBg sidebar">
                    <?php include('includes/sidebar.php'); ?>
                </aside>
            </div><!-- end sidebar -->
        </div>
    </section><!-- End Category Content-->

<?php include('includes/footer.php'); ?>