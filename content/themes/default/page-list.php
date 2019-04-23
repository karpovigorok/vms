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
                <div class="main-heading removeMargin">
                    <div class="row secBg padding-14 removeBorderBottom">
                        <div class="medium-8 small-8 columns">
                            <div class="head-title">
                                <i class="fa fa-book"></i>
                                <?php if (isset($page_title)): ?>
                                    <h4><?php echo $page_title ?> <?php if (isset($page_description)): ?>
                                            <span><?php echo $page_description ?></span><?php endif; ?></h4>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <?php foreach($pages as $page): ?>

                    <div class="blog-post">
                        <div class="row secBg">
                            <div class="large-12 columns">
                                <div class="blog-post-heading">
                                    <h3>
                                        <a href="<?php echo ($settings->enable_https) ? secure_url('page') : URL::to('page') ?><?php echo '/' . $page->slug ?>"><?php echo $page->title; ?></a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php echo Widget::run('adv-horizontal'); ?>
                </section>
            </div><!-- end left side content area -->

        <div class="large-4 columns">
            <aside class="secBg sidebar">
                <?php include('includes/sidebar.php'); ?>
            </aside>
        </div><!-- end sidebar -->
    </div>
</section>
<?php include('includes/footer.php'); ?>
