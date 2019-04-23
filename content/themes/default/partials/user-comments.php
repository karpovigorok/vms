<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<div class="large-8 columns profile-inner">
    <!-- Comments -->
    <section class="content comments">
        <div class="row secBg">
            <div class="large-12 columns">
                <div class="main-heading borderBottom">
                    <div class="row padding-14">
                        <div class="medium-12 small-12 columns">
                            <div class="head-title">
                                <i class="fa fa-comments"></i>
                                <h4><?php echo _i('Comments');?> <span>(<?php echo $comments->count();?>)</span></h4>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="comment-sort text-right">
                    <span><?php echo _i('Sort By:');?> <a href="#"><?php echo _i('newest');?></a> | <a href="#"><?php echo _i('oldest');?></a></span>
                </div>
                <!-- main comment -->
                <div class="main-comment">
                    <?php if($comments->count() > 0): ?>
                        <?php foreach ($comments as $comment):?>
                            <div class="media-object">
                                <div class="media-object-section comment-img text-center">
                                    <div class="comment-box-img">
                                        <img width="80" src="<?php echo Config::get('site.uploads_url') . 'avatars/' . $comment->user->avatar ?>" />
                                    </div>
                                </div>
                                <div class="media-object-section comment-desc">
                                    <div class="comment-title">
                                        <span class="name"><a href="/user/<?php echo $comment->user->username; ?>"><?php echo $comment->user->username; ?></a> Said:</span>
                                        <span class="time float-right"><i class="fa fa-clock-o"></i><?php echo TimeHelper::time_elapsed_string($comment->created_at);?></span>
                                    </div>
                                    <div class="comment-text">
                                        <p><?php echo $comment->comment; ?></p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach;?>
                    <?php endif;?>
                </div><!-- End main comment -->
            </div>
        </div>
    </section><!-- End Comments -->
</div>