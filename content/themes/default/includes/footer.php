<?php /**
    *
    * Copyright (c) 2019
    * @package VMS - Video CMS v1.1
    * @author Igor Karpov <ika@noxls.net>
    * @author Sergey Karpov <ska@noxls.net>
    * @website https://noxls.net
    *
*/?>
<!-- footer -->
<footer>
    <div class="row">
        <div class="large-3 medium-6 columns">
            <?php echo Widget::run('aboutText'); ?>
        </div>
        <div class="large-3 medium-6 columns">
            <?php echo Widget::run('recentVideos', ['excluded_video_ids' => isset($excluded_video_ids) ? $excluded_video_ids : []]); ?>
        </div>
        <div class="large-3 medium-6 columns">
            <?php echo Widget::run('videoCategoriesCloud'); ?>
        </div>
        <div class="large-3 medium-6 columns">
            <?php // echo Widget::run('subscribeNow'); ?>
            <?php echo Widget::run('socialBunch'); ?>
        </div>
    </div>
    <a href="#" id="back-to-top" title="Back to top"><i class="fa fa-angle-double-up"></i></a>
</footer><!-- footer -->
<div id="footer-bottom">
    <div class="logo text-center">
        <?php if ($settings->logo != ''): ?>
            <img src="<?php echo ImageHandler::getImage($settings->logo); ?>"
                 alt="<?php echo $settings->website_name; ?>" width="100">
        <?php else: ?>
            <img src="<?php echo THEME_URL . '/assets/images/logo-small.png'; ?>" alt="logo">
        <?php endif; ?>
    </div>
    <div class="btm-footer-text text-center">
        <p><?php echo date('Y'); ?> &copy; <?php echo $settings->website_name; ?></p>
    </div>
</div>
</div><!--end off canvas content-->
</div><!--end off canvas wrapper inner-->
</div><!--end off canvas wrapper-->


<!-- script files -->
<script src="<?php echo THEME_URL . '/assets/bower_components/jquery/dist/jquery.js'; ?>"></script>
<script src="<?php echo THEME_URL . '/assets/bower_components/what-input/what-input.js'; ?>"></script>
<script src="<?php echo THEME_URL . '/assets/bower_components/foundation-sites/dist/foundation.js'; ?>"></script>
<script src="<?php echo THEME_URL . '/assets/js/jquery.showmore.src.js" type="text/javascript'; ?>"></script>
<script src="<?php echo THEME_URL . '/assets/js/app.js'; ?>"></script>
<script src="<?php echo THEME_URL . '/assets/layerslider/js/greensock.js'; ?>" type="text/javascript"></script>
<!-- LayerSlider script files -->
<script src="<?php echo THEME_URL . '/assets/layerslider/js/layerslider.transitions.js'; ?>"
        type="text/javascript"></script>
<script src="<?php echo THEME_URL . '/assets/layerslider/js/layerslider.kreaturamedia.jquery.js'; ?>"
        type="text/javascript"></script>
<script src="<?php echo THEME_URL . '/assets/js/owl.carousel.min.js'; ?>"></script>
<script src="<?php echo THEME_URL . '/assets/js/inewsticker.js'; ?>" type="text/javascript"></script>
<script src="<?php echo THEME_URL . '/assets/js/jquery.kyco.easyshare.js'; ?>" type="text/javascript"></script>


<script src="<?php echo THEME_URL . '/assets/js/bootstrap.min.js'; ?>"></script>
<script src="<?php echo THEME_URL . '/assets/js/moment.min.js'; ?>"></script>
<script type="text/javascript" src="<?php echo THEME_URL . '/assets/js/noty/jquery.noty.js'; ?>"></script>
<script type="text/javascript" src="<?php echo THEME_URL . '/assets/js/noty/themes/default.js'; ?>"></script>
<script type="text/javascript" src="<?php echo THEME_URL . '/assets/js/noty/layouts/top.js'; ?>"></script>

<script type="text/javascript">

    $('document').ready(function () {

        $('.dropdown').hover(function () {
            $(this).addClass('open');
        }, function () {
            $(this).removeClass('open');
        });

        <?php if(Session::get('note') != '' && Session::get('note_type') != ''): ?>
        var n = noty({
            text: '<?php echo str_replace("'", "\\'", Session::get("note")) ?>',
            layout: 'top',
            type: '<?php echo Session::get("note_type") ?>',
            template: '<div class="noty_message"><span class="noty_text"></span><div class="noty_close"></div></div>',
            closeWith: ['button'],
            timeout: 1600
        });
        <?php Session::forget('note');
              Session::forget('note_type');
        ?>
        <?php endif; ?>

        $('#nav-toggle').click(function () {
            $(this).toggleClass('active');
            $('.navbar-collapse').toggle();
            $('body').toggleClass('nav-open');
        });

        $('#mobile-subnav').click(function () {
            if ($('.second-nav .navbar-left').css('display') == 'block') {
                $('.second-nav .navbar-left').slideUp(function () {
                    $(this).addClass('not-visible');
                });
                $(this).html('<i class="fa fa-bars"></i> Open Submenu');
            } else {
                $('.second-nav .navbar-left').slideDown(function () {
                    $(this).removeClass('not-visible');
                });
                $(this).html('<i class="fa fa-close"></i> Close Submenu');
            }

        });

    });


    /********** LOGIN MODAL FUNCTIONALITY **********/

    var loginSignupModal = $('<div class="modal fade" id="loginSignupModal" tabindex="-1" role="dialog" aria-hidden="true"><div class="modal-dialog"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><h4 class="modal-title" id="myModalLabel">Login Below</h4></div><div class="modal-body"></div></div></div></div>');

    $(document).ready(function () {

        // Load the Modal Window for login signup when they are clicked
        $('.login-desktop a').click(function (e) {
            e.preventDefault();
            $('body').prepend(loginSignupModal);
            $('#loginSignupModal .modal-body').load($(this).attr('href') + '?redirect=' + document.URL + ' .form-signin', function () {
                $('#loginSignupModal').show(200, function () {
                    setTimeout(function () {
                        $('#email').focus()
                    }, 300);


                });
                $('#loginSignupModal').modal();

            });

            // Be sure to remove the modal from the DOM after it is closed
            $('#loginSignupModal').on('hidden.bs.modal', function (e) {
                $('#loginSignupModal').remove();
            });

        });


    });

    /********** END LOGIN MODAL FUNCTIONALITY **********/

</script>

<?php
if (isset($settings->google_tracking_id) && $settings->google_tracking_id != ''): ?>
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=<?php echo $settings->google_tracking_id; ?>"></script>
    <script>
        window.dataLayer = window.dataLayer || [];
        function gtag() {
            dataLayer.push(arguments);
        }
        gtag('js', new Date());
        gtag('config', '<?php echo $settings->google_tracking_id; ?>');
    </script>
<?php endif; ?>
<?php if (isset($theme_settings->custom_js) && $theme_settings->custom_js != ''): ?>
<script><?php echo \App\Libraries\ThemeHelper::getThemeSetting($theme_settings->custom_js, '') ?></script>
<?php endif; ?>
</body>
</html>