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
 * Date: 27.08.18
 * Time: 21:55
 *
 * @widget_type: CUSTOM
 * @widget_description: This widgets is allow you to show comments
 */

?>
<!-- Comments -->
<section class="content comments">
    <div class="row secBg">
        <div class="large-12 columns">
            <div class="main-heading borderBottom">
                <div class="row padding-14">
                    <div class="medium-12 small-12 columns">
                        <div class="head-title">
                            <i class="fa fa-comments"></i>
                            <h4><?php echo _i('Comments'); ?>
                                <span><?php if ($article->totalCommentCount() > 0): ?>(<?php echo $article->totalCommentCount(); ?>)<?php endif; ?></span>
                            </h4>
                        </div>
                    </div>
                </div>
            </div>

            <?php if (Auth::check()): ?>
                <div class="comment-box thumb-border">
                    <div class="media-object stack-for-small">
                        <div class="media-object-section comment-img text-center">
                            <div class="comment-box-img">
                                <img width="80"
                                     src="<?php echo (Auth::User()->avatar == ''?THEME_URL . '/assets/images/avatar-80x80.png':Auth::User()->avatar); ?>"/>
                            </div>
                            <h6>
                                <a href="/user/<?php echo Auth::user()->username; ?>"><?php echo Auth::user()->username; ?></a>
                            </h6>
                        </div>
                        <div class="media-object-section comment-textarea">
                            <form method="post" action="<?php echo url('/comment'); ?>"
                                  id="add-comment-form">
                                                <textarea name="commentText" id="commentText"
                                                          placeholder="<?php echo _i('Add a comment here...'); ?>"></textarea>
                                <input type="submit" name="submit" id="submit-comment" value="Send">
                                <input type="hidden" name="_token" value="<?php echo csrf_token() ?>"/>
                                <input type="hidden" name="commented_type" value="<?php echo $commentable_type; ?>">
                                <input type="hidden" name="id" value="<?php echo $article->id; ?>">
                                <input type="hidden" name="parent_id" value="0">
                            </form>
                        </div>
                    </div>
                </div>
            <?php elseif (\App\Models\Setting::first()->enable_anonymous_comments): ?>
                <div class="comment-box thumb-border">
                    <div class="media-object stack-for-small">
                        <div class="media-object-section comment-img text-center">
                            <div class="comment-box-img">
                                <img width="80"
                                     src="<?php echo THEME_URL . '/assets/images/avatar.png'; ?>"/>
                            </div>
                        </div>
                        <div class="media-object-section comment-textarea">
                            <form method="post" action="<?php echo url('/comment'); ?>"
                                  id="add-comment-form">
                                <div class="input-group">
                                    <input class="input-group-field" type="text" name="commentUsername"
                                           placeholder="<?php echo _i('Enter your username'); ?>" required>
                                    <span class="form-error"><?php echo _i('Username is required'); ?></span>
                                </div>
                                                <textarea name="commentText" id="commentText"
                                                          placeholder="<?php echo _i('Add a comment here...'); ?>"></textarea>
                                <input type="submit" name="submit" id="submit-comment"
                                       value="<?php echo _i('Send'); ?>">
                                <input type="hidden" name="_token" value="<?php echo csrf_token() ?>"/>
                                <input type="hidden" name="commented_type" value="<?php echo $commentable_type;?>">
                                <input type="hidden" name="id" value="<?php echo $article->id; ?>">
                                <input type="hidden" name="parent_id" value="0">
                            </form>
                        </div>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center muted text-large">Please <a href="/login">login</a> for comments</div>
            <?php endif; ?>
            <?php if ($article->totalCommentCount() > 0): ?>
                <div class="comment-sort text-right">
                <span>
                    <?php echo _i('Sort By'); ?> :
                    <a href="#"
                       class="sort-comments active"
                       data-params="<?php echo encrypt(json_encode(array(["type" => $commentable_type, "article_id" => $article->id, "sort_order" => "newest"])));?>">
                        <?php echo _i('newest'); ?>
                    </a> |
                    <a href="#" class="sort-comments"
                       data-params="<?php echo encrypt(json_encode(array(["type" => $commentable_type, "article_id" => $article->id, "sort_order" => "popular"])));?>">
                        <?php echo _i('popular'); ?>
                    </a>
                </span>
                </div>
                <!-- main comment -->
                <div class="main-comment" id="comments-list">
                    <?php if ($comments->count() > 0): ?>
                        <?php foreach ($comments as $comment): ?>
                            <div class="media-object stack-for-small">
                                <div class="media-object-section comment-img text-center">
                                    <div class="comment-box-img">
                                        <?php if (!is_null($comment->anonymous_username)): ?>
                                            <img width="80"
                                                 src="<?php echo THEME_URL . '/assets/images/avatar-80x80.jpg'; ?>"/>
                                        <?php else: ?>
                                            <img width="80" src="<?php echo ($comment->user->avatar == ''?THEME_URL . '/assets/images/avatar-80x80.png':$comment->user->avatar); ?>"/>
                                        <?php endif; ?>
                                    </div>
                                </div>
                                <div class="media-object-section comment-desc">
                                    <div class="comment-title">
                                        <?php if (!is_null($comment->anonymous_username)): ?>
                                        <span class="name"><?php echo $comment->anonymous_username; ?> (anonymous)
                                            <?php else: ?>
                                            <span class="name"><a
                                                    href="/user/<?php echo $comment->user->username; ?>"><?php echo $comment->user->username; ?></a>
                                                <?php endif; ?>
                                                Said:</span>
                            <span class="time float-right"><i
                                    class="fa fa-clock-o"></i><?php echo TimeHelper::time_elapsed_string($comment->created_at); ?></span>
                                    </div>
                                    <div class="comment-text">
                                        <p><?php echo $comment->comment; ?></p>
                                    </div>

                                    <div class="comment-btns">
                            <span>
                                <a href="#" class="comment-thumbs-button"
                                   data-id="<?php echo $comment->id; ?>" data-url="/like"><i
                                        class="fa fa-thumbs-o-up"></i></a>
                                <span
                                    id="comment-likes-count-<?php echo $comment->id; ?>"><?php echo $comment->likesCount; ?></span> |
                                <a href="#" class="comment-thumbs-button"
                                   data-id="<?php echo $comment->id; ?>" data-url="/dislike"><i
                                        class="fa fa-thumbs-o-down"></i></a>
                                <span
                                    id="comment-dislikes-count-<?php echo $comment->id; ?>"><?php echo $comment->dislikesCount; ?></span>
                            </span>
                                    <span><a href="#" class="reply-comment" data-id="<?php echo $comment->id; ?>"><i
                                                class="fa fa-share"></i>Reply</a></span>
                                        <span class='reply float-right hide-reply'></span>
                                    </div>
                                    <?php foreach ($comment->replies()->get() as $reply_comment): ?>
                                        <!--sub comment-->
                                        <div class="media-object stack-for-small reply-comment">
                                            <div class="media-object-section comment-img text-center">
                                                <div class="comment-box-img">
                                                    <?php if (!is_null($reply_comment->anonymous_username)): ?>
                                                        <img width="80"
                                                             src="<?php echo THEME_URL . '/assets/images/avatar-80x80.png'; ?>"/>
                                                    <?php else: ?>
                                                        <img width="80"
                                                             src="<?php echo ($reply_comment->user->avatar == ''?THEME_URL . '/assets/images/avatar-80x80.png':$reply_comment->user->avatar); ?>"/>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                            <div class="media-object-section comment-desc">
                                                <div class="comment-title">
                                                    <?php if (!is_null($reply_comment->anonymous_username)): ?>
                                                    <span class="name"><?php echo $reply_comment->anonymous_username; ?>
                                                        (anonymous)
                                                        <?php else: ?>
                                                        <span class="name"><a
                                                                href="/user/<?php echo $reply_comment->user->username; ?>"><?php echo $reply_comment->user->username; ?></a>
                                                            <?php endif; ?>
                                                            Said:</span>
                                <span class="time float-right"><i class="fa fa-clock-o"></i>
                                    <?php echo TimeHelper::time_elapsed_string($reply_comment->created_at); ?></span>
                                                </div>
                                                <div class="comment-text">
                                                    <p><?php echo $reply_comment->comment; ?></p>
                                                </div>
                                                <div class="comment-btns">
                                                <span><a href="#"><i class="fa fa-thumbs-o-up"></i></a> | <a href="#"><i
                                                            class="fa fa-thumbs-o-down"></i></a></span>
                                                </div>
                                            </div>
                                        </div><!-- end sub comment -->
                                    <?php endforeach; ?>
                                    <?php if (Auth::check()): ?>
                                        <div class="comment-box subcomment-box" id="subcomment-form-<?php echo $comment->id; ?>" style="display: none;">
                                            <div class="media-object stack-for-small">
                                                <div class="media-object-section comment-img text-center">
                                                    <div class="comment-box-img">
                                                        <img width="80"
                                                             src="<?php echo (Auth::User()->avatar ==''?THEME_URL . '/assets/images/avatar-80x80.png':Auth::User()->avatar); ?>"/>
                                                    </div>
                                                    <h6>
                                                        <a href="/user/<?php echo Auth::user()->username; ?>"><?php echo Auth::user()->username; ?></a>
                                                    </h6>
                                                </div>

                                                <div class="media-object-section comment-textarea">
                                                    <form method="post" action="<?php echo url('/comment'); ?>"
                                                          id="add-comment-form">
                                                    <textarea name="commentText" id="commentText"
                                                              placeholder="<?php echo _i('Add a comment here...'); ?>"></textarea>
                                                        <input type="submit" name="submit" id="submit-comment"
                                                               value="Send">
                                                        <input type="hidden" name="_token"
                                                               value="<?php echo csrf_token() ?>"/>
                                                        <input type="hidden" name="commented_type" value="<?php echo $commentable_type;?>">
                                                        <input type="hidden" name="id"
                                                               value="<?php echo $article->id; ?>">
                                                        <input type="hidden" name="parent_id"
                                                               value="<?php echo $comment->id; ?>">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php elseif (\App\Models\Setting::first()->enable_anonymous_comments): ?>
                                        <div class="comment-box subcomment-box" id="subcomment-form-<?php echo $comment->id; ?>" style="display: none;">
                                            <div class="media-object stack-for-small">
                                                <div class="media-object-section comment-img text-center">
                                                    <div class="comment-box-img">
                                                        <img width="80"
                                                             src="<?php echo THEME_URL . '/assets/images/avatar-80x80.png'; ?>"/>
                                                    </div>
                                                </div>
                                                <div class="media-object-section comment-textarea col-md-12">
                                                    <form method="post" action="<?php echo url('/comment'); ?>"
                                                          id="add-comment-form" class="col-md-12">
                                                        <div class="input-group">
                                                            <input class="input-group-field" type="text"
                                                                   name="commentUsername"
                                                                   placeholder="<?php echo _i('Enter your username'); ?>"
                                                                   required>
                                                        <span
                                                            class="form-error"><?php echo _i('Username is required'); ?></span>
                                                        </div>
                                                    <textarea name="commentText" id="commentText"
                                                              placeholder="<?php echo _i('Add a comment here...'); ?>"></textarea>
                                                        <input type="submit" name="submit" id="submit-comment"
                                                               value="<?php echo _i('Send'); ?>">
                                                        <input type="hidden" name="_token"
                                                               value="<?php echo csrf_token() ?>"/>
                                                        <input type="hidden" name="commented_type" value="<?php echo $commentable_type;?>">
                                                        <input type="hidden" name="id"
                                                               value="<?php echo $article->id; ?>">
                                                        <input type="hidden" name="parent_id"
                                                               value="<?php echo $comment->id; ?>">
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="text-center muted text-large">
                                            <?php echo _i('Please');?> <a href="/login"><?php echo _i('login');?></a> <?php echo _i('for comments');?>
                                        </div>
                                    <?php endif; ?>
                                </div>

                            </div>
                        <?php endforeach; ?>
                        <div class="pagination"><?php echo $comments->render(); ?></div>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>
