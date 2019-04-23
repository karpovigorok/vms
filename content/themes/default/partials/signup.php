<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<!-- registration -->
<section class="registration">
    <div class="row secBg">
        <div class="large-12 columns">
            <div class="login-register-content">
                <div class="row collapse borderBottom">
                    <div class="medium-6 large-centered medium-centered">
                        <div class="page-heading text-center">
                            <h3><?php echo _i('User Registeration'); ?></h3>
                            <?php if (!$settings->free_registration): ?>
                                <p><?php echo \App\Libraries\ThemeHelper::getThemeSetting(@$theme_settings->signup_message, _i('Signup to Gain access to all content on the site.')) ?></p>
                            <?php else: ?>
                                <p><?php echo _i('Enter your info below to signup for an account.'); ?></p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <div class="row" data-equalizer data-equalize-on="medium" id="test-eq">

                    <div class="large-4 medium-6 large-offset-4 columns end">
                        <div class="register-form">
                            <h5 class="text-center"><?php echo _i('Create your Account'); ?></h5>

                            <form method="POST"
                                  action="<?php echo ($settings->enable_https) ? secure_url('signup') : URL::to('signup') ?>"
                                  class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" id="payment-form"
                                  data-abide novalidate>
                                <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">

                                <div data-abide-error class="alert callout" style="display: none;">
                                    <p>
                                        <i class="fa fa-exclamation-triangle"></i> <?php echo _i('There are some errors in your form.'); ?>
                                    </p>
                                </div>
                                <div class="input-group">
                                    <?php $username_error = $errors->first('username'); ?>
                                    <?php if (!empty($errors) && !empty($username_error)): ?>
                                        <div class="alert alert-danger"><?php echo $errors->first('username'); ?></div>
                                    <?php endif; ?>
                                    <span class="input-group-label"><i class="fa fa-user"></i></span>
                                    <input class="input-group-field" type="text"
                                           placeholder="<?php echo _i('Enter your username'); ?>" required id="username"
                                           name="username" value="<?php echo old('username'); ?>"/>
                                </div>

                                <div class="input-group">
                                    <?php $email_error = $errors->first('email'); ?>
                                    <?php if (!empty($errors) && !empty($email_error)): ?>
                                        <div class="alert alert-danger"><?php echo $errors->first('email'); ?></div>
                                    <?php endif; ?>
                                    <span class="input-group-label"><i class="fa fa-envelope"></i></span>
                                    <input class="input-group-field" type="email"
                                           placeholder="<?php echo _i('Enter your email'); ?>" required id="email"
                                           name="email" value="<?php echo old('email'); ?>">
                                </div>

                                <div class="input-group">
                                    <?php $password_error = $errors->first('password'); ?>
                                    <?php if (!empty($errors) && !empty($password_error)): ?>
                                        <div class="alert alert-danger"><?php echo $errors->first('password'); ?></div>
                                    <?php endif; ?>
                                    <span class="input-group-label"><i class="fa fa-lock"></i></span>
                                    <input type="password" id="password" placeholder="Enter your password" required
                                           id="password" name="password">
                                </div>
                                <div class="input-group">
                                    <?php $confirm_password_error = $errors->first('password_confirmation'); ?>
                                    <?php if (!empty($errors) && !empty($confirm_password_error)): ?>
                                        <div
                                            class="alert alert-danger"><?php echo $errors->first('password_confirmation'); ?></div>
                                    <?php endif; ?>
                                    <span class="input-group-label"><i class="fa fa-lock"></i></span>
                                    <input type="password" placeholder="<?php echo _i('Re-type your password'); ?>"
                                           required pattern="alpha_numeric" data-equalto="password"
                                           id="password_confirmation" name="password_confirmation">
                                </div>
                                <?php if (!$settings->free_registration): ?>
                                    <div class="cc-icons col-lg-5 col-md-4 margin-bottom-10">
                                        <img src="<?php echo THEME_URL ?>/assets/img/credit-cards.png"
                                             alt="<?php echo _i('All Credit Cards Supported'); ?>"/>
                                    </div>
                                    <div class="payment-errors alert alert-danger"></div>

                                    <!-- Credit Card Number -->
                                    <div class="input-group">
                                        <span class="input-group-label"><i class="fa fa-credit-card"></i></span>
                                        <input type="text" id="cc-number" class="form-control input-md cc-number"
                                               data-stripe="number"
                                               placeholder="<?php echo _i('Credit Card Number'); ?>" required="">

                                    </div>


                                    <!-- Expiration Date -->
                                    <div class="input-group">
                                        <label class="col-md-4 control-label"
                                               for="cc-expiration-month"><?php echo _i('Expiration Date'); ?></label>

                                        <div class="col-md-3">
                                            <select class="form-control cc-expiration-month" data-stripe="exp-month"
                                                    id="cc-expiration-month">
                                                <option value="1">January</option>
                                                <option value="2">February</option>
                                                <option value="3">March</option>
                                                <option value="4">April</option>
                                                <option value="5">May</option>
                                                <option value="6">June</option>
                                                <option value="7">July</option>
                                                <option value="8">August</option>
                                                <option value="9">September</option>
                                                <option value="10">October</option>
                                                <option value="11">November</option>
                                                <option value="12">December</option>
                                            </select></div>
                                        <div class="col-md-2">
                                            <select class="form-control cc-expiration-year" data-stripe="exp-year"
                                                    id="cc-expiration-year">
                                                <?php for ($expiration_year = date('Y'); $expiration_year <= date('Y') + 15; $expiration_year++): ?>
                                                    <option
                                                        value="<?php echo $expiration_year; ?>"><?php echo $expiration_year; ?></option>
                                                <?php endfor; ?>
                                            </select>
                                        </div>
                                    </div>


                                    <!-- CVV Number -->
                                    <div class="input-group">
                                        <span class="input-group-label"><i class="fa fa-lock"></i></span>
                                        <input id="cvv" type="text" placeholder="<?php echo _i('CVV Number');?>" data-stripe="cvc"
                                               required="">
                                    </div>
                                <?php endif; ?>

                                <span class="form-error"><?php echo _i('your email is invalid');?></span>
                                <button class="button expanded" type="submit" name="submit"><?php echo _i('Register Now');?></button>
                                <p class="loginclick"><a href="/login"><?php echo _i('Already have acoount?');?></a></p>

                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>


