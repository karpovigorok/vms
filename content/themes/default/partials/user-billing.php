<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
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
                    <h4><?php echo _i('Billing Information');?></h4>
                </div>
                <div class="row">
                    <div class="large-12 columns">
                        <div class="setting-form">
                            <form method="post">
                                <?php if(count($invoices)):?>
                                <div class="setting-form-inner">
                                    <div class="row">
                                        <div class="large-12 columns">
                                            <h6 class="borderBottom"><i class="fa fa-usd"></i> <?php echo _i('Past Invoices');?></h6>
                                        </div>
                                        <div class="large-12 columns">
                                            <?php foreach ($invoices as $invoice): ?>
                                            <div class="medium-3 columns"><?php echo $invoice->date()->toFormattedDateString(); ?></div>
                                            <div class="medium-8 columns"><a href="<?php echo $invoice->invoice_pdf;?>" target="_blank"><?php echo $invoice->lines->data[0]->description;?></a></div>
                                            <div class="medium-1 columns"><?php echo $invoice->total(); ?></div>
                                            <?php endforeach; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endif;?>
                                <div class="setting-form-inner">
                                    <div class="row">
                                        <?php if ($user->subscribed('main') && $user->subscription('main')->onGracePeriod()): ?>
                                            <div class="well">
                                                <p><?php
                                                    echo _i('You have cancelled your subscription and your account will be active until %s', $user->subscription('main')->ends_at->format('F j, Y, g:i a'));?></p>
                                                <p><?php echo _i('Still want to be a subscriber?');?></p>
                                                <a href="<?php echo ($settings->enable_https) ? secure_url('user') : URL::to('user') ?><?php echo '/' . $user->username; ?>/resume"
                                                   class="button"><?php echo _i('Click Here to Re-activate your Account');?></a>
                                            </div>
                                        <?php elseif ($user->subscribed('main')): ?>
                                            <div class="large-12 columns">
                                                <h6 class="borderBottom"><i class="fa fa-credit-card"></i> <?php echo _i('Credit Card');?> <?php if ($user->last_four): ?>(<?php echo _i('Ending in %s', $user->last_four);?>)<?php endif; ?></h6>
                                            </div>
                                            <div class="large-12 columns margin-bottom-10">
                                                <a href="<?php echo ($settings->enable_https) ? secure_url('user') : URL::to('user') ?><?php echo '/' . $user->username; ?>/update_cc"
                                                   class="button"><?php echo _i('Update Your Credit Card');?></a>

                                            </div>
                                            <div class="large-12 columns">
                                                <h6 class="borderBottom"><i class="fa fa-warning"></i> <?php echo _i('Danger Zone');?></h6>
                                                <a class="button button-danger" id="cancel-account"
                                                   href="<?php echo ($settings->enable_https) ? secure_url('user') : URL::to('user') ?><?php echo '/' . $user->username; ?>/cancel"><?php echo _i('Cancel My Account');?></a>
                                            </div>
                                            <script>
                                                $(document).ready(function () {
                                                    var delete_link = '';

                                                    $('#cancel-account').click(function (e) {
                                                        e.preventDefault();
                                                        delete_link = $(this).attr('href');
                                                        swal({
                                                            title: "<?php echo _i("Warning!");?>",
                                                            text: "<?php echo _i('Are you sure you want to cancel?');?>",
                                                            type: "warning",
                                                            showCancelButton: true,
                                                            confirmButtonColor: "#DD6B55",
                                                            confirmButtonText: "<?php echo _i("Yes, Cancel My Account");?>",
                                                            closeOnConfirm: false
                                                        }, function () {
                                                            window.location = delete_link
                                                        });
                                                        return false;
                                                    });

                                                    $('.cancel-account').click(function () {
                                                        $('.cancel-account-confirmation').slideDown();
                                                    });
                                                    $('.cancel-cancel').click(function () {
                                                        $('.cancel-account-confirmation').slideUp();
                                                    });
                                                });
                                            </script>
                                        <?php else: ?>
                                            <div class="well">
                                                <p><?php echo _i('It looks like your account has been cancelled.');?></p>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section><!-- End Comments -->
</div>
<link rel="stylesheet" href="/application/assets/admin/css/sweetalert.css">
<script src="/application/assets/admin/js/sweetalert.min.js"></script>



