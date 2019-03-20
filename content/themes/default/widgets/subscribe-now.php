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
 * Date: 27.08.18
 * Time: 23:21
 */
?>
<?php if(false):?>
<div class="widgetBox">
    <div class="widgetTitle">
        <h5><?php echo _i('Subscribe Now'); ?></h5>
    </div>
    <div class="widgetContent">
        <form data-abide novalidate method="post">
            <p><?php echo _i('Subscribe to get exclusive videos'); ?></p>

            <div class="input">
                <input type="text" placeholder="<?php echo _i('Enter your full Name'); ?>" required>
                <span class="form-error"><?php echo _i('Yo, you had better fill this out, it\'s required.'); ?></span>
            </div>
            <div class="input">
                <input type="email" id="email" placeholder="<?php echo _i('Enter your email address'); ?>" required>
                <span class="form-error"><?php echo _i('I\'m required!'); ?></span>
            </div>
            <button class="button" type="submit" value="Submit"><?php echo _i('Subscribe'); ?></button>
        </form>
    </div>
</div>
<?php endif;?>