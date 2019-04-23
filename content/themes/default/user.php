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
<?php //include('partials/user-profile-top.php');

?>
<?php echo Widget::run('userProfileHeader', [], $user); ?>
<div class="row">
    <!-- left sidebar -->
    <div class="large-4 columns">
        <aside class="secBg sidebar">
            <div class="row">
                <?php include('partials/user-left-sidebar.php'); ?>
            </div>
        </aside>
    </div><!-- end sidebar -->
    <!-- right side content area -->
    <?php if (isset($content_block)): ?>
        <?php echo $content_block; ?>
    <?php endif; ?>
    <!-- end left side content area -->
</div>
<?php include('includes/footer.php'); ?>

<div class="container user">
    <?php if (isset($type) && $type == 'profile'): ?>
    <?php elseif (isset($type) && $type == 'edit'): ?>

        <h4 class="subheadline"><i class="fa fa-edit"></i> <?php echo _i('Update Your Profile Info'); ?></h4>
        <div class="clear"></div>

        <form method="POST" action="<?php echo $post_route ?>" id="update_profile_form" accept-charset="UTF-8" file="1"
              enctype="multipart/form-data">

            <div id="user-badge">
                <img src="<?php echo Config::get('site.uploads_url') . 'avatars/' . $user->avatar ?>"/>
                <label for="avatar"><?php echo _i('Avatar'); ?></label>
                <input type="file" multiple="true" class="form-control" name="avatar" id="avatar"/>
            </div>

            <div class="well">
                <?php if ($errors->first('username')): ?>
                    <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh
                        snap!</strong> <?php echo $errors->first('username'); ?></div><?php endif; ?>
                <label for="username"><?php echo _i('Username'); ?></label>
                <input type="text" class="form-control" name="username" id="username"
                       value="<?php if (!empty($user->username)): ?><?php echo $user->username ?><?php endif; ?>"/>
            </div>

            <div class="well">
                <?php if ($errors->first('email')): ?>
                    <div class="alert alert-danger">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button> <strong>Oh
                        snap!</strong> <?php echo $errors->first('email'); ?></div><?php endif; ?>
                <label for="email"><?php echo _i('Email'); ?></label>
                <input type="text" class="form-control" name="email" id="email"
                       value="<?php if (!empty($user->email)): ?><?php echo $user->email ?><?php endif; ?>"/>
            </div>

            <div class="well">
                <label for="password"><?php echo _i('Password (leave empty to keep your original password)'); ?></label>
                <input type="password" class="form-control" name="password" id="password" value=""/>
            </div>

            <?php if (($settings->free_registration && $settings->premium_upgrade) || (!$settings->free_registration)): ?>
                <div class="well">
                    <label for="role" style="margin-bottom:10px;"><?php echo _i('User Type');?></label>
					<?php if($user->role == 'subscriber'): ?>
                        <div class="label label-success"><i
                                    class="fa fa-certificate"></i> <?php echo ucfirst($user->role) ?> <?php echo _i('User'); ?>
                        </div>
                        <div class="clear"></div>
                        <?php elseif($user->role == 'registered'): ?>
                        <div class="label label-warning"><i
                                    class="fa fa-user"></i> <?php echo ucfirst($user->role) ?> <?php echo _i('User'); ?>
                        </div>
                        <div class="clear"></div>
                        <?php elseif($user->role == 'demo'): ?>
                        <div class="label label-danger"><i
                                    class="fa fa-life-saver"></i> <?php echo ucfirst($user->role) ?> <?php echo _i('User'); ?>
                        </div>
                        <div class="clear"></div>
                        <?php elseif($user->role == 'admin'): ?>
                        <div class="label label-primary"><i
                                    class="fa fa-star"></i> <?php echo ucfirst($user->role) ?> <?php echo _i('User'); ?>
                        </div>
                        <div class="clear"></div>
                        <?php endif; ?>
                        <?php if($settings->free_registration && $settings->premium_upgrade): ?>
                        <a class="btn btn-primary"
                           href="<?php echo ($settings->enable_https) ? secure_url('/') : URL::to('user') ?><?php echo '/' . $user->username; ?>/upgrade_subscription"
                           style="margin-top:10px;"><i class="fa fa-certificate"></i> <?php echo _i('Upgrade to Premium Subscription');?></a>
                        <?php else: ?>
                        <a class="btn btn-primary"
                           href="<?php echo ($settings->enable_https) ? secure_url('/') : URL::to('user') ?><?php echo '/' . $user->username; ?>/billing"
                           style="margin-top:10px;"><i class="fa fa-credit-card"></i> <?php echo _i('Manage Your Billing Info');?></a>
                        <?php endif; ?>
                </div>
            <?php endif; ?>
            <input type="hidden" name="_token" value="<?php echo csrf_token() ?>"/>
            <input type="submit" value="Update Profile" class="btn btn-primary"/>
            <div class="clear"></div>
        </form>
    <?php endif; ?>
</div>

