<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.0
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov
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
                            <p><?php echo _i('Enter your email address and we\'ll send you a password reset link'); ?></p>
                        </div>
                    </div>
                </div>
                <div class="row" data-equalizer data-equalize-on="medium" id="test-eq">
                    <div class="large-4 medium-6 large-centered medium-centered columns">
                        <div class="register-form">
                            <?php if (Session::has('notification')): ?>
                                <span class="notification"><?php echo Session::get('notification') ?></span>
                            <?php endif; ?>
                            <?php if (Session::has('error')): ?>
                                <span class="error"><?php echo trans(Session::get('reason')) ?></span>
                            <?php elseif (Session::has('success')): ?>
                                <span class="success"><?php echo Lang::get('lang.email_sent') ?></span>
                            <?php endif; ?>
                            <form method="POST"
                                  action="<?php echo ($settings->enable_https) ? secure_url('password/reset') : URL::to('password/reset'); ?>"
                                  accept-charset="UTF-8" data-abide novalidate>

                                <div class="input-group">
                                    <span class="input-group-label"><i class="fa fa-user"></i></span>
                                    <input name="email" type="email" placeholder="<?php echo _i('Email Address'); ?>" required>
                                    <span class="form-error">email is required</span>
                                </div>
                                <button class="button expanded"
                                        type="submit"><?php echo _i('Send Password Reset'); ?></button>
                                <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