<script type="text/javascript" src="https://js.stripe.com/v2/"></script>

<div class="row" id="signup-form">

    <form method="POST" action="<?php echo ($settings->enable_https) ? secure_url('signup') : URL::to('signup') ?>"
          class="col-md-8 col-md-offset-2 col-sm-10 col-sm-offset-1" id="payment-form">

        <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">

        <!-- .panel -->

        <?php if ($settings->demo_mode == 1 && !$settings->free_registration): ?>
            <div class="alert alert-info demo-info" role="alert">
                <p class="title"><?php echo _i('Demo Credit Card Info');?></p>

                <p><strong><?php echo _i('Credit Card Number');?>:</strong> <span>4242 4242 4242 4242</span></p>

                <p><strong><?php echo _i('Expiration Date');?>:</strong> <span>January 2020</span></p>

                <p><strong><?php echo _i('CVV Code');?>:</strong> <span>123</span></p>
            </div>
        <?php endif; ?>

    </form>


</div><!-- #signup-form -->


<?php if (!$settings->free_registration): ?>

    <script type="text/javascript" src="<?php echo THEME_URL ?>/assets/js/jquery.payment.js"></script>
    <script type="text/javascript">

        // This identifies your website in the createToken call below
        <?php if($payment_settings->live_mode): ?>
        Stripe.setPublishableKey('<?php echo $payment_settings->live_publishable_key; ?>');
        <?php else: ?>
        Stripe.setPublishableKey('<?php echo $payment_settings->test_publishable_key; ?>');
        <?php endif; ?>

        var stripeResponseHandler = function (status, response) {
            var $form = $('#payment-form');

            if (response.error) {
                // Show the errors on the form
                $form.find('.payment-errors').text(response.error.message);
                $form.find('button').prop('disabled', false);
                $('.payment-errors').fadeIn();
            } else {
                // token contains id, last4, and card type
                var token = response.id;
                // Insert the token into the form so it gets submitted to the server
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                // and re-submit
                $form.get(0).submit();
            }
        };

        jQuery(function ($) {
            $('#payment-form').submit(function (e) {

                $('.payment-errors').fadeOut();

                var $form = $(this);

                // Disable the submit button to prevent repeated clicks
                $form.find('button').prop('disabled', true);

                Stripe.card.createToken($form, stripeResponseHandler);

                // Prevent the form from submitting with the default action
                return false;
            });
            $('#cc-number').payment('formatCardNumber');

        });

    </script>

<?php endif; ?>