</section><!-- End Comments -->


<script>

    $(document).ready(function () {

        $(window).scroll(function() {
            if($(window).scrollTop() == $(document).height() - $(window).height()) {
                // ajax call get data from server and append to the div
                //alert(123);
            }
        });

        var options = {
//            target:        '#output1',   // target element(s) to be updated with server response
            beforeSubmit: validateCommentForm,  // pre-submit callback
            success: processResponse,  // post-submit callback

            // other available options:
            //url:       url         // override for form's 'action' attribute
            //type:      type        // 'get' or 'post', override for form's 'method' attribute
            //dataType:  null        // 'xml', 'script', or 'json' (expected server response type)
            clearForm: true,        // clear all form fields after successful submit
            resetForm: true        // reset the form after successful submit

            // $.ajax options can be used here too, for example:
            //timeout:   3000
        };

        // bind form using 'ajaxForm'
        // bind to the form's submit event
        $('#add-comment-form').submit(function () {
            // inside event callbacks 'this' is the DOM element so we first
            // wrap it in a jQuery object and then invoke ajaxSubmit
            $(this).ajaxSubmit(options);
            // !!! Important !!!
            // always return false to prevent standard browser submit and page navigation
            return false;
        });

        $(".comment-thumbs-button").click(function () {
            var clicked_object = $(this);
            $.ajax({
                type: "POST",
                url: clicked_object.data("url"),
                //context: this,
                data: {
                    "article_id": $(this).data("id"),
                    "article_type": "App\\Models\\Comment",
                    "_token": "<?php echo csrf_token() ?>"
                },
                success: function (data) {
                    clicked_object.toggleClass("active");
                    $("#comment-likes-count-" + data.id).text(data.likesCount);
                    $("#comment-dislikes-count-" + data.id).text(data.dislikesCount);
                }
            });
            return false;
        });


        $(".sort-comments").click(function() {
            $.ajax({
                type: "GET",
                url: '/arrilot/load-widget',
                //context: this,
                data: {
                    "id": 2,
                    "name": "Comments",
                    "params": $(this).data("params"),
                    "_token": "<?php echo csrf_token() ?>"
                },
                success: function (data) {
                    $(".comments-widget-container").html(data);
                }
            });
            return false;
        });

    });
    function validateCommentForm(formData, jqForm, options) {
        //if($("#commentText").val().length <= 5 ) return false;
    }
    function processResponse(responseText, statusText, xhr, $form) {
        $.ajax({
            type: "GET",
            url: '/arrilot/load-widget',
            data: {
                "id": 2,
                "name": "Comments",
                "params": "<?php echo encrypt(json_encode(array(["type" => $commentable_type, "article_id" => $article->id, "sort_order" => "newest"])));?>",
                "_token": "<?php echo csrf_token() ?>"
            },
            success: function (data) {
                $(".comments-widget-container").html(data);
            }
        });
    }

    $('ul#pagination > li > a').click(function() {
        $.ajax({
            type: "GET",
            url: '/arrilot/load-widget',
            //context: this,
            data: {
                "id": 2,
                "page": $(this).data('page'),
                "name": "Comments",
                "params": "<?php echo encrypt(json_encode(array(["type" => $commentable_type, "article_id" => $article->id, "sort_order" => $sort_order])));?>",
                "_token": "<?php echo csrf_token() ?>"
            },
            success: function (data) {
                $(".comments-widget-container").html(data);
            }
        });
        return false;
    });


    $(".reply-comment").click(function () {
        var clicked_object = $(this);
        $(".subcomment-box").hide();
        $("#subcomment-form-" + clicked_object.data("id")).show();
        return false;
    });
</script>
<!-- End main comment -->