@extends('admin.master')

@section('css')
    <link rel="stylesheet" href="{{ '/application/assets/js/tagsinput/jquery.tagsinput.css' }}"/>
@stop


@section('content')

    <div id="admin-container">
        <!-- This is where -->

        <div class="admin-section-title">
            @if(!empty($seoble_article->id))
                <h3>{{ $seoble_article_title }}</h3>
            @else
                <h3><i class="entypo-plus"></i> <?php echo _i("Add New Video");?></h3>
            @endif
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" role="tablist">
                <?php if($article_type != 'video-categories'):?>
                <li role="presentation"><a href="{{ URL::to('admin/' . $article_type . '/edit') . '/' . $seoble_article->id }}" aria-controls="home" role="tab"><?php echo _i('General');?></a></li>
                <?php else:?>
                <li role="presentation"><a href="{{ URL::to('/admin/videos/categories')}}" aria-controls="home" role="tab"><?php echo _i('Back to Categories List');?></a></li>
                <?php endif;?>
                <li role="presentation" class="active"><a href="#seo" aria-controls="profile" role="tab" data-toggle="tab"><?php echo _i('SEO');?></a></li>
            </ul>
        </div>
        <div class="clear"></div>
        <form method="POST" action="{{ $post_route }}" accept-charset="UTF-8">
            <div class="panel panel-primary" data-collapsed="0">
                <div class="panel-heading">
                    <div class="panel-title"><?php echo _i("SEO");?></div>
                    <div class="panel-options">
                        <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a></div>
                </div>
                <div class="panel-body" style="display: block;">

                    <p><?php echo _i("Disable For Crawlers");?>:</p>

                        <div class="form-group">
                            <div class="make-switch" data-on="success" data-off="warning">
                                <input type="checkbox"
                                       @if(isset($seoble_article->seo->noindex) && $seoble_article->seo->noindex)checked="checked"
                                       value="1" @else value="0" @endif name="seo[noindex]"
                                       id="seo_noindex"/>
                            </div>
                        </div>


                    <p><?php echo _i("Meta Title");?>:</p>
                    <input type="text" class="form-control" name="seo[title]" id="seo_title"
                           placeholder="<?php echo _i("Meta Title");?>"
                           value="@if(!empty($seoble_article->seo->title)){{ $seoble_article->seo->title }}@endif"/>
                    <br>
                    <p><?php echo _i("Meta Description");?>:</p>
                    <textarea class="form-control" name="seo[description]" placeholder="<?php echo _i("Meta Description");?>" id="seo_description">@if(!empty($seoble_article->seo->description )){{ $seoble_article->seo->description  }}@endif</textarea>
                    <br>
                    <p><?php echo _i("Meta Keywords");?>:</p>
                    <input type="text" class="form-control" name="seo[keywords]" id="seo_keywords"
                           placeholder="<?php echo _i("Meta Keywords");?>"
                           value="@if(!empty($seoble_article->seo->keywords)){{ implode(', ', json_decode($seoble_article->seo->keywords)) }}@endif"/>
                    <br>
                    <h4><?php echo _i('Open Graph');?></h4>
                    <p><?php echo _i("Title");?>:</p>
                    <input type="text" class="form-control" name="seo[extras][og][title]" id="seo_extras_og_title"
                           placeholder="<?php echo _i("Open Graph Title");?>"
                           value="@if(!empty($seoble_article->seo->extras['og']['title'])){{ $seoble_article->seo->extras['og']['title'] }}@endif"/>
                    <br>
                    <p><?php echo _i("Description");?>:</p>
                    <textarea placeholder="<?php echo _i('Open Graph Description');?>" class="form-control" name="seo[extras][og][description]" id="seo_extras_og_description">@if(!empty($seoble_article->seo->extras['og']['description'] )){{ $seoble_article->seo->extras['og']['description']  }}@endif</textarea>
                    <br>
                    <p><?php echo _i("Open Graph Image like http://...");?>:</p>
                    <input type="text" class="form-control" name="seo[extras][og][image]" id="seo_extras_og_image"
                           placeholder="<?php echo _i("Open Graph Image");?>"
                           value="@if(!empty($seoble_article->seo->extras['og']['image'])){{ $seoble_article->seo->extras['og']['image'] }}@endif"/>
                    <br>
                    <h4><?php echo _i('Twitter Card');?></h4>
                    <p><?php echo _i("Title");?>:</p>
                    <input type="text" class="form-control" name="seo[extras][tc][title]" id="seo_extras_tc_title"
                           placeholder="<?php echo _i("Open Graph Title");?>"
                           value="@if(!empty($seoble_article->seo->extras['tc']['title'])){{ $seoble_article->seo->extras['tc']['title'] }}@endif"/>
                    <br>
                    <p><?php echo _i("Description");?>:</p>
                    <textarea placeholder="<?php echo _i('Open Graph Description');?>" class="form-control" name="seo[extras][tc][description]" id="seo_extras_tc_description">@if(!empty($seoble_article->seo->extras['tc']['description'] )){{ $seoble_article->seo->extras['tc']['description']  }}@endif</textarea>
                    <br>
                    <p><?php echo _i("Open Graph Image like http://...");?>:</p>
                    <input type="text" class="form-control" name="seo[extras][tc][image]" id="seo_extras_tc_image"
                           placeholder="<?php echo _i("Open Graph Image");?>"
                           value="@if(!empty($seoble_article->seo->extras['tc']['image'])){{ $seoble_article->seo->extras['tc']['image'] }}@endif"/>
                </div>
            </div>

            <!-- row -->

            @if(!isset($seoble_article->user_id))
                <input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}"/>
            @endif

            @if(isset($seoble_article->id))
                <input type="hidden" id="id" name="id" value="{{ $seoble_article->id }}"/>
            @else
                <input type="hidden" id="id" name="id" value="0"/>
            @endif

            <input type="hidden" name="article_type" value="<?php echo $article_type; ?>"/>
            <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>"/>
            <input type="submit" value="{{ $button_text }}" class="btn btn-success pull-right"/>

        </form>

        <div class="clear"></div>
        <!-- This is where now -->
    </div>

