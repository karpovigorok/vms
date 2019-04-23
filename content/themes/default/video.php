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
?>
    <div class="row">
        <!-- left side content area -->
        <div class="large-8 columns">
            <!--single inner video-->
            <section class="inner-video">
                <div class="row secBg">
                    <?php
                    $site_video_dimensions = Config::get('site.video.dimensions');
                    $site_video_convert_enabled = Config::get('site.video.convert');

                    if ($video->access == 'guest' ||
                        (($video->access == 'subscriber' || $video->access == 'registered') && !Auth::guest() && Auth::user()->subscribed('main')) ||
                        (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) ||
                        (!Auth::guest() && $video->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered')
                    ): ?>
                        <div class="large-12 columns inner-flex-video">
                            <div class="flex-video widescreen">

                                <?php if ($video->type == 'embed'): ?>
                                    <?php echo $video->embed_code ?>
                                <?php elseif (sizeof($site_video_dimensions) && $site_video_convert_enabled):

                                    ?>
                                    <video id="video_vms" class="video-js vjs-default-skin vjs-big-play-centered"
                                           controls data-setup='{}' preload="auto"
                                           poster="<?php echo ImageHandler::getImage($video->image, '800x400') ?>"
                                           width="100%" style="width:100%;" height="454">
                                        <?php
                                        $k = 0;
                                        foreach ($site_video_dimensions as $key_video_dimension => $video_dimension):?>
                                            <?php if ($video->max_height >= $video_dimension['height']): ?>
                                                <source
                                                    src="<?php echo Config::get('site.uploads_dir') . "/video/" . $video->path . $key_video_dimension . basename($video->original_name) . ".mp4"; ?>"
                                                    label='<?php echo _i($key_video_dimension) ?>'
                                                    res="<?php echo $video_dimension['height'] ?>"
                                                    type='<?php echo $video->mime_type; ?>' <?php echo($k++ == 0 ? 'selected="true"' : ''); ?>>
                                            <?php endif;?>
                                        <?php endforeach; ?>
                                        <p class="vjs-no-js"><?php echo _i("To view this video please enable JavaScript, and consider upgrading to a web browser that <a href='%s' target='_blank'>supports HTML5 video</a>", "http://videojs.com/html5-video-support/");?></p>
                                    </video>
                                <?php elseif (!$site_video_convert_enabled): ?>
                                    <video id="video_vms" class="video-js vjs-default-skin vjs-big-play-centered"
                                           controls data-setup='{}' preload="auto"
                                           poster="<?php echo ImageHandler::getImage($video->image, '800x400') ?>"
                                           width="100%" style="width:100%;" height="454">
                                        <source
                                            src="<?php echo Config::get('site.uploads_dir') . "/video/" . $video->path . $video->original_name; ?>"
                                            type='<?php echo $video->mime_type; ?>'>
                                        <p class="vjs-no-js"><?php echo _i("To view this video please enable JavaScript, and consider upgrading to a web browser that <a href='%s' target='_blank'>supports HTML5 video</a>", "http://videojs.com/html5-video-support/"); ?></p>
                                    </video>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php else: ?>
                        <div id="subscribers_only">
                            <?php if (!Auth::guest() && $video->access == 'subscriber'): ?>
                                <form method="get"
                                      action="/user/<?php echo Auth::user()->username ?>/upgrade_subscription">
                                    <button id="button"
                                            class="button radius"><?php echo _i('Become a subscriber to watch this video'); ?></button>
                                </form>
                            <?php else: ?>
                                <form method="get" action="/signup">
                                    <button id="button" class="button radius"><?php echo _i('Signup Now'); ?>
                                        <?php if ($video->access == 'subscriber'): echo _i('to Become a Subscriber');
                                        elseif ($video->access == 'registered'): echo _i('for Free!'); endif; ?></button>
                                </form>
                            <?php endif; ?>
                            <div class="clear"></div>
                            <h2 class=""><?php echo _i('Sorry, this video is only available to ');
                                if ($video->access == 'subscriber'): echo _i('Subscribers');
                                elseif ($video->access == 'registered'): echo _i('Registered Users'); endif; ?></h2>
                        </div>
                    <?php endif; ?>
                </div>
            </section>
            <?php echo Widget::run('adv-horizontal'); ?>
            <!-- single post stats -->
            <section class="SinglePostStats">
                <!-- newest video -->
                <div class="row secBg">
                    <div class="large-12 columns">
                        <div class="media-object stack-for-small">
                            <div class="author-des clearfix">
                                <div class="post-title">
                                    <h4><?php echo $video->title ?></h4>
                                    <p>
                                        <span><i class="fa fa-clock-o"></i><?php echo strftime("%e %B, %Y", strtotime($video->created_at)); ?></span>
                                        <span><i class="fa fa-eye"></i><?php echo $video->views . ' ' . _n('view', 'views', $video->views); ?></span>
                                            <span><i class="fa fa-thumbs-o-up"></i><span
                                                    id="likes-count"><?php echo $video->likesCount; ?></span></span>
                                            <span><i class="fa fa-thumbs-o-down"></i><span
                                                    id="dislikes-count"><?php echo $video->dislikesCount; ?></span></span>
                                        <?php if ($enable_video_comments && $video->totalCommentCount() > 0): ?>
                                            <span><i
                                                    class="fa fa-commenting"></i><?php echo $video->totalCommentCount(); ?></span>
                                        <?php endif; ?>
                                    </p>
                                </div>
                                <!--div class="subscribe">
                                        <form method="post">
                                            <button type="submit" name="subscribe"><?php echo _i('Subscribe'); ?></button>
                                        </form>
                                    </div-->
                            </div>
                            <div class="social-share">
                                <div class="post-like-btn clearfix">
                                    <a href="#"
                                       class="secondary-button thumbs-button <?php if (Auth::check()): echo $video->isLikedBy() ? 'active' : ''; endif; ?>"
                                       data-url="/like"><i class="fa fa-thumbs-o-up"></i></a>
                                    <a href="#"
                                       class="secondary-button thumbs-button <?php if (Auth::check()): echo $video->undislikeBy() ? 'active' : ''; endif; ?>"
                                       data-url="/dislike"><i class="fa fa-thumbs-o-down"></i></a>

                                    <form method="post" action="/favorite" id="favorite-form">
                                        <?php if ($favorited): ?>
                                            <button type="submit" name="fav" id="favorite-button" class="active"><i
                                                    class="fa fa-heart"></i><?php echo _i('Favorited'); ?>
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" name="fav" id="favorite-button"><i
                                                    class="fa fa-heart"></i><?php echo _i('Add to'); ?>
                                            </button>
                                        <?php endif; ?>
                                        <input type="hidden" name="video_id" id="video_id"
                                               value="<?php echo $video->id; ?>">
                                        <input type="hidden" name="_token" value="<?php echo csrf_token() ?>">
                                        <input type="hidden" name="authenticated" id="authenticated"
                                               value="<?php echo intval(Auth::check()); ?>">
                                    </form>
                                    <!--form>
                                            <button type="button" name="fav" id="embed-code-button"><i
                                                    class="fa fa-code"></i><?php echo _i('Embed'); ?>
                                            </button>
                                        </form-->
                                    <div class="float-right easyo-share" data-easyshare data-easyshare-http
                                         data-easyshare-url="<?php echo ($settings->enable_https) ? secure_url('video/' . $video->id) : URL::to('video/' . $video->id); ?>">
                                        <!-- Facebook -->
                                        <button data-easyshare-button="facebook">
                                            <span class="fa fa-facebook"></span>
                                            <span>Share</span>
                                        </button>
                                        <span data-easyshare-button-count="facebook">0</span>

                                        <!-- Twitter -->
                                        <button data-easyshare-button="twitter" data-easyshare-tweet-text="">
                                            <span class="fa fa-twitter"></span>
                                            <span>Tweet</span>
                                        </button>

                                        <div data-easyshare-loader><?php echo _i('Loading...'); ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End single post stats -->
            <!-- single post description -->
            <section class="singlePostDescription">
                <div class="row secBg">
                    <div class="large-12 columns margin-bottom-10">
                        <div class="heading">
                            <h5><?php echo _i('Description'); ?></h5>
                        </div>
                        <div class="description">
                            <p>
                                <?php echo $video->description; ?>
                            </p>
                            <?php if (isset($video->category->name)): ?>
                                <div class="categories">
                                    <button><i class="fa fa-folder"></i><?php echo _i('Category'); ?></button>
                                    <a href="<?php echo ($settings->enable_https) ? secure_url('videos/category') : URL::to('videos/category'); ?><?php echo '/' . $video->category->slug; ?>"
                                       class="inner-btn"><?php echo $video->category->name; ?></a>
                                </div>
                            <?php endif; ?>
                            <?php if ($video->tags->count() > 0): ?>
                                <div class="tags">
                                    <button><i class="fa fa-tags"></i><?php echo _i('Tags'); ?></button>
                                    <?php foreach ($video->tags as $tag): ?>
                                        <a href="/videos/tag/<?php echo $tag->name; ?>"
                                           class="inner-btn"><?php echo $tag->name; ?></a>
                                    <?php endforeach; ?>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </section>
            <!-- End single post description -->

            <?php if (sizeof($related_videos) > 0): ?>
                <!-- related Posts -->
                <section class="content content-with-sidebar related">
                    <div class="row secBg">
                        <div class="large-12 columns">
                            <div class="main-heading borderBottom">
                                <div class="row padding-14">
                                    <div class="medium-12 small-12 columns">
                                        <div class="head-title">
                                            <i class="fa fa-film"></i>
                                            <h4><?php echo _i('Related Videos'); ?></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row list-group">
                                <?php //foreach($related_videos as $related_video):
                                $num_video_loop = sizeof($related_videos) >= 6 ? 6 : 3;
                                for ($i = 0; $i < $num_video_loop; $i++):
                                    $related_video = isset($related_videos[$i]) ? $related_videos[$i] : false;
                                    if ($related_video):
                                        ?>
                                        <div class="item large-4 columns end group-item-grid-default">
                                            <div class="post thumb-border">
                                                <div class="post-thumb">
                                                    <img
                                                        src="<?php echo ImageHandler::getImage($related_video->image, "370x220"); ?>"
                                                        alt="<?php echo htmlspecialchars($related_video->title); ?>">
                                                    <a href="<?php echo ($settings->enable_https) ? secure_url('video') : URL::to('video') ?><?php echo '/' . $related_video->id ?>"
                                                       class="hover-posts">
                                                        <span><i class="fa fa-play"></i><?php echo _i('Watch Video');?></span>
                                                    </a>

                                                    <div class="video-stats clearfix">
                                                        <?php if ($related_video->max_height >= 720): ?>
                                                            <div class="thumb-stats pull-left">
                                                                <h6><?php echo _i('HD'); ?></h6>
                                                            </div>
                                                        <?php endif;?>
                                                        <?php if ($related_video->favorite()->count() > 0): ?>
                                                            <div class="thumb-stats pull-left">
                                                                <i class="fa fa-heart"></i>
                                                                <span><?php echo $related_video->favorite()->count(); ?></span>
                                                            </div>
                                                        <?php endif; ?>
                                                        <?php if ($related_video->duration > 0): ?>
                                                            <div class="thumb-stats pull-right">
                                                                <span><?php echo TimeHelper::convert_seconds_to_HMS($related_video->duration); ?></span>
                                                            </div>
                                                        <?php endif;?>
                                                    </div>
                                                </div>
                                                <div class="post-des">
                                                    <h6>
                                                        <a href="<?php echo ($settings->enable_https) ? secure_url('video') : URL::to('video') ?><?php echo '/' . $related_video->id ?>">
                                                            <?php echo $related_video->title; ?>
                                                        </a></h6>

                                                    <div class="post-stats clearfix">
                                                        <?php if ($related_video->views > 0): ?>
                                                            <p class="pull-left">
                                                                <i class="fa fa-eye"></i>
                                                                <span><?php echo $related_video->views . ' ' . _n('view', 'views', $related_video->views); ?></span>
                                                            </p>
                                                        <?php endif; ?>
                                                    </div>
                                                    <div class="post-summary">
                                                        <p><?php echo mb_substr(strip_tags($related_video->description), 0, 90); ?></p>
                                                    </div>
                                                    <div class="post-button">
                                                        <a href="<?php echo ($settings->enable_https) ? secure_url('video') : URL::to('video') ?><?php echo '/' . $related_video->id ?>"
                                                           class="secondary-button"><i
                                                                class="fa fa-play-circle"></i><?php echo _i('watch video');?>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?php endif; ?>
                                <?php endfor; ?>
                            </div>
                        </div>
                    </div>
                </section><!--end related posts-->
            <?php endif; ?>
            <?php
            if ($enable_video_comments):
                echo AsyncWidget::run('comments', [
                    'type' => 'video',
                    'article_id' => $video->id,
                    'sort_order' => 'newest']);
            endif; ?>
        </div>
        <!-- end left side content area -->
        <!-- sidebar -->
        <div class="large-4 columns">
            <aside class="secBg sidebar">
                <?php include('includes/sidebar.php'); ?>
            </aside>
        </div>
        <!-- end sidebar -->
    </div>
    <script src="http://malsup.github.com/jquery.form.js"></script>
    <script src="https://kmoskwiak.github.io/videojs-resolution-switcher/node_modules/video.js/dist/video.js"></script>
    <script
        src="<?php echo THEME_URL . '/assets/js/video-js/plugins/videojs-resolution-switcher/videojs-resolution-switcher.js'; ?>"></script>
    <script>
        <?php if (($video->access == 'guest' ||
                        (($video->access == 'subscriber' || $video->access == 'registered') && !Auth::guest() && Auth::user()->subscribed('main')) ||
                        (!Auth::guest() && (Auth::user()->role == 'demo' || Auth::user()->role == 'admin')) ||
                        (!Auth::guest() && $video->access == 'registered' && $settings->free_registration && Auth::user()->role == 'registered')) &&
                        ($video->type != 'embed')                      ): ?>
        videojs('video_vms').videoJsResolutionSwitcher({default: 'high'});
        <?php endif;?>
        $(document).ready(function () {
            $("#favorite-form").submit(function () {
                if ($('#authenticated').val() == 1) {
                    $(this).ajaxSubmit();
                    $('#favorite-button').toggleClass('active');
                    return false;
                } else {
                    window.location = '/signup';
                }
            });
            $(".thumbs-button").click(function () {
                var clicked_object = $(this);
                $.ajax({
                    type: "POST",
                    url: $(this).data("url"),
                    data: {
                        "article_id": $("#video_id").val(),
                        "article_type": "App\\Models\\Video",
                        "_token": "<?php echo csrf_token() ?>"
                    },
                    success: function (data) {
                        if (clicked_object.hasClass("active")) {
                            $(".thumbs-button").removeClass("active");
                        }
                        else {
                            $(".thumbs-button").removeClass("active");
                            clicked_object.addClass("active");
                        }
                        $("#likes-count").text(data.likesCount);
                        $("#dislikes-count").text(data.dislikesCount);
                    }
//                    ,
//                    error: function(data) {
//                        alert(123);
//                    }
                });
                return false;
            });
        });
    </script>
<?php include('includes/footer.php'); ?>