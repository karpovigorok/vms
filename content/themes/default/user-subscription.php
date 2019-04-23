<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<?php include('includes/header.php'); ?>
<?php if (isset($type) && $type == 'billing'): ?>
    <?php include('partials/user-billing.php'); ?>
<?php elseif (isset($type) && $type == 'update_credit_card'): ?>
    <?php include('partials/user-update-billing.php'); ?>
<?php elseif (isset($type) && $type == 'renew_subscription'): ?>
    <?php include('partials/renew-subscription.php'); ?>
<?php elseif (isset($type) && $type == 'upgrade_subscription'): ?>
    <?php include('partials/upgrade-subscription.php'); ?>
<?php endif; ?>
<?php include('includes/footer.php'); ?>