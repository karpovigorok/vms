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
$settings = \App\Models\Setting::first();
if(isset($video->id) || isset($category->id) || isset($post->id)):
    if(isset($seo['meta_title'])):
        echo $seo['meta_title']->render();
    endif;
    if(isset($seo['meta_description'])):
        echo $seo['meta_description']->render();
    endif;
    if(isset($seo['meta_keywords'])):
        echo $seo['meta_keywords']->render();
    endif;
    if(isset($seo['meta_misc_tags'])):
        echo $seo['meta_misc_tags']->render();
    endif;
    if(isset($seo['webmasters'])):
        echo $seo['webmasters']->render();
    endif;
    if(isset($seo['openGraph'])):
        echo $seo['openGraph']->render();
    endif;
    if(isset($seo['twitter_card'])):
        echo $seo['twitter_card']->render();
    endif;
    ?>
<?php elseif(isset($page->id)): ?>
    <title><?php echo $page->title . '-' . $settings->website_name; ?></title>
    <meta name="description" content="<?php echo $page->title . '-' . $settings->website_name; ?>">
<?php else: ?>
    <title><?php echo $settings->website_name . ' - ' . $settings->website_description; ?></title>
    <meta name="description" content="<?php echo $settings->website_description ?>">
<?php endif; ?>
<meta charset="utf-8">
<meta http-equiv="x-ua-compatible" content="ie=edge">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href=<?php echo THEME_URL . '/assets/css/app.css'; ?>>
<link rel="stylesheet" href=<?php echo THEME_URL . '/assets/css/theme.css'; ?>>
<link rel="stylesheet" href=<?php echo THEME_URL . '/assets/css/font-awesome.min.css'; ?>>
<link href='https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>
<link rel="stylesheet" type="text/css" href=<?php echo THEME_URL . '/assets/layerslider/css/layerslider.css'; ?>>
<link rel="stylesheet" href=<?php echo THEME_URL . '/assets/css/owl.carousel.min.css'; ?>>
<link rel="stylesheet" href=<?php echo THEME_URL . '/assets/css/owl.theme.default.min.css'; ?>>
<link rel="stylesheet" href=<?php echo THEME_URL . '/assets/css/jquery.kyco.easyshare.css'; ?>>
<link rel="stylesheet" href=<?php echo THEME_URL . '/assets/css/responsive.css'; ?>>
<?php if (isset($settings->google_tag_id) && $settings->google_tag_id != ''): ?>
<!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
        new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
        j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
        'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
    })(window,document,'script','dataLayer','<?php echo $settings->google_tag_id;?>');</script>
<!-- End Google Tag Manager -->
<?php endif; ?>

<?php if(isset($video->id) || isset($episode->id)): ?>
<!--    <link href="--><?php //echo THEME_URL . '/assets/js/video-js/video-js.min.css'; ?><!--" rel="stylesheet">-->
    <link href="https://kmoskwiak.github.io/videojs-resolution-switcher/node_modules/video.js/dist/video-js.min.css" rel="stylesheet">
    <link rel="stylesheet" href=<?php echo THEME_URL . '/assets/js/video-js/plugins/videojs-resolution-switcher/videojs-resolution-switcher.css'; ?>>
    <!-- If you'd like to support IE8 (for Video.js versions prior to v7) -->
    <script src="https://vjs.zencdn.net/ie8/ie8-version/videojs-ie8.min.js"></script>
<?php endif; ?>
<style type="text/css"><?php echo dynamic_styles($theme_settings); ?></style>
<style type="text/css"><?php echo \App\Libraries\ThemeHelper::getThemeSetting(@$theme_settings->custom_css, '') ?></style>
<link href='//fonts.googleapis.com/css?family=Open+Sans:300,400,700' rel='stylesheet' type='text/css'>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
<script>if (!window.jQuery) { document.write('<script src="<?php echo THEME_URL . '/assets/js/jquery.min.js'; ?>"><\/script>'); }</script>

<?php $favicon = (!empty($settings->favicon)) ? $settings->favicon : THEME_URL . '/assets/img/favicon.png'; ?>
<link rel="icon" href="<?php echo $favicon ?>" type="image/x-icon">
<link rel="shortcut icon" href="<?php echo $favicon ?>" type="image9sx-icon">