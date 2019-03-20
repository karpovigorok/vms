@extends('admin.master')

@section('css')
    <style type="text/css">
        .make-switch {
            z-index: 2;
        }
    </style>
@stop

@section('content')


    <div id="admin-container">
        <!-- This is where -->

        <div class="admin-section-title">
            <h3><i class="entypo-globe"></i> <?php echo _i("Site Settings");?></h3>
        </div>
        <div class="clear"></div>
        <form method="POST" action="{{ URL::to('admin/settings') }}" accept-charset="UTF-8" file="1"
              enctype="multipart/form-data">

            <div class="row">

                <div class="col-md-4">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title"><?php echo _i("Site Language");?></div>
                            <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body" style="display: block;">
                            <p><?php echo _i("Choose website interface Language");?>:</p>
                            <select name="locale">
                                <?php foreach(Config::get('laravel-gettext.supported-locales') as $locale):?>
                                <option value="<?php echo $locale;?>" @if($settings->locale == $locale){{"selected"}}@endif><?php echo $locale;?></option>
                                <?php endforeach;?>
                            </select>

                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title"><?php echo _i("Site Name");?></div>
                            <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body" style="display: block;">
                            <p><?php echo _i("Enter Your Website Name Below");?>:</p>
                            <input type="text" class="form-control" name="website_name" id="website_name"
                                   placeholder="<?php echo _i("Site Title");?>"
                                   value="@if(!empty($settings->website_name)){{ $settings->website_name }}@endif"/>
                        </div>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title"><?php echo _i("Site Description");?></div>
                            <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body" style="display: block;">
                            <p><?php echo _i("Enter Your Website Description Below");?>:</p>
						<textarea class="form-control" name="website_description" id="website_description"
                                  placeholder="<?php echo _i("Site Description");?>">@if(!empty($settings->website_description)){{ $settings->website_description }}@endif
                        </textarea>
                        </div>
                    </div>
                </div>

            </div>

            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo _i("Logo");?></div>
                    <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="display: block; background:#f1f1f1;">
                    @if(!empty($settings->logo))
                        <span id="logo-preview"><img src="{{ $settings->logo }}" style="max-height:100px"/></span>
                        <button id="delete-logo" class="btn btn-xs btn-danger delete pull-right"><span
                                    class="fa fa-trash"></span> <?php echo _i("Delete");?></button>
                    @endif
                    <p><?php echo _i("Upload Your Site Logo");?>:</p>
                    <input type="file" multiple="true" class="form-control" name="logo" id="logo"/>

                </div>
            </div>

            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo _i("Favicon");?></div>
                    <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="display: block;">
                    @if(!empty($settings->favicon))
                        <span id="icon-preview"><img src="{{ $settings->favicon }}" style="max-height:20px"/></span>
                        <button id="delete-icon" class="btn btn-xs btn-danger delete pull-right"><span
                                    class="fa fa-trash"></span> <?php echo _i("Delete");?></button>
                    @endif
                    <p><?php echo _i("Upload Your Site Favicon");?>:</p>
                    <input type="file" multiple="true" class="form-control" name="favicon" id="favicon"/>

                </div>
            </div>

            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title"><?php echo _i("Demo Mode");?></div>
                            <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <p><?php echo _i("Enable Demo Account");?>:</p>

                            <div class="form-group">
                                <div class="make-switch" data-on="success" data-off="warning">
                                    <input type="checkbox"
                                           @if(isset($settings->demo_mode) && $settings->demo_mode == 1)checked="checked"
                                           value="1" @else value="0" @endif name="demo_mode" id="demo_mode"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title"><?php echo _i("Enable https:// sitewide");?></div>
                            <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <p><?php echo _i("Make sure you have purchased an SSL before anabling https://");?></p>

                            <div class="form-group">
                                <div class="make-switch" data-on="success" data-off="warning">
                                    <input type="checkbox"
                                           @if(!isset($settings->enable_https) || (isset($settings->enable_https) && $settings->enable_https))checked="checked"
                                           value="1" @else value="0" @endif name="enable_https" id="enable_https"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title"><?php echo _i("Video Comments");?></div>
                            <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-md-6 align-left">
                                    <p><?php echo _i("Enable Video Comments");?>:</p>

                                    <div class="form-group">
                                        <div class="make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox"
                                                   @if(!isset($settings->enable_video_comments) || (isset($settings->enable_video_comments) && $settings->enable_video_comments))checked="checked"
                                                   value="1" @else value="0" @endif name="enable_video_comments"
                                                   id="enable_video_comments"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 align-right">
                                    <p><?php echo _i("Comments Per Page");?>:</p>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="video_comments_per_page"
                                               id="video_comments_per_page"
                                               placeholder="<?php echo _i("# of Comments Per Page");?>"
                                               value="@if(!empty($settings->video_comments_per_page)){{ $settings->video_comments_per_page }}@endif"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title"><?php echo _i("Post Comments");?></div>
                            <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">

                            <div class="row">
                                <div class="col-md-6 align-left">
                                    <p><?php echo _i("Enable Post Comments");?>:</p>

                                    <div class="form-group">
                                        <div class="make-switch" data-on="success" data-off="warning">
                                            <input type="checkbox"
                                                   @if(!isset($settings->enable_post_comments) || (isset($settings->enable_post_comments) && $settings->enable_post_comments))checked="checked"
                                                   value="1" @else value="0" @endif name="enable_post_comments"
                                                   id="enable_post_comments"/>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 align-right">
                                    <p><?php echo _i("Comments Per Page");?>:</p>

                                    <div class="form-group">
                                        <input type="text" class="form-control" name="post_comments_per_page"
                                               id="post_comments_per_page"
                                               placeholder="<?php echo _i("# of Comments Per Page");?>"
                                               value="@if(!empty($settings->post_comments_per_page)){{ $settings->post_comments_per_page }}@endif"/>
                                    </div>
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-sm-6">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title"><?php echo _i("Videos Per Page");?></div>
                            <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <p><?php echo _i("Default number of videos to show per page:");?>:</p>
                            <input type="text" class="form-control" name="videos_per_page" id="videos_per_page"
                                   placeholder="<?php echo _i("# of Videos Per Page");?>"
                                   value="@if(!empty($settings->videos_per_page)){{ $settings->videos_per_page }}@endif"/>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title"><?php echo _i("Posts Per Page");?></div>
                            <div class="panel-options">
                                <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <p><?php echo _i("Default number of posts to show per page");?>:</p>
                            <input type="text" class="form-control" name="posts_per_page" id="posts_per_page"
                                   placeholder="<?php echo _i("# of Posts Per Page");?>"
                                   value="@if(!empty($settings->posts_per_page)){{ $settings->posts_per_page }}@endif"/>
                        </div>
                    </div>
                </div>

            </div>

            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo _i("Registration");?></div>
                    <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-4 align-center">
                            <p><?php echo _i("Enable Free Registration");?>:</p>

                            <div class="form-group">
                                <div class="make-switch" data-on="success" data-off="warning">
                                    <input type="checkbox"
                                           @if(!isset($settings->free_registration) || (isset($settings->free_registration) && $settings->free_registration))checked="checked"
                                           value="1" @else value="0" @endif name="free_registration"
                                           id="free_registration"/>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 align-center" id="activation_email_block"
                             style="<?php if(isset($settings->free_registration) && $settings->free_registration): ?>display:block;<?php else: ?>display:none<?php endif; ?>">
                            <p><?php echo _i("Require users to verify account by email");?>:</p>

                            <div class="form-group">
                                <div class="make-switch" data-on="success" data-off="warning">
                                    <input type="checkbox"
                                           @if(!isset($settings->activation_email) || (isset($settings->activation_email) && $settings->activation_email))checked="checked"
                                           value="1" @else value="0" @endif name="activation_email"
                                           id="activation_email"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-4 align-center" id="premium_upgrade_block"
                             style="<?php if(isset($settings->free_registration) && $settings->free_registration): ?>display:block;<?php else: ?>display:none<?php endif; ?>">
                            <p><?php echo _i("Enable registered users ability to upgrade to subscriber");?>:</p>

                            <div class="form-group">
                                <div class="make-switch" data-on="success" data-off="warning">
                                    <input type="checkbox"
                                           @if(!isset($settings->premium_upgrade) || (isset($settings->premium_upgrade) && $settings->premium_upgrade))checked="checked"
                                           value="1" @else value="0" @endif name="premium_upgrade"
                                           id="premium_upgrade"/>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo _i("System Email");?></div>
                    <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="display: block;">
                    <p><?php echo _i("Email address to be used to send system emails");?>:</p>
                    <input type="text" class="form-control" name="system_email" id="system_email"
                           placeholder="<?php echo _i("Email Address");?>"
                           value="@if(!empty($settings->system_email)){{ $settings->system_email }}@endif"/>
                </div>
            </div>

            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo _i("Social Networks");?></div>
                    <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="display: block;">

                    <p><?php echo _i("Facebook Page: ex. facebook.com/page_id (with facebook.com)");?>:</p>
                    <input type="text" class="form-control" name="facebook_page_id" id="facebook_page_id"
                           placeholder="<?php echo _i("Facebook URL");?>"
                           value="@if(!empty($settings->facebook_page_id)){{ $settings->facebook_page_id }}@endif"/>
                    <br/>

                    <p><?php echo _i("Google Plus");?>:</p>
                    <input type="text" class="form-control" name="google_page_id" id="google_page_id"
                           placeholder="<?php echo _i("Google Plus URL");?>"
                           value="@if(!empty($settings->google_page_id)){{ $settings->google_page_id }}@endif"/>
                    <br/>

                    <p><?php echo _i("Twitter");?>:</p>
                    <input type="text" class="form-control" name="twitter_page_id" id="twitter_page_id"
                           placeholder="<?php echo _i("Twitter URL");?>"
                           value="@if(!empty($settings->twitter_page_id)){{ $settings->twitter_page_id }}@endif"/>
                    <br/>

                    <p><?php echo _i("YouTube ex. youtube.com/channel_name");?>:</p>
                    <input type="text" class="form-control" name="youtube_page_id" id="youtube_page_id"
                           placeholder="<?php echo _i("YouTube URL");?>"
                           value="@if(!empty($settings->youtube_page_id)){{ $settings->youtube_page_id }}@endif"/>
                    <br/>

                    <p><?php echo _i("Instagram ex. instagram.com/user_name");?>:</p>
                    <input type="text" class="form-control" name="instagram_page_id" id="instagram_page_id"
                           placeholder="<?php echo _i("Instagram URL");?>"
                           value="@if(!empty($settings->instagram_page_id)){{ $settings->instagram_page_id }}@endif"/>
                    <br/>

                    <p><?php echo _i("Vimeo ex. vimeo.com/user_name");?>:</p>
                    <input type="text" class="form-control" name="vimeo_page_id" id="vimeo_page_id"
                           placeholder="<?php echo _i("Vimeo URL");?>"
                           value="@if(!empty($settings->vimeo_page_id)){{ $settings->vimeo_page_id }}@endif"/>

                </div>
            </div>
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        <?php echo _i("Google Analytics Tracking ID");?></div>
                    <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="display: block;">
                    <p><?php echo _i("Google Analytics Tracking ID (ex. UA-12345678-9)");?>
                        [<a href="https://analytics.google.com/" target="_blank"><?php echo _i('Get The Code');?><i class="fa fa-external-link" aria-hidden="true"></i></a>]:</p>
                    <input type="text" class="form-control" name="google_tracking_id" id="google_tracking_id"
                           placeholder="<?php echo _i("Google Analytics Tracking ID");?>"
                           value="@if(!empty($settings->google_tracking_id)){{ $settings->google_tracking_id }}@endif"/>
                </div>
            </div>
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title">
                        <?php echo _i("Google Tag Manager ID");?></div>
                    <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="display: block;">
                    <p><?php echo _i("Google Tag Manager ID (ex. GTM-1234567)");?>
                        [<a href="https://tagmanager.google.com/" target="_blank"><?php echo _i('Get The Code');?><i class="fa fa-external-link" aria-hidden="true"></i></a>]:</p>
                    <input type="text" class="form-control" name="google_tag_id" id="google_tag_id"
                           placeholder="<?php echo _i("Google Tag Manager ID");?>"
                           value="@if(!empty($settings->google_tag_id)){{ $settings->google_tag_id }}@endif"/>
                </div>
            </div>
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo _i("Google Analytics API Integration (This will integrate with your dashboard analytics)");?></div>
                    <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="display: block;">
                    <p><?php echo _i("Google Oauth Client ID Key");?>:</p>
                    <input type="text" class="form-control" name="google_oauth_key" id="google_oauth_key"
                           placeholder="<?php echo _i("Google Client ID Key");?>"
                           value="@if(!empty($settings->google_oauth_key)){{ $settings->google_oauth_key }}@endif"/>
                </div>
            </div>

            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
            <input type="submit" value="Update Settings" class="btn btn-success pull-right"/>
        </form>
        <div class="clear"></div>
    </div><!-- admin-container -->

