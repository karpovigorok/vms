<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.0
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov
    * @website https://noxls.net
    *
*/?>
<div class="large-8 columns profile-inner">
    <!-- profile settings -->
    <section class="profile-settings">
        <div class="row secBg">
            <div class="large-12 columns">
                <div class="heading">
                    <i class="fa fa-credit-card"></i>
                    <h4> <?php echo _i('Update Your Credit Card Info');?></h4>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <div class="setting-form">
                            <form method="post" action="<?php echo ($settings->enable_https) ? secure_url('user') : URL::to('user') ?>/<?php echo $user->username ?>/update_cc" id="payment-form">
                                <div class="setting-form-inner">
                                    <div class="row">
                                        <div class="large-12 columns">
                                            <img src="<?php echo THEME_URL ?>/assets/img/credit-cards.png"
                                                 alt="<?php echo _i('All Credit Cards Supported');?>"/>
                                            <?php if($payment_settings->live_mode == 0):?>
                                                <br>

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

                                            <?php endif;?>
                                        </div>
                                        <div class="medium-8 columns">
                                            <label><?php echo _i('Credit Card Number'); ?>:
                                                <input type="text" placeholder="<?php echo _i('Credit Card Number'); ?>"  id="cc-number" data-stripe="number"
                                                       required="">
                                            </label>
                                        </div>
                                        <div class="medium-4 columns">
                                            <label><?php echo _i('CVV Number');?>:
                                                <input type="text" placeholder="<?php echo _i('CVV Number');?>">
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="setting-form-inner">
                                    <div class="row">
                                        <div class="large-12 columns">
                                            <h6 class="borderBottom"><?php echo _i('Expiration Date');?></h6>
                                        </div>
                                        <div class="medium-6 columns">
                                            <label>Month:
                                                <select class="form-control cc-expiration-month" data-stripe="exp-month"
                                                        id="cc-expiration-month">
                                                    <?php for($m = 1; $m <= 12; ++$m): ?>
                                                        <option value="<?php echo $m;?>"><?php echo date('F', mktime(0, 0, 0, $m, 1));?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </label>
                                        </div>
                                        <div class="medium-6 columns">
                                            <label>Year:
                                                <select class="form-control cc-expiration-year" data-stripe="exp-year"
                                                        id="cc-expiration-year">
                                                    <?php for ($year = date("Y"); $year <= (date("Y") + 15); $year++): ?>
                                                        <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                                    <?php endfor; ?>
                                                </select>
                                            </label>
                                        </div>
                                    </div>
                                </div>
                                <div class="setting-form-inner">
                                    <a href="<?php echo ($settings->enable_https) ? secure_url('user') : URL::to('user') ?><?php echo '/' . $user->username; ?>/billing"
                                       class="button button-danger"><?php echo _i('Cancel');?></a>
                                    <button class="button pull-right " type="submit" name="create-account"><?php echo _i('Update Credit Card');?></button>

                                </div>
                                <input name="_token" type="hidden" value="<?php echo csrf_token(); ?>">
                                <div class="payment-errors col-md-8 text-danger" style="display:none"></div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End profile settings -->
</div><!-- end left side content area -->

<script type="text/javascript" src="https://js.stripe.com/v2/"></script>
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
