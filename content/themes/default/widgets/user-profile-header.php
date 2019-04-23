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
 * Date: 20.08.18
 * Time: 23:43
 */

?>
<!-- profile top section -->
<section class="topProfile">
    <!--div class="main-text text-center">
        <div class="row">
            <div class="large-12 columns">
                <h3></h3>
                <h1></h1>
            </div>
        </div>
    </div-->
    <div class="profile-stats">
        <div class="row secBg">
            <div class="large-12 columns">
                <div class="profile-author-img">
                    <?php if($user->avatar != ''):?>
                        <img width="120" src="<?php echo Config::get('site.uploads_url') . 'avatars/' . $user->avatar ?>" />
                    <?php else: ?>
                        <img width="120" src="<?php echo THEME_URL . '/assets/images/avatar-120x100.png'; ?>" />
                    <?php endif; ?>
                </div>
                <div class="clearfix">
                    <div class="profile-author-name float-left">
                        <h4><?php echo $user->username ?> <div class="label label-info"><?php echo ucfirst($user->role) ?> User</div></h4>
                        <p><?php echo _i('Join Date:');?> <span><?php echo date("j F, y", strtotime($user->created_at));?></span></p>
                    </div>
                    <div class="profile-author-stats float-right">
                        <ul class="menu">
                            <li>
                                <div class="icon float-left">
                                    <i class="fa fa-heart"></i>
                                </div>
                                <div class="li-text float-left">
                                    <p class="number-text"><?php echo $count_favorited_by_user; ?></p>
                                    <span><?php echo _i('favorites');?></span>
                                </div>
                            </li>
                            <li>
                                <div class="icon float-left">
                                    <i class="fa fa-comments-o"></i>
                                </div>
                                <div class="li-text float-left">
                                    <p class="number-text"><?php echo $count_user_comments; ?></p>
                                    <span><?php echo _i('comments');?></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section><!-- End profile top section -->
