@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ '/application/assets/js/tagsinput/jquery.tagsinput.css' }}" />
@stop


@section('content')

<div id="admin-container">
<!-- This is where -->
	
	<ol class="breadcrumb"> <li> <a href="/admin/posts"><i class="fa fa-newspaper-o"></i><?php echo _i("All Posts");?></a> </li> <li class="active">@if(!empty($post->id)) <strong>{{ $post->title }}</strong> @else <strong><?php echo _i("New Post");?></strong> @endif</li> </ol>

	<div class="admin-section-title">
	@if(!empty($post->id))
		<h3>{{ $post->title }}</h3> 
		<a href="{{ URL::to('post') . '/' . $post->slug }}" target="_blank" class="btn btn-info">
			<i class="fa fa-eye"></i> <?php echo _i("Preview");?> <i class="fa fa-external-link"></i>
		</a>
	@else
		<h3><i class="entypo-plus"></i> <?php echo _i("Add New Post");?></h3>
	@endif
    <!-- Nav tabs -->
	@if(!empty($post->id))
    <ul class="nav nav-tabs" role="tablist">
        <li role="presentation" class="active"><a href="{{ URL::to('admin/posts/edit') . '/' . $post->id }}" aria-controls="home" role="tab"><?php echo _i('General');?></a></li>
        <li role="presentation"><a href="{{ URL::to('admin/posts/seo') . '/' . $post->id }}" aria-controls="profile" role="tab"><?php echo _i('SEO');?></a></li>
    </ul>
	@endif
	</div>
	<div class="clear"></div>

		<form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

			<div class="row">
				
				<div class="@if(!empty($post->created_at)) col-sm-6 @else col-sm-8 @endif"> 

					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><?php echo _i("Title");?></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
						<div class="panel-body" style="display: block;"> 
							<p><?php echo _i("Add the post title in the textbox below");?>:</p>
							<input type="text" class="form-control" name="title" id="title" placeholder="<?php echo _i("Post Title");?>" value="@if(!empty($post->title)){{ $post->title }}@endif" />
						</div> 
					</div>

				</div>

				<div class="@if(!empty($post->created_at)) col-sm-3 @else col-sm-4 @endif">
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><?php echo _i("SEO URL Slug");?></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
						<div class="panel-body" style="display: block;"> 
							<p><?php echo _i("(example. %s)", "/post/slug-name");?></p>
							<input type="text" class="form-control" name="slug" id="slug" placeholder="<?php echo _i("slug-name");?>" value="@if(!empty($post->slug)){{ $post->slug }}@endif" />
						</div> 
					</div>
				</div>

				@if(!empty($post->created_at))
					<div class="col-sm-3">
						<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
							<div class="panel-title"><?php echo _i("Created Date");?></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
							<div class="panel-body" style="display: block;"> 
								<p><?php echo _i("Select Date/Time Below");?></p>
								<input type="text" class="form-control" name="created_at" id="created_at" placeholder="" value="@if(!empty($post->created_at)){{ $post->created_at }}@endif" />
							</div> 
						</div>
					</div>
				@endif

			</div>


			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><?php echo _i("Post Content");?></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
				<div class="panel-body" style="display: block; padding:0px;">
					<textarea class="form-control" name="body" id="body">@if(!empty($post->body)){{ htmlspecialchars($post->body) }}@endif</textarea>
				</div> 
			</div>

			
			<div class="panel panel-primary" id="body_guest_block" style="@if(empty($post->access) || $post->access == 'guest')display:none;@endif" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><?php echo _i("Content to be shown to non-subscriber (if any)");?></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
				<div class="panel-body" style="display: block; padding:0px;">
					<textarea class="form-control" name="body_guest" id="body_guest">@if(!empty($post->body_guest)){{ htmlspecialchars($post->body_guest) }}@endif</textarea>
				</div> 
			</div>

			<div class="clear"></div>


			<div class="row"> 

				<div class="col-sm-4">
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><?php echo _i("Post Image");?></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
						<div class="panel-body" style="display: block;"> 
							@if(!empty($post->image))
								<img src="{{  ImageHandler::getImage($post->image) }}" class="post-img" width="200"/>
							@endif
							<p><?php echo _i("Select the post image (%s for best results)", "1280x720");?>:</p>
							<input type="file" multiple="true" class="form-control" name="image" id="image" />
						</div>
					</div>
				</div>

				<div class="col-sm-4"> 
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><?php echo _i("Category");?></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
						<div class="panel-body" style="display: block;"> 
							<p><?php echo _i("Select a Post Category Below");?>:</p>
							<select id="post_category_id" name="post_category_id">
								<option value="0"><?php echo _i("Uncategorized");?></option>
								@foreach($post_categories as $category)
									<option value="{{ $category->id }}" @if(!empty($post->post_category_id) && $post->post_category_id == $category->id)selected="selected"@endif>{{ $category->name }}</option>
								@endforeach
							</select>
						</div> 
					</div>
				</div>

				<div class="col-sm-4"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading"> <div class="panel-title"> <?php echo _i("Status & Access Settings");?></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
						<div class="panel-body"> 
							<div>
								<label for="active" style="float:left; display:block; margin-right:10px;"><?php echo _i("Is this post Active");?>:</label>
								<input type="checkbox" @if(!isset($post->active) || (isset($post->active) && $post->active))checked="checked" value="1"@else value="0"@endif name="active" id="active" />
								<p class="clear"></p>
								<label for="access" style="float:left; margin-right:10px;"><?php echo _i("Who is allowed to view this post?");?></label>
								<select id="access" name="access">
									<option value="guest" @if(!empty($post->access) && $post->access == 'guest'){{ 'selected' }}@endif><?php echo _i("Guest (everyone)");?></option>
									<option value="registered" @if(!empty($post->access) && $post->access == 'registered'){{ 'selected' }}@endif><?php echo _i("Registered Users (free registration must be enabled)");?></option>
									<option value="subscriber" @if(!empty($post->access) && $post->access == 'subscriber'){{ 'selected' }}@endif><?php echo _i("Subscriber (only paid subscription users)");?></option>
								</select>
							</div>
						</div> 
					</div>
				</div>

			</div><!-- row -->

			@if(!isset($post->user_id))
				<input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />
			@endif

			@if(isset($post->id))
				<input type="hidden" id="id" name="id" value="{{ $post->id }}" />
			@endif

			<input type="hidden" name="_token" value="<?= csrf_token() ?>" />
			<input type="submit" value="{{ $button_text }}" class="btn btn-success pull-right" />

		</form>

		<div class="clear"></div>
<!-- This is where now -->
</div>

	
	
	
	@section('javascript')


	<script type="text/javascript" src="{{ '/application/assets/admin/js/tinymce/tinymce.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/application/assets/js/jquery.mask.min.js' }}"></script>

	<script type="text/javascript">

	$ = jQuery;

	$(document).ready(function(){

		$('#duration').mask('00:00:00');

		$('input[type="checkbox"]').change(function() {
			if($(this).is(":checked")) {
		    	$(this).val(1);
		    } else {
		    	$(this).val(0);
		    }
		    console.log('test ' + $(this).is( ':checked' ));
		});

		$('#access').change(function() {
			if($(this).val() == 'guest'){
				$('#body_guest_block').slideUp();
			} else {
				$('#body_guest_block').slideDown();
			}
		});

		tinymce.init({
			relative_urls: false,
		    selector: '#body, #body_guest',
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
