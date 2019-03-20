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
 * Time: 23:42
 */
?>
<!-- registration -->
<section class="registration">
    <div class="row secBg">
        <div class="large-12 columns">
            <div class="login-register-content">
                <div class="row collapse borderBottom">
                    <div class="medium-6 large-centered medium-centered">
                        <div class="page-heading text-center">
                            <h3><?php echo _i('User login'); ?></h3>

                            <p></p>
                        </div>
                    </div>
                </div>
                <div class="row" data-equalizer data-equalize-on="medium" id="test-eq">

                    <div class="large-4 medium-6 large-offset-4 columns end">
                        <div class="register-form">
                            <h5 class="text-center"><?php echo _i('Login with your Account'); ?></h5>

                            <form method="post"
                                  action="<?php echo ($settings->enable_https) ? secure_url('login') : URL::to('login') ?>"
                                  class="form-signin" data-abide novalidate>
                                <div data-abide-error class="alert callout" style="display: none;">
                                    <p>
                                        <i class="fa fa-exclamation-triangle"></i> <?php echo _i('There are some errors in your form.'); ?>
                                    </p>
                                </div>
                                <div class="input-group">
                                    <span class="input-group-label"><i class="fa fa-user"></i></span>
                                    <input class="input-group-field" type="text"
                                           placeholder="<?php echo _i('Enter your Email address or Username'); ?>"
                                           required name="email">
                                    <span class="form-error"><?php echo _i('username is required'); ?></span>
                                </div>

                                <div class="input-group">
                                    <span class="input-group-label"><i class="fa fa-lock"></i></span>
                                    <input type="password" id="password"
                                           placeholder="<?php echo _i('Enter your password'); ?>" required
                                           name="password">
                                    <span class="form-error"><?php echo _i('password is required'); ?></span>
                                </div>
                                <div class="checkbox">
                                    <input id="remember" type="checkbox" name="check" value="remember">
                                    <label class="customLabel" for="remember"><?php echo _i('Remember me'); ?></label>
                                </div>
                                <button class="button expanded" type="submit"
                                        name="submit"><?php echo _i('login Now'); ?></button>
                                <p class="loginclick">
                                    <a href="<?php echo ($settings->enable_https) ? secure_url('password/reset') : URL::to('password/reset') ?>">
                                        <?php echo _i('Forgot Password'); ?></a> <?php echo _i('New Here?'); ?>
                                    <a href="/signup"><?php echo _i('Create a new Account'); ?></a></p>
                                <input type="hidden" id="redirect" name="redirect"
                                       value="<?php echo Input::get('redirect') ?>"/>
                                <input type="hidden" name="_token" value="<?php echo csrf_token() ?>"/>
                            </form>
                            <?php if ($settings->demo_mode == 1): ?>
                                <div class="alert alert-info demo-info" role="alert">
                                    <p class="title"><?php echo _i('Demo Login'); ?></p>

                                    <p><strong><?php echo _i('username'); ?>:</strong> <span>demo</span></p>

                                    <p><strong><?php echo _i('password'); ?>:</strong> <span>demo</span></p>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>