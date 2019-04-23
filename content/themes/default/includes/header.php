<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/html">
<head>
    <?php include('head.php'); ?>
</head>
<body <?php if(Request::is('/')) echo 'class="home"'; ?>>
<?php if (isset($settings->google_tag_id) && $settings->google_tag_id != ''): ?>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=<?php echo $settings->google_tag_id;?>"
                  height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
<?php endif; ?>
<div class="off-canvas-wrapper">
    <div class="off-canvas-wrapper-inner" data-off-canvas-wrapper>
        <!--header-->
        <!--mobile menu-->
        <?php include('menu-mobile.php');?>
        <!--end mobile menu-->
        <div class="off-canvas-content" data-off-canvas-content>
            <header>
                <!-- Top -->
                <section id="top" class="topBar show-for-large">
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="socialLinks">
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
                        </div>
                        <div class="medium-6 columns">
                            <div class="top-button">
                                <ul class="menu float-right">
                                    <!--li>
                                        <a href="submit-post.html"><?php echo _i('Upload Video');?></a>
                                    </li-->

                                    <?php if(Auth::check()):?>
                                        <li class="dropdown-login">
                                            <a class="loginReg" data-toggle="example-dropdown" href="#">
                                                <?php if(Auth::User()->avatar != ''):?>
                                                <img width="25" src="<?php echo Auth::User()->avatar; ?>" />
                                                <?php else: ?>
                                                <img width="25" src="<?php echo THEME_URL . '/assets/images/avatar-80x80.png'; ?>" />
                                                <?php endif; ?>
                                                <strong><?php echo Auth::User()->username; ?> &#9662;</strong>

                                            </a>
                                            <div class="login-form">
                                                <p class="text-center topProfilebtn">
                                                    <a class="button expanded" href="/user/<?php echo Auth::User()->username; ?>"><?php echo _i('Visit Profile');?></a>
                                                </p>
                                                <?php if(Auth::User()->role == 'admin' || Auth::User()->role == 'demo'): ?>
                                                <p class="text-center topProfilebtn">
                                                    <a class="button expanded" href="/admin"><?php echo _i('Admin');?></a>
                                                </p>
                                                <?php endif;?>
                                                <p class="text-center topProfilebtn">
                                                    <a class="button expanded" href="/logout">
                                                        <i class="fa fa-sign-out"></i><?php echo _i('Logout');?></a>
                                                </p>
                                            </div>
                                        </li>
                                    <?php else:?>
                                        <li class="dropdown-login">
                                            <a class="loginReg" data-toggle="example-dropdown" href="#">login/Register</a>
                                            <div class="login-form">
                                                <h6 class="text-center"><?php echo _i('Great to have you back!');?></h6>
                                                <form method="post" action="<?php echo ($settings->enable_https) ? secure_url('login') : URL::to('login') ?>">
                                                    <div class="input-group">
                                                        <span class="input-group-label"><i class="fa fa-user"></i></span>
                                                        <input class="input-group-field" type="text" name="email" placeholder="<?php echo _i('Enter username');?>">
                                                    </div>
                                                    <div class="input-group">
                                                        <span class="input-group-label"><i class="fa fa-lock"></i></span>
                                                        <input class="input-group-field" name="password" type="password" placeholder="<?php echo _i('Enter password');?>">
                                                    </div>
                                                    <div class="checkbox">
                                                        <input id="check1" type="checkbox" name="check" value="check">
                                                        <label class="customLabel" for="check1"><?php echo _i('Remember me');?></label>
                                                    </div>
                                                    <input type="submit" name="submit" value="<?php echo _i('Login Now');?>">
                                                    <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>" />
                                                </form>
                                                <input type="hidden" id="redirect" name="redirect" value="<?php echo Input::get('redirect') ?>" />
                                                <p class="text-center"><?php echo _i('New here?');?> <a class="newaccount" href="/signup"><?php echo _i('Create a new Account');?></a></p>
                                            </div>
                                        </li>
                                    <?php endif;?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </section><!-- End Top -->
                <!--Navber-->
                <section id="navBar">
                    <nav class="sticky-container" data-sticky-container>
                        <div class="sticky topnav" data-sticky data-top-anchor="navBar" data-btm-anchor="footer-bottom:bottom" data-margin-top="0" data-margin-bottom="0" style="width: 100%; background: #fff;" data-sticky-on="large">
                            <div class="row">
                                <div class="large-12 columns">
                                    <div class="title-bar" data-responsive-toggle="beNav" data-hide-for="large">
                                        <button class="menu-icon" type="button" data-toggle="offCanvas-responsive"></button>
                                        <div class="title-bar-title"><img src="<?php echo ImageHandler::getImage($settings->logo); ?>" alt="<?php echo $settings->website_name; ?>"></div>
                                    </div>

                                    <div class="top-bar show-for-large" id="beNav" style="width: 100%;">
                                        <div class="top-bar-left">
                                            <ul class="menu">
                                                <li class="menu-text">
                                                    <a href="/">
                                                        <?php if($settings->logo != ''):?>
                                                        <img src="<?php echo ImageHandler::getImage($settings->logo); ?>" alt="<?php echo $settings->website_name; ?>" width="140">
                                                        <?php else:?>
                                                            <img src="<?php echo THEME_URL . '/assets/images/logo.png'; ?>" alt="<?php echo $settings->website_name; ?>">
                                                        <?php endif;?>
                                                    </a>

                                                </li>
                                            </ul>
                                        </div>
                                        <div class="top-bar-right search-btn">
                                            <ul class="menu">
                                                <li class="search">
                                                    <i class="fa fa-search"></i>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="top-bar-right">
                                            <?php include ('menu.php');?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div id="search-bar" class="clearfix search-bar-light">
                                <form id="header_searchform" method="get" role="search" action="/search">
                                    <div class="search-input float-left">
                                        <input type="search" name="value" placeholder="<?php echo _i('Seach Here your video');?>">
                                    </div>
                                    <div class="search-btn float-right text-right">
                                        <button class="button" name="search" type="submit"><?php echo _i('search now');?></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </nav>
                </section>
            </header><!-- End Header -->
            <?php
                if (!Request::is('/')):
                    include('breadcrumbs.php');
                endif;
            ?>