@section('javascript')
    <script src="{{ '/application/assets/admin/js/bootstrap-switch.min.js' }}"></script>
    <script type="text/javascript">
        $ = jQuery;
        $(document).ready(function () {
            $("#delete-logo").click(function () {
                $.ajax("/admin/theme_settings/delete/logo").done(function () {
                    $("#logo-preview").html('');
                    $(this).hide();
                    toastr.success("<?php echo _i('Successfully Deleted Logo!');?>", "<?php echo _i('Sweet Success!');?>", opts);
                });
                return false;
            });
            $("#delete-icon").click(function () {

                $.ajax("/admin/theme_settings/delete/favicon").done(function () {
                    $("#icon-preview").html('');
                    $(this).hide();
                    toastr.success("<?php echo _i('Successfully Deleted Icon!');?>", "<?php echo _i('Sweet Success!');?>", opts);
                });
                return false;
            });
            $('input[type="checkbox"]').change(function () {
                if ($(this).is(":checked")) {
                    $(this).val(1);
                } else {
                    $(this).val(0);
                }
            });
            $('#free_registration').change(function () {
                if ($(this).is(":checked")) {
                    $('#activation_email_block').fadeIn();
                    $('#premium_upgrade_block').fadeIn();
                } else {
                    $('#activation_email_block').fadeOut();
                    $('#premium_upgrade_block').fadeOut();
                }
            });
        });
    </script>
@stop
@stop