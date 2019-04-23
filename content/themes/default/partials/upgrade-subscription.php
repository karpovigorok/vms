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

                <?php if($payment_settings):?>
                    <div class="row collapse borderBottom">
                        <div class="medium-12 large-centered medium-centered">
                            <div class="page-heading text-center">
                                <h3><?php echo \App\Libraries\ThemeHelper::getThemeSetting(@$theme_settings->signup_message, _i('Signup to Gain access to all content on the site.')); ?></h3>
                                <p><?php echo _i('Become a Subscriber. Enter your credit card info to upgrade your account to a subscriber membership.'); ?></p>
                            </div>
                        </div>
                    </div>
                    <img src="<?php echo THEME_URL ?>/assets/img/credit-cards.png" alt="<?php echo _i('All Credit Cards Supported'); ?>"/>

                    <div class="row" data-equalizer data-equalize-on="medium" id="test-eq">


                        <div class="large-12 medium-6 columns">
                            <div class="register-form">
                                <h5 class="text-center"></h5>
                                <?php if($payment_settings->live_mode == 0):?>
                                <div class="row column">
                                    <strong><?php echo _i("Test Credit cards");?>:</strong>
                                    <p>
                                    4242424242424242 &ndash; Visa<br>
                                    4000056655665556 &ndash; Visa (debit)<br>
                                    5555555555554444 &ndash; Mastercard<br>
                                    2223003122003222 &ndash; Mastercard (2-series)<br>
                                    5200828282828210 &ndash; Mastercard (debit)<br>
                                    5105105105105100 &ndash; Mastercard (prepaid)<br>
                                    378282246310005 &ndash; American Express<br>
                                    371449635398431 &ndash; American Express<br>
                                    6011111111111117 &ndash; Discover<br>
                                    6011000990139424 &ndash; Discover<br>
                                    30569309025904 &ndash; Diners Club<br>
                                    38520000023237 &ndash; Diners Club<br>
                                    3566002020360505 &ndash; JCB<br>
                                    6200000000000005 &ndash; UnionPay
                                    </p>
                                </div>
                                <?php endif;?>

                                <form id="payment-form" method="post"
                                      action="<?php echo ($settings->enable_https) ? secure_url('user') : URL::to('user') ?>/<?php echo $user->username ?>/upgrade_cc"
                                      class="form-signin" data-abide novalidate>
                                    <div class="payment-errors col-md-8 text-danger" style="display:none"></div>
                                    <div data-abide-error class="alert callout" style="display: none;">
                                        <p>
                                            <i class="fa fa-exclamation-triangle"></i> <?php echo _i('There are some errors in your form.'); ?>
                                        </p>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-label"><i class="fa fa-calendar"></i></span>
                                        <select class="input-group-field" name="stripe_subscription_plan">
                                            <option value="0"><?php echo _i('Choose Subscription Plan');?></option>
                                            <?php
                                            if($stripe_subscription_plans && sizeof($stripe_subscription_plans->data)):
                                            foreach($stripe_subscription_plans->data as $stripe_subscription_plan):
                                                echo '<option value="' . $stripe_subscription_plan->id . '">' . $stripe_subscription_plan->nickname . ": " . $stripe_subscription_plan->amount/100 . ' ' . $stripe_subscription_plan->currency . ' per ' . $stripe_subscription_plan->interval_count . ' ' . $stripe_subscription_plan->interval . '</option>';
                                            endforeach;
                                            endif;
                                            ?>

                                        </select>
                                        <input type="hidden" name="stripe_product_id" value="<?php echo $stripe_subscription_plan->product;?>">

                                        <!--input class="input-group-field" type="text"
                                               placeholder="<?php echo _i('Credit Card Number'); ?>" required id="cc-number"
                                               data-stripe="number"-->
                                        <span class="form-error"><?php echo _i('username is required'); ?></span>
                                    </div>
                                    <div class="input-group">
                                        <span class="input-group-label"><i class="fa fa-credit-card"></i></span>
                                        <input class="input-group-field" type="text"
                                               placeholder="<?php echo _i('Credit Card Number'); ?>" required id="cc-number"
                                               data-stripe="number">
                                        <span class="form-error"><?php echo _i('Credit Card is required'); ?></span>
                                    </div>

                                    <div class="input-group">

                                        <span class="input-group-label"><i class="fa fa-lock"></i></span>
                                        <input type="text" placeholder="<?php echo _i('CVV Number');?>" name="password"
                                               class="input-group-field" id="cvv" data-stripe="cvc" required="">
                                        <span class="form-error"><?php echo _i('password is required');?></span>
                                    </div>
                                    <!-- Expiration Date -->
                                    <div class="input-group">
                                        <label class="large-4 control-label" for="cc-expiration-month"><?php echo _i('Expiration Date');?></label>

                                        <div class="large-3 columns">
                                            <select class="form-control cc-expiration-month" data-stripe="exp-month"
                                                    id="cc-expiration-month">
                                            <?php for($m = 1; $m <= 12; ++$m): ?>
                                                <option value="<?php echo $m;?>"><?php echo date('F', mktime(0, 0, 0, $m, 1));?></option>
                                            <?php endfor; ?>
                                            </select></div>
                                        <div class="large-3 columns end">
                                            <select class="form-control cc-expiration-year" data-stripe="exp-year"
                                                    id="cc-expiration-year">
                                                <?php for ($year = date("Y"); $year <= (date("Y") + 15); $year++): ?>
                                                    <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                <?php endfor; ?>
                                            </select>

                                        </div>
                                    </div>
                                    <div class="row ">
                                        <div class="large-3 columns">
                                            <button class="button expanded" type="submit" name="submitBtn"
                                                    id="upgrade_subscriber_button"><?php echo _i('Upgrade to Subscriber');?>
                                            </button>
                                        </div>
                                    </div>
                                    <input type="hidden" id="redirect" name="redirect"
                                           value="<?php echo Input::get('redirect') ?>"/>
                                    <input type="hidden" name="_token" value="<?php echo csrf_token() ?>"/>
                                </form>

                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="row collapse borderBottom">
                        <div class="medium-12 large-centered medium-centered">
                            <div class="page-heading text-center">
                                <h3><?php echo _i('Payment system is under maintenance. Please try again later.'); ?></h3>
                            </div>
                        </div>
                    </div>
                <?php endif;?>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
