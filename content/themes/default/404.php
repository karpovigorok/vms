<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<?php $menu = Menu::orderBy('order', 'ASC')->get(); ?>
<?php include('includes/header.php'); ?>

<section class="error-page">
    <div class="row secBg">
        <div class="large-8 large-centered columns">
            <div class="error-page-content text-center">
                <div class="error-img text-center">
                    <img src="<?php echo THEME_URL . '/assets/images/404-error.png';?>" alt="404 page">
                    <div class="spark">
                        <img class="flash" src="<?php echo THEME_URL . '/assets/images/spark.png';?>" alt="spark">
                    </div>
                </div>
                <h1><?php echo _i('Page Not Found');?></h1>
                <p></p>
                <a href="/" class="button"><?php echo _i('Go Back Home Page');?></a>
            </div>
        </div>
    </div>
</section>
<?php include('includes/footer.php'); ?>