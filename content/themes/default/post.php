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
include('includes/header.php');
//echo Breadcrumbs::render('home');
?>
    <div class="row">
        <div class="large-8 columns">
            <div class="blog-post">
                <div class="row secBg">
                    <div class="large-12 columns">
                        <div class="blog-post-heading">
                            <h3><?php echo $post->title ?></h3>
                            <p>
                                <span><i class="fa fa-clock-o"></i><?php echo TimeHelper::time_elapsed_string($post->created_at); ?></span>
                                <?php if($enable_post_comments && $post->totalCommentCount() > 0):?>
                                <span><i class="fa fa-commenting"></i><?php echo $post->totalCommentCount();?></span>
                                <?php endif;?>
                            </p>
                        </div>
                        <div class="blog-post-content">
                        <?php if ($post->access == 'guest' ||
                        (($post->access == 'subscriber' || $post->access == 'registered') && !Auth::guest() && Auth::user()->subscribed('main')) ||
                        (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) ||
                        (!Auth::guest() && $post->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered')): ?>
                            <?php if($post->image != ''):?>
                            <div class="blog-post-img">
                                <img src="<?php echo ImageHandler::getImage($post->image); ?>"
                                     width="770" height="370"/>
                            </div>
                            <?php endif;?>
                            <?php echo $post->body ?>
                        <?php else:?>
                            <div id="subscribers_only" class="margin-bottom-10">
                                <?php if (!Auth::guest() && $post->access == 'subscriber'): ?>
                                    <form method="get" action="/user/<?php echo Auth::user()->username ?>/upgrade_subscription">
                                        <button id="button" class="button radius"><?php echo _i('Become a subscriber to read this post');?></button>
                                    </form>
                                <?php else: ?>
                                    <form method="get" action="/signup">
                                        <button id="button" class="button radius"><?php echo _i('Signup Now');?>
                                            <?php if ($post->access == 'subscriber'): echo _i('to Become a Subscriber'); elseif ($post->access == 'registered'): echo _i('for Free!'); endif; ?></button>
                                    </form>
                                <?php endif; ?>
                                <div class="clear"></div>
                                <h2 class=""><?php echo _i('Sorry, this post is only available to ');
                                    if ($post->access == 'subscriber'): echo _i('Subscribers'); elseif ($post->access == 'registered'): echo _i('Registered Users'); endif; ?></h2>
                            </div>
                        <?php endif;?>
                            <div class="blog-post-extras">
                                <?php if (isset($post->category->name)): ?>
                                    <div class="categories extras">
                                        <button><i class="fa fa-folder"></i><?php echo _i('Category');?></button>
                                        <a href="<?php echo ($settings->enable_https) ? secure_url('posts/category') : URL::to('posts/category'); ?><?php echo '/' . $post->category->slug; ?>"
                                           class="inner-btn"><?php echo $post->category->name; ?></a>
                                    </div>
                                <?php endif; ?>

                                <div class="social-share extras">
                                    <div class="post-like-btn clearfix">
                                        <div class="easy-share" data-easyshare data-easyshare-http
                                             data-easyshare-url="<?php echo ($settings->enable_https) ? secure_url('post/' . $post->slug) : URL::to('post/' . $post->slug); ?>">

                                            <button class="float-left"><i class="fa fa-share-alt"></i>share</button>
                                            <!-- Facebook -->
                                            <button class="removeBorder" data-easyshare-button="facebook">
                                                <span class="fa fa-facebook"></span>
                                            </button>

                                            <!-- Twitter -->
                                            <button class="removeBorder" data-easyshare-button="twitter"
                                                    data-easyshare-tweet-text="">
                                                <span class="fa fa-twitter"></span>
                                            </button>
                                            <div data-easyshare-loader><?php echo _i('Loading...');?></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div><!-- end blog post -->

            <?php if ($enable_post_comments): ?>
            <?php echo AsyncWidget::run('comments', [
                'type' => 'post',
                'article_id' => $post->id,
                'sort_order' => 'newest']);?>
            <?php endif; ?>
            <?php echo Widget::run('adv-horizontal'); ?>
        </div>
        <div class="large-4 columns">
            <aside class="secBg sidebar">
                <?php include('includes/sidebar.php'); ?>
            </aside>
        </div><!-- end sidebar -->
    </div>
<?php if (Auth::check()): ?>
    <div class="media-object stack-for-small" style="display: none;" id="comment-template">
        <div class="media-object-section comment-img text-center">
            <div class="comment-box-img">
                <img width="80"
                     src="<?php echo Config::get('site.uploads_url') . 'avatars/' . Auth::user()->avatar ?>"/>
            </div>
        </div>
        <div class="media-object-section comment-desc">
            <div class="comment-title">
                <span class="name"><a
                            href="/user/<?php echo Auth::user()->username; ?>"><?php echo Auth::user()->username; ?></a> Said:</span>
                <span class="time float-right"><i class="fa fa-clock-o"></i> Just Now</span>
            </div>
            <div class="comment-text">
                <p id="comment-comment"></p>
            </div>
            <div class="comment-btns">
                <span><a href="#"><i class="fa fa-thumbs-o-up"></i></a> | <a href="#"><i
                                class="fa fa-thumbs-o-down"></i></a></span>
                <span><a href="#"><i class="fa fa-share"></i>Reply</a></span>
                <span class='reply float-right hide-reply'></span>
            </div>

        </div>
    </div>
<?php endif; ?>

<?php include('includes/footer.php'); ?>