<script type="text/javascript" src="<?php echo THEME_URL ?>/assets/js/jquery.payment.js"></script>
<script type="text/javascript">

    // This identifies your website in the createToken call below
    <?php
    if($payment_settings):

        if($payment_settings->live_mode): ?>
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
            } else {
                console.log('token contains id, last4, and card type');
                var token = response.id;
                console.log('Insert the token into the form so it gets submitted to the server');
                console.log('token: ' + token);
                $form.append($('<input type="hidden" name="stripeToken" />').val(token));
                console.log('and re-submit');
                $form.get(0).submit();
            }
        };

        jQuery(function ($) {
            // $("#upgrade_subscriber_button").on("click", function() {
            //     var $form = $('#payment-form');
            //
            //     console.log('Disable the submit button to prevent repeated clicks');
            //     $form.find('button').prop('disabled', true);
            //
            //     Stripe.card.createToken($form, stripeResponseHandler);
            //
            //     console.log('Prevent the form from submitting with the default action');
            //     return false;
            // });


            $('#payment-form').submit(function (e) {
                var $form = $(this);

                console.log('Disable the submit button to prevent repeated clicks');
                $form.find('button').prop('disabled', true);

                Stripe.card.createToken($form, stripeResponseHandler);

                console.log('Prevent the form from submitting with the default action');
                return false;
            });
            $('#cc-number').payment('formatCardNumber');

        });
    <?php endif;?>
</script>
