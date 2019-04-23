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
/**
 * Project: vms.
 * User: Igor Karpov
 * Email: mail@noxls.net
 * Date: 27.08.18
 * Time: 21:55
 *
 * @widget_name: Text and title
 * @widget_type: TITLE_AND_TEXT
 * @widget_description: This widgets is allow you to create block with title and text description
 */
?>
<div class="widgetBox">
    <div class="widgetTitle">
        <h5><?php echo $settings->website_name; ?></h5>
    </div>
    <div class="textwidget">
        <?php echo \App\Libraries\ThemeHelper::getThemeSetting(@$theme_settings->footer_description, 'VMS is your Video Subscription Platform. Add unlimited videos, posts, and pages to your subscription site. Earn re-curring revenue and require users to subscribe to access premium content on your website.') ?>
    </div>
</div>
