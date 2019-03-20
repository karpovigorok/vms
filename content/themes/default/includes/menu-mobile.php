<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.0
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov
    * @website https://noxls.net
    *
*/?>
<div class="off-canvas position-left light-off-menu" id="offCanvas-responsive" data-off-canvas>
    <div class="off-menu-close">
        <h3>Menu</h3>
        <span data-toggle="offCanvas-responsive"><i class="fa fa-times"></i></span>
    </div>
    <ul class="vertical menu off-menu" data-responsive-menu="drilldown">
    <?php echo generate_mobile_menu($menu);?>
    </ul>
    <div class="responsive-search">
        <form method="post" action="/search">
            <div class="input-group">
                <input class="input-group-field" type="search" name="search" placeholder="<?php echo _i('Seach Here your video');?>">
                <div class="input-group-button">
                    <button type="submit" name="search"><i class="fa fa-search"></i></button>
                </div>
            </div>
        </form>
    </div>
    <div class="off-social">
        <h6>Get Socialize</h6>
        <?php if(!empty($settings->facebook_page_id)):?>
            <a href="<?php echo $settings->facebook_page_id;?>"><i class="fa fa-facebook-f"></i></a>
        <?php endif;?>
        <?php if(!empty($settings->twitter_page_id)):?>
            <a href="<?php echo $settings->twitter_page_id;?>"><i class="fa fa-twitter"></i></a>
        <?php endif;?>
        <?php if(!empty($settings->google_page_id)):?>
            <a href="<?php echo $settings->google_page_id;?>"><i class="fa fa-google-plus"></i></a>
        <?php endif;?>
        <?php if(!empty($settings->instagram_page_id)):?>
            <a href="<?php echo $settings->instagram_page_id;?>"><i class="fa fa-instagram"></i></a>
        <?php endif;?>
        <?php if(!empty($settings->vimeo_page_id)):?>
            <a href="<?php echo $settings->vimeo_page_id;?>"><i class="fa fa-vimeo"></i></a>
        <?php endif;?>
        <?php if(!empty($settings->youtube_page_id)):?>
            <a href="<?php echo $settings->youtube_page_id;?>"><i class="fa fa-youtube"></i></a>
        <?php endif;?>
    </div>
    <div class="top-button">
        <ul class="menu">
            <?php //if(Auth::check()):?>
            <?php //else:?>
            <li>
                <a href="submit-post.html"><?php echo _i('Upload Video');?></a>
            </li>
            <li class="dropdown-login">
                <a href="/login"><?php echo _i('Login/Register');?></a>
            </li>
            <?php //endif;?>

        </ul>
    </div>
</div>