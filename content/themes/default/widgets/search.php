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
/**
 * Project: vms.
 * User: Igor Karpov
 * Email: mail@noxls.net
 * Date: 29.07.18
 * Time: 0:35
 */
?>
<!-- search Widget -->
<div class="widgetBox">
    <div class="widgetTitle">
        <h5><?php echo _i('Search Videos');?></h5>
    </div>
    <form id="searchform" method="get" role="search" action="/search">
        <div class="input-group">
            <input class="input-group-field" name="value" type="text" placeholder="<?php echo _i('Enter your keyword');?>">
            <div class="input-group-button">
                <input type="submit" class="button" value="<?php echo _i('Submit');?>">
            </div>
        </div>
    </form>
</div>
<!-- End search Widget -->