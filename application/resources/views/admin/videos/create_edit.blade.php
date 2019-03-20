@extends('admin.master')

@section('css')
    <link rel="stylesheet" href="{{ '/application/assets/js/tagsinput/jquery.tagsinput.css' }}"/>
@stop


@section('content')

    <div id="admin-container">
        <!-- This is where -->

        <div class="admin-section-title">
            @if(!empty($video->id))
                <h3>{{ $video->title }}</h3>
            @else
                <h3><i class="entypo-plus"></i> <?php echo _i("Add New Video");?></h3>
            @endif

            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                @if(!empty($video->id))
                <li role="presentation" class="active"><a href="" aria-controls="home" role="tab" data-toggle="tab">General</a></li>
                <li role="presentation"><a href="{{ URL::to('admin/videos/seo') . '/' . $video->id }}" aria-controls="profile" role="tab"><?php echo _i('SEO');?></a></li>
                <a href="{{ URL::to('video') . '/' . $video->id }}" target="_blank" class="btn btn-info pull-right">
                    <i class="fa fa-eye"></i> <?php echo _i("Preview");?> <i class="fa fa-external-link"></i>
                </a>
                @endif
            </ul>

        </div>
        <div class="clear"></div>
        <form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

            @if(!empty($video->created_at))
                <div class="row">
                    <div class="col-md-9">
                        @endif
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title"><?php echo _i("Title");?></div>
                                <div class="panel-options"><a href="#" data-rel="collapse"><i
                                                class="entypo-down-open"></i></a></div>
                            </div>
                            <div class="panel-body" style="display: block;">
                                <p><?php echo _i("Add the video title in the textbox below");?>:</p>
                                <input required type="text" class="form-control" name="title" id="title"
                                       placeholder="<?php echo _i("Video Title");?>"
                                       value="@if(!empty($video->title)){{ $video->title }}@endif"/>
                            </div>
                        </div>

                        @if(!empty($video->created_at))

                    </div>
                    <div class="col-sm-3">
                        <div class="panel panel-primary" data-collapsed="0">
                            <div class="panel-heading">
                                <div class="panel-title"><?php echo _i("Created Date");?></div>
                                <div class="panel-options"><a href="#" data-rel="collapse"><i
                                                class="entypo-down-open"></i></a></div>
                            </div>
                            <div class="panel-body" style="display: block;">
                                <p><?php echo _i("Select Date/Time Below");?></p>
                                <input type="text" class="form-control" name="created_at" id="created_at" placeholder=""
                                       value="@if(!empty($video->created_at)){{ $video->created_at }}@endif"/>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo _i("Video Source");?></div>
                    <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a></div>
                </div>
                <div class="panel-body" style="display: block;">
                    <?php if(empty($video->id)):?>

                    <label for="type" style="float:left; margin-right:10px; padding-top:1px;"><?php echo _i('Video Format');?></label>
                    <select id="type" name="type">

                        <option value="file" @if(!empty($video->type) && $video->type == 'file'){{ 'selected' }}@endif>
                            <?php echo _i('Video File');?>
                        </option>
                        <option value="embed"><?php echo _i("Embed Code");?></option>
                    </select>
                    <hr/>
                        <div class="new-video-file" @if(!empty($video->type) && $video->type == 'file'){{ 'style="display:block"' }}@endif>
                        <label for="video_file"><?php echo _i("Choose the video file: (%s)", $allowed_extensions_string);?>:</label>
                        <input id="fileupload" type="file" name="file" data-url="/upload-advanced"
                               class="form-control" accept="<?php echo $allowed_mime_string;?>">
                        <span id="uploading-status"></span>
                    </div>

                    <div class="new-video-embed"
                         @if(!empty($video->type) && $video->type == 'file')style="display:none"@endif>
                        <label for="embed_code"><?php echo _i("Embed Code");?>:</label>
                        <textarea class="form-control" name="embed_code"
                                  id="embed_code">@if(!empty($video->embed_code)){{ $video->embed_code }}@endif</textarea>
                    </div>
                    <?php else:?>
                    <?php if($video->type == 'embed'): ?>
                    <?php echo $video->embed_code ?>
                    <?php else:
                        $site_video_dimensions = Config::get('site.video.dimensions');
                        ?>
                        <video id="video_1" class="video-js vjs-default-skin"  controls preload="auto"
                               poster="<?php echo ImageHandler::getImage($video->image, '800x400') ?>"
                               data-setup="{}" width="100%" style="width:100%;" height="370">
                            <?php if(Config::get('site.video.convert') && sizeof($site_video_dimensions)):?>

                            <?php foreach ($site_video_dimensions as $key_video_dimension => $video_dimension) :?>
                            <source src="<?php echo Config::get('site.uploads_dir') . "/video/" . $video->get_dir_path() . "/converted/" . $key_video_dimension . ".mp4"; ?>"
                                    label='<?php echo _i($key_video_dimension)?>' res="<?php echo $video_dimension['height']?>" type='<?php echo $video->mime_type;?>' selected="true">
                            <?php endforeach; ?>
                            <?php else:?>
                                <source src="<?php echo Config::get('site.uploads_dir') . "/video/" . $video->path . $video->original_name; ?>"
                                        type='<?php echo $video->mime_type;?>'>
                            <?php endif;?>
                            <p class="vjs-no-js"><?php echo _i("To view this video please enable JavaScript, and consider upgrading to a web browser that <a href='%s' target='_blank'>supports HTML5 video</a>", "http://videojs.com/html5-video-support/");?></p>
                        </video>
                    <?php endif; ?>
                    <?php endif ?>
                </div>
            </div>
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo _i("Video Image Cover");?></div>
                    <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="display: block;">
                    <input type="button" name="get-new-thumbs" id="get-new-thumbs" value="<?php echo _i('Get New');?>"
                           class="btn btn-primary pull-right"
                           style="display:<?php echo (!empty($video->id) && $video->type == 'file' && Config::get('site.video.convert'))?'block':'none';?>">
                    @if(!empty($video->image))
                        <img src="{{ ImageHandler::getImage($video->image, '370x220') }}" class="video-img" id="active-video-cover" width="370"/>
                    @else
                        <img src="/application/assets/img/blur-background/2.jpg" class="video-img" id="active-video-cover" width="370"/>
                    @endif

                    <div class="row">
                        <?php echo _i("Select the video image (%s px or %s ratio)", ["1280x720", "16:9"]);?>:</p>
                        <input type="file" multiple="true" class="form-control" name="image" id="image"/>
                    </div>
                    <div id="video_thumbs"></div>
                </div>
            </div>
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo _i("Description");?></div>
                    <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="display: block;">
                    <p><?php echo _i("Add a description of the video below");?>:</p>
                    <textarea class="form-control" name="description"
                              id="description">@if(!empty($video->description)){{ htmlspecialchars($video->description) }}@endif</textarea>
                </div>
            </div>

            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo _i("Category");?></div>
                    <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="display: block;">
                    <p><?php echo _i("Select a Video Category Below");?>:</p>
                    <select id="video_category_id" name="video_category_id">
                        <option value="0"><?php echo _i('Uncategorized');?></option>
                        @foreach($video_categories as $category)
                            <option value="{{ $category->id }}"
                                    @if(!empty($video->video_category_id) && $video->video_category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo _i("Tags");?></div>
                    <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                    </div>
                </div>
                <div class="panel-body" style="display: block;">
                    <p><?php echo _i("Add video tags below");?>:</p>
                    <input class="form-control" name="tags" id="tags"
                           value="@if(!empty($video) && $video->tags->count() > 0)@foreach($video->tags as $tag){{ $tag->name . ', ' }}@endforeach @endif">
                </div>
            </div>
            <div class="clear"></div>
            <div class="row">
                <div class="col-sm-4">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title"> <?php echo _i("Duration");?></div>
                            <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <p><?php echo _i("Enter the video duration in the following format (Hours : Minutes : Seconds)");?></p>
                            <input class="form-control" name="duration" id="duration"
                                   value="@if(!empty($video->duration)){{ gmdate('H:i:s', $video->duration) }}@endif">
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title"> <?php echo _i("User Access");?></div>
                            <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <label for="access" style="float:left; margin-right:10px;">
                                <?php echo _i("Who is allowed to view this video?");?></label>
                            <select id="access" name="access">
                                <option value="guest" @if(!empty($video->access) && $video->access == 'guest'){{ 'selected' }}@endif>
                                    <?php echo _i("Guest (everyone)");?>
                                </option>
                                <option value="registered" @if(!empty($video->access) && $video->access == 'registered'){{ 'selected' }}@endif>
                                    <?php echo _i("Registered Users (free registration must be enabled)");?>
                                </option>
                                <option value="subscriber" @if(!empty($video->access) && $video->access == 'subscriber'){{ 'selected' }}@endif>
                                    <?php echo _i("Subscriber (only paid subscription users)");?>
                                </option>
                            </select>

                            <div class="clear"></div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-4">
                    <div class="panel panel-primary" data-collapsed="0">
                        <div class="panel-heading">
                            <div class="panel-title"> <?php echo _i("Status Settings");?></div>
                            <div class="panel-options"><a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div>
                                <label for="featured" style="float:left; display:block; margin-right:10px;">
                                    <?php echo _i("Is this video Featured");?>:</label>
                                <input type="checkbox"
                                       @if(!empty($video->featured) && $video->featured == 1){{ 'checked="checked"' }}@endif name="featured"
                                       value="1" id="featured"/>
                            </div>
                            <div class="clear"></div>
                            <div>
                                <label for="active" style="float:left; display:block; margin-right:10px;">Is this video
                                    <?php echo _i("Active");?>:</label>
                                <input type="checkbox"
                                       @if(!empty($video->active) && $video->active == 1){{ 'checked="checked"' }}@elseif(!isset($video->active)){{ 'checked="checked"' }}@endif name="active"
                                       value="1" id="active"/>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <!-- row -->

            @if(!isset($video->user_id))
                <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}"/>
            @endif
            @if(isset($video->id))
                <input type="hidden" id="id" name="id" value="{{ $video->id }}"/>
            @else
                <input type="hidden" id="id" name="id" value="0"/>
            @endif
            <input type="hidden" id="process-status" name="process-status" value=""/>
            <input type="hidden" name="_token" value="<?= csrf_token() ?>"/>
            <input type="submit" value="{{ $button_text }}" id="add-video-button" class="btn btn-success pull-right @if(empty($video->id)) {{'disabled'}}@endif"/>
        </form>
        <div class="clear"></div>
        <!-- This is where now -->
    </div>

@section('javascript')
    <script type="text/javascript" src="{{ '/application/assets/admin/js/tinymce/tinymce.min.js' }}"></script>
    <script type="text/javascript" src="{{ '/application/assets/js/tagsinput/jquery.tagsinput.min.js' }}"></script>
    <script type="text/javascript" src="{{ '/application/assets/js/jquery.mask.min.js' }}"></script>
    <script src="{{ '/application/assets/js/jquery-file-upload/js/vendor/jquery.ui.widget.js' }}"></script>
    <script src="{{ '/application/assets/js/jquery-file-upload/js/jquery.iframe-transport.js' }}"></script>
    <script src="{{ '/application/assets/js/jquery-file-upload/js/jquery.fileupload.js' }}"></script>
    <script>
        var loaded = false;
        $(function () {
            $('#fileupload').fileupload({
                dataType: 'json',
                maxChunkSize: 2000000, // 10 MB

                done: function (e, data) {
                    console.log('done');
                    console.log(data.result);
                    $("#uploading-progress").text('100');
                    $("#add-video-button").removeClass('disabled');
                    $("#uploading-status").html('File Uploaded. <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
                    if (data.result.id !== undefined) {
                        $("#id").val(data.result.id);
                    }
                    var refreshId = window.setInterval(function () {
                        /// call your function here

                        $.get("/api/v1/video_file_status/" + data.result.id, function (data) {
                            $('#process-status').val(data.process_status);

                            if(data.process_status > 0 && !loaded && data.convert) {
                                $("#uploading-status").html('Generation Preview. <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
                                generate_video_thumbs();
                                $("#get-new-thumbs").show();
                                $("#uploading-status").html('<?php echo _i("Converting in progress.");?> <i class="fa fa-spinner fa-spin" style="font-size:24px"></i>');
                                loaded = true;
                            }
                            if(data.process_status == 1) {
                                $("#uploading-status").html('<?php echo _i("Done!");?>');
                                window.clearInterval(refreshId);
                            }
                        });
                    }, 1000);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    $("#uploading-status").html('<p class="text-danger">' + jqXHR.responseJSON.error + '</p>');
                    return false;
                },
                start: function (e, data) {
                    $('#process-status').val(0);
                    $("#uploading-status").html('Uploading progress: <span id="uploading-progress">0</span>%');
                }
            })
                    .on('fileuploadchunksend', function (e, data) {
                    })
                    .on('fileuploadchunkdone', function (e, data) {
                        console.log(data.result);
                        if (data.result.status) {
                            $("#uploading-progress").text(data.result.done);
                        }
                    })
                    .on('fileuploadchunkfail', function (e, data) {
                        console.log(data.messages);
                        $("#uploading-status").append('<p class="text-danger"><?php echo _i("Something went wrong. Can\'t upload file.");?></p>');
                    })
                    .on('fileuploadchunkalways', function (e, data) {
                    });
        });
        function click_thumb(obj) {
            $("#video_thumbs img").removeClass("admin-border-image");
            $(obj).addClass("admin-border-image");
            $("#active-video-cover").attr('src', $(obj).attr('src'));
            $.post("/admin/videos/thumb_update",
                    {
                        id: $("#id").val(),
                        thumb: $(obj).attr('src'),
                        "_token": "<?php echo csrf_token() ?>",
                    }).done(function (data) {
                        return true;
                    });
        }
        function generate_video_thumbs() {
            $.get("/api/v1/generate_thumbs/" + $("#id").val(), function (data) {
                console.log(data);
                if (data.thumbs.length > 0) {
                    //$("#video_thumbs").html();
                    var i = 0;
                    $("#video_thumbs").html("");
                    for (var thumb in data.thumbs) {
                        $("#video_thumbs").append("<div style='margin: 10px;' class='pull-left'>" +
                            "<img onclick='click_thumb(this);' src='" + data.thumbs[thumb] + "' width='190' data-number='" + i + "'></div>");
                        i++;
                    }
                }
                return true;
            });
        }
    </script>
    <script type="text/javascript">
        $ = jQuery;
        $(document).ready(function () {
            $('#get-new-thumbs').click(function() {
                generate_video_thumbs();
                return false;
            });

            $('#duration').mask('00:00:00');
            $('#tags').tagsInput();

            $('#type').change(function () {
                if ($(this).val() == 'embed') {
                    $('.new-video-file').hide();
                    $('.new-video-embed').show();
                    $("#add-video-button").removeClass('disabled');
                } else {
                    $('.new-video-file').show();
                    $('.new-video-embed').hide();
                    $("#add-video-button").addClass('disabled');
                }
            });
            window.onbeforeunload = function() {
                if($('#process-status').val() === '0') {
                    return "<?php echo _i("Are you sure you want to navigate away?");?>";
                }
            }
            tinymce.init({
                relative_urls: false,
                selector: '#description',
                toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor | code",
                plugins: [
                    "advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker code fullscreen",
                    "save table contextmenu directionality emoticons template paste textcolor code"
                ],
                menubar:false,
            });

        });
    </script>

@stop

@stop
