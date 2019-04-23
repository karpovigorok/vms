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
?>
    <div class="row">
        <div class="large-12 medium-7 medium-centered columns">
        <?php echo Widget::run('search');?>
        </div>
        <div class="large-12 medium-7 medium-centered columns">
        <?php echo Widget::run('mostViewVideos', ['excluded_video_ids' => isset($excluded_video_ids)?$excluded_video_ids:[]]);?>
        </div>
        <div class="large-12 medium-7 medium-centered columns">
        <?php echo Widget::run('videoCategoriesList');?>
        </div>

        <div class="large-12 medium-7 medium-centered columns">
        <?php echo Widget::run('socialFans');?>
        </div>
        <div class="large-12 medium-7 medium-centered columns">
        <?php echo Widget::run('adv');?>
        </div>

        <div class="large-12 medium-7 medium-centered columns">
        <?php echo Widget::run('recentComments');?>
        </div>
        <div class="large-12 medium-7 medium-centered columns">
        <?php echo Widget::run('tagsCloud');?>
        </div>
    </div>
