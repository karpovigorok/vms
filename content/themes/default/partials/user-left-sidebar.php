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
$user_menu = array(
//    [
//        'href' => '/user/' . Auth::user()->username,
//        'name' => '<i class="fa fa-video-camera"></i>' . _i('Videos')
//    ],
    [
        //'href' => '/user/' . Auth::user()->username . '/favorite',
        'href' => '/user/' . $user->username,
        'name' => '<i class="fa fa-heart"></i>' . _i('Favorite Videos')
    ],
//    [
//        'href' => '/user/' . $user->username . '/followers',
//        'name' => '<i class="fa fa-users"></i>' . _i('Followers')
//    ],
    [
        'href' => '/user/' . $user->username . '/comments',
        'name' => '<i class="fa fa-comments-o"></i>' . _i('Сomments')
    ],
);
if (!Auth::guest() && $user->username == $user->username) {
//    $user_menu[] = [
//        'href' => '/user/' . $user->username . '/edit',
//        'name' => '<i class="fa fa-gears"></i>' . _i('Profile Settings')
//    ];
if($user->role == 'subscriber') {
    $user_menu[] = [
        'href' => '/user/' . $user->username . '/billing',
        'name' => '<i class="fa fa-credit-card"></i>' . _i('Billing Information')
    ];
}
    $user_menu[] = [
        'href' => '/logout',
        'name' => '<i class="fa fa-sign-out"></i>' . _i('Logout')
    ];
}
?>

<!-- profile overview -->
<div class="large-12 columns">
    <div class="widgetBox">
        <div class="widgetTitle">
            <h5><?php echo _i('Profile Overview'); ?></h5>
        </div>
        <div class="widgetContent">
            <ul class="profile-overview">
                <?php foreach ($user_menu as $user_menu_item): ?>
                    <li class="clearfix">
                        <a <?php echo("/" . request()->path() == $user_menu_item['href'] ? 'class="active"' : ''); ?>
                                href="<?php echo $user_menu_item['href']; ?>"><?php echo $user_menu_item['name']; ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
            <?php if (0 && !Auth::guest() && Auth::user()->username == $user->username): ?>
                <a href="/user/<?php echo Auth::user()->username; ?>/upload" class="button"><i
                            class="fa fa-plus-circle"></i><?php echo _i('Submit Video'); ?></a>
            <?php endif; ?>
        </div>
    </div>
</div><!-- End profile overview -->