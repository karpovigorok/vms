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
                <?php foreach ($posts as $post): ?>
                    <?php $post_description = preg_replace('/^\s+|\n|\r|\s+$/m', '', strip_tags($post->body)); ?>
                    <div class="blog-post">
                        <div class="row secBg">
                            <div class="large-12 columns">
                                <div class="blog-post-heading">
                                    <h3>
                                        <a href="<?php echo ($settings->enable_https) ? secure_url('post') : URL::to('post') ?><?php echo '/' . $post->slug ?>"><?php echo $post->title; ?></a>
                                    </h3>
                                    <p>
                                        <span><i class="fa fa-clock-o"></i><?php echo TimeHelper::time_elapsed_string($post->created_at); ?></span>
                                        <?php if ($enable_post_comments && $post->totalCommentCount() > 0): ?>
                                            <span><i class="fa fa-commenting"></i><?php echo $post->totalCommentCount(); ?></span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <div class="blog-post-content">
                                    <?php if($post->image != ''):?>
                                    <div class="blog-post-img">
                                        <img src="<?php echo ImageHandler::getImage($post->image) ?>"
                                             width="770" height="370" alt="blog image">
                                    </div>
                                    <?php endif;?>
                                    <p><?php if (strlen($post_description) > 90) {
                                            echo mb_substr($post_description, 0, 90) . '...';
                                        } else {
                                            echo $post->description;
                                        } ?></p>
                                    <a href="<?php echo ($settings->enable_https) ? secure_url('post') : URL::to('post') ?><?php echo '/' . $post->slug ?>"
                                       class="blog-post-btn" href="blog-single-post.html">read me</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
                <?php echo $posts->render(); ?>
                <?php echo Widget::run('adv-horizontal'); ?>
            </div><!-- end left side content area -->
            <div class="large-4 columns">
                <aside class="secBg sidebar">
                    <?php include('includes/sidebar.php'); ?>
                </aside>
            </div><!-- end sidebar -->
        </div>
    </section>
<?php include('includes/footer.php'); ?>