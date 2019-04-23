<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<section class="registration">
    <div class="row secBg">
        <div class="large-12 columns">
            <div class="login-register-content">
                <div class="row collapse borderBottom">
                    <div class="medium-6 large-centered medium-centered">
                        <div class="page-heading text-center">
                            <h3><?php echo _i('Reset Password'); ?></h3>
                            <p><?php echo _i('Enter your email and your new password below to finish resetting your password.'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="row" data-equalizer data-equalize-on="medium" id="test-eq">
                    <div class="large-4 medium-6 large-centered medium-centered columns">
                        <div class="register-form">
                            <?php if (Session::has('error')): ?>
                                <span class="error"><?php echo trans(Session::get('reason')) ?></span>
                            <?php elseif (Session::has('success')): ?>
                                <span class="success"><?php echo Lang::get('lang.email_has_been_set') ?></span>
                            <?php endif; ?>
                            <form method="POST"
                                  action="<?php echo ($settings->enable_https) ? secure_url('password/reset') : URL::to('password/reset') ?><?php echo '/' . $token; ?>"
                                  accept-charset="UTF-8" data-abide novalidate>

                                <div class="input-group">
                                    <span class="input-group-label"><i class="fa fa-user"></i></span>
                                    <input name="email" type="email" placeholder="<?php echo _i('Enter your Email address'); ?>" id="email">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-label"><i class="fa fa-user"></i></span>
                                    <input name="password" type="password" placeholder="<?php echo _i('Enter your password'); ?>" id="password">
                                </div>
                                <div class="input-group">
                                    <span class="input-group-label"><i class="fa fa-user"></i></span>
                                    <input name="password_confirmation" type="password" placeholder="<?php echo _i('Re-type your password'); ?>" id="password_confirmation">
                                </div>
                                <button class="button expanded"
                                        type="submit"><?php echo _i('Set Your New Password'); ?></button>
                                <input name="token" type="hidden" value="<?php echo $token ?>">
                                <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>