<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<?php if(!empty($settings->facebook_page_id) ||
    !empty($settings->twitter_page_id) ||
    !empty($settings->google_page_id) ||
    !empty($settings->instagram_page_id) ||
    !empty($settings->vimeo_page_id) ||
    !empty($settings->youtube_page_id)):?>
<div class="widgetBox">
    <div class="widgetTitle">
        <h5><?php echo _i('We’re a Social Bunch');?></h5>
    </div>
    <div class="widgetContent">
        <div class="social-links">
            <?php if(!empty($settings->facebook_page_id)):?>
                <a class="secondary-button" href="<?php echo $settings->facebook_page_id;?>"><i class="fa fa-facebook-f"></i></a>
            <?php endif;?>
            <?php if(!empty($settings->twitter_page_id)):?>
                <a class="secondary-button" href="<?php echo $settings->twitter_page_id;?>"><i class="fa fa-twitter"></i></a>
            <?php endif;?>
            <?php if(!empty($settings->google_page_id)):?>
                <a class="secondary-button" href="<?php echo $settings->google_page_id;?>"><i class="fa fa-google-plus"></i></a>
            <?php endif;?>
            <?php if(!empty($settings->instagram_page_id)):?>
                <a class="secondary-button" href="<?php echo $settings->instagram_page_id;?>"><i class="fa fa-instagram"></i></a>
            <?php endif;?>
            <?php if(!empty($settings->vimeo_page_id)):?>
                <a class="secondary-button" href="<?php echo $settings->vimeo_page_id;?>"><i class="fa fa-vimeo"></i></a>
            <?php endif;?>
            <?php if(!empty($settings->youtube_page_id)):?>
                <a class="secondary-button" href="<?php echo $settings->youtube_page_id;?>"><i class="fa fa-youtube"></i></a>
            <?php endif;?>
        </div>
    </div>
</div>
<?php endif;?>