@section('javascript')
    <script type="text/javascript" src="{{ '/application/assets/admin/js/tinymce/tinymce.min.js' }}"></script>
    <script type="text/javascript" src="{{ '/application/assets/js/tagsinput/jquery.tagsinput.min.js' }}"></script>
    <script type="text/javascript" src="{{ '/application/assets/js/jquery.mask.min.js' }}"></script>
    <script src="{{ '/application/assets/js/jquery-file-upload/js/vendor/jquery.ui.widget.js' }}"></script>
    <script src="{{ '/application/assets/admin/js/bootstrap-switch.min.js' }}"></script>
    <script type="text/javascript">

        $ = jQuery;

        $(document).ready(function () {

            $('input[type="checkbox"]').change(function () {
                if ($(this).is(":checked")) {
                    $(this).val(1);
                } else {
                    $(this).val(0);
                }
            });

            $('#duration').mask('00:00:00');
            $('#tags').tagsInput();

            $('#type').change(function () {
                if ($(this).val() == 'embed') {
                    $('.new-video-file').hide();
                    $('.new-video-embed').show();
                } else {
                    $('.new-video-file').show();
                    $('.new-video-embed').hide();
                }
            });

            tinymce.init({
                relative_urls: false,
                selector: '#details',
                toolbar: "styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | link image | preview media | forecolor backcolor | code",
                plugins: [
                    "advlist autolink link image code lists charmap print preview hr anchor pagebreak spellchecker code fullscreen",
                    "save table contextmenu directionality emoticons template paste textcolor code"
                ],
                menubar: false,
            });

        });


    </script>

@stop

@stop
