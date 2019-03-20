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
if(sizeof($videos)):
    if(!isset($class)):
        $class = '';
    endif;
    foreach($videos as $video_key => $video):
        if (($videos->count() - 1) == $video_key ):
            $class .= ' end';
        endif;
        ?>
    <div <?php if (isset($class)):?>class="<?php echo $class;?>"<?php endif?>>
        <div class="post thumb-border">
            <div class="post-thumb">
                <img src="<?php echo ImageHandler::getImage($video->image, "370x220")  ?>" alt="<?php echo htmlspecialchars($video->title); ?>">
                <a href="<?php echo ($settings->enable_https) ? secure_url('video') : URL::to('video') ?><?php echo '/' . $video->id ?>" class="hover-posts">
                    <span><i class="fa fa-play"></i><?php echo _i('Watch Video');?></span>
                </a>
                <div class="video-stats clearfix">
                    <?php if($video->max_height >= 720):?>
                        <div class="thumb-stats pull-left">
                            <h6><?php echo _i('HD');?></h6>
                        </div>
                    <?php endif;?>
                    <?php if ($video->favorite()->count() > 0): ?>
                        <div class="thumb-stats pull-left">
                            <i class="fa fa-heart"></i>
                            <span><?php echo $video->favorite()->count(); ?></span>
                        </div>
                    <?php endif; ?>
                    <?php if($video->duration > 0):?>
                        <div class="thumb-stats pull-right">
                            <span><?php echo TimeHelper::convert_seconds_to_HMS($video->duration); ?></span>
                        </div>
                    <?php endif;?>
                </div>
            </div>
            <div class="post-des">
                <h6 title="<?php echo $video->title; ?>"><a href="<?php echo ($settings->enable_https) ? secure_url('video') : URL::to('video') ?><?php echo '/' . $video->id ?>">
                        <?php
                        if(mb_strlen($video->title) > 30):
                            echo mb_substr($video->title, 0, 30) . '...';
                        elseif(mb_strlen($video->title) == 0):
                            echo '&nbsp;';
                        else:
                            echo $video->title;
                        endif;?>
                    </a></h6>
                <div class="post-stats clearfix">
                    <p>
                        <i class="fa fa-clock-o"></i>
                        <span><?php echo TimeHelper::time_elapsed_string($video->created_at); ?></span>
                    </p>
                    <p>
                        <i class="fa fa-eye"></i>
                        <span><?php echo $video->views . ' ' . _n('view', 'views', $video->views);?></span>
                    </p>

                </div>
                <div class="post-summary">
                    <?php
                    $video_description = strip_tags($video->description);
                    if(mb_strlen($video_description) > 0):?>
                    <p title="<?php echo $video->title; ?>"><?php
                        if(mb_strlen($video_description) > 90):
                            echo mb_substr($video_description, 0, 90) . '...';
                        else:
                            echo $video_description;
                        endif;?>
                    </p>
                    <?php endif;?>
                </div>
                <div class="post-button">
                    <a href="<?php echo ($settings->enable_https) ? secure_url('video') : URL::to('video') ?><?php echo '/' . $video->id ?>" class="secondary-button"><i class="fa fa-play-circle"></i><?php echo _i('watch video');?></a>
                </div>
            </div>
        </div>
    </div>
<?php
    endforeach;
endif;

?>