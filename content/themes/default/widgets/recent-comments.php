<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.0
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov
    * @website https://noxls.net
    *
*/?>
<!-- Recent comments videos -->
<?php if(sizeof($sidebar_recent_comments)): ?>
<div class="widgetBox">
    <div class="widgetTitle">
        <h5><?php echo _i('Recent comments');?></h5>
    </div>
    <div class="widgetContent">
        <?php foreach($sidebar_recent_comments as $recent_comment):
            $commented_video = App\Models\Video::findOrFail($recent_comment->commentable_id);
            ?>
            <div class="media-object stack-for-small">
                <div class="media-object-section">
                    <div class="recent-img">
                        <img src="<?php echo ImageHandler::getImage($commented_video->image, '170x150'); ?>" alt="<?php echo htmlspecialchars($commented_video->title); ?>">
                        <a href="<?php echo ($settings->enable_https) ? secure_url('video') : URL::to('video/') . "/" . $commented_video->id ?>" class="hover-posts">
                            <span><i class="fa fa-play"></i></span>
                        </a>
                    </div>
                </div>
                <div class="media-object-section">
                    <div class="media-content">
                        <h6><a href="<?php echo ($settings->enable_https) ? secure_url('video') : URL::to('video/') . "/" . $commented_video->id ?>">
                                <?php if(mb_strlen($recent_comment->comment) > 80){ echo mb_substr($recent_comment->comment, 0, 80) . '...'; } else { echo $recent_comment->comment; } ?>
                            </a></h6>
                        <p><i class="fa fa-user"></i><span><?php echo $recent_comment->user->username; ?></span><i class="fa fa-clock-o"></i>
                            <span><?php echo TimeHelper::time_elapsed_string($recent_comment->created_at);?></span>
                        </p>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>
</div>
<?php endif;?>
<!-- End Recent comments videos -->