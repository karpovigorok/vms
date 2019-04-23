@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ '/application/assets/js/tagsinput/jquery.tagsinput.css' }}" />
@stop


@section('content')

<div id="admin-container">
<!-- This is where -->
	
	<ol class="breadcrumb"> <li> <a href="/admin/pages"><i class="fa fa-newspaper-o"></i><?php echo _i("All Pages");?></a> </li> <li class="active">@if(!empty($page->id)) <strong>{{ $page->title }}</strong> @else <strong><?php echo _i("New Page");?></strong> @endif</li> </ol>

	<div class="admin-section-title">
	@if(!empty($page->id))
		<h3>{{ $page->title }}</h3> 
		<a href="{{ URL::to('page') . '/' . $page->slug }}" target="_blank" class="btn btn-info">
			<i class="fa fa-eye"></i> <?php echo _i("Preview");?> <i class="fa fa-external-link"></i>
		</a>
	@else
		<h3><i class="entypo-plus"></i> <?php echo _i("Add New Page");?></h3>
	@endif
	</div>
	<div class="clear"></div>

		<form method="POST" action="{{ $post_route }}" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

			<div class="row">
				
				<div class="@if(!empty($page->created_at)) col-sm-6 @else col-sm-8 @endif"> 

					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><?php echo _i("Title");?></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
						<div class="panel-body" style="display: block;"> 
							<p><?php echo _i("Add the page title in the textbox below");?>:</p>
							<input type="text" class="form-control" name="title" id="title" placeholder="<?php echo _i("Page Title");?>" value="@if(!empty($page->title)){{ $page->title }}@endif" />
						</div> 
					</div>

				</div>

				<div class="@if(!empty($page->created_at)) col-sm-3 @else col-sm-4 @endif">
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><?php echo _i("SEO URL Slug");?></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
						<div class="panel-body" style="display: block;"> 
							<p><?php echo _i("(example. %s)", "/page/slug-name");?></p>
							<input type="text" class="form-control" name="slug" id="slug" placeholder="<?php echo _i("slug-name");?>" value="@if(!empty($page->slug)){{ $page->slug }}@endif" />
						</div> 
					</div>
				</div>

				@if(!empty($page->created_at))
					<div class="col-sm-3">
						<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
							<div class="panel-title"><?php echo _i("Created Date");?></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
							<div class="panel-body" style="display: block;"> 
								<p><?php echo _i("Select Date/Time Below");?></p>
								<input type="text" class="form-control" name="created_at" id="created_at" placeholder="" value="@if(!empty($page->created_at)){{ $page->created_at }}@endif" />
							</div> 
						</div>
					</div>
				@endif

			</div>


			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><?php echo _i("Page Content");?></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
				<div class="panel-body" style="display: block; padding:0px;">
					<textarea class="form-control" name="body" id="body">@if(!empty($page->body)){{ $page->body }}@endif</textarea>
				</div> 
			</div>

			<div class="clear"></div>


			<div class="row"> 

				<div class="col-sm-4"> 
					<div class="panel panel-primary" data-collapsed="0"> 
						<div class="panel-heading">
                            <div class="panel-title"> <?php echo _i("Status Settings");?></div>
                            <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
						<div class="panel-body"> 
							<div>
								<label for="active" style="float:left; display:block; margin-right:10px;"><?php echo _i("Is this page Active");?>:</label>
								<input type="checkbox" @if(!isset($page->active) || (isset($page->active) && $page->active))checked="checked" value="1"@else value="0"@endif name="active" id="active" />
							</div>
						</div> 
					</div>
				</div>

			</div><!-- row -->

			@if(!isset($page->user_id))
				<input type="hidden" name="user_id" id="user_id" value="{{ Auth::user()->id }}" />
			@endif

			@if(isset($page->id))
				<input type="hidden" id="id" name="id" value="{{ $page->id }}" />
			@endif

			<input type="hidden" name="_token" value="<?php echo csrf_token() ?>" />
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

		tinymce.init({
			relative_urls: false,
		    selector: '#body',
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