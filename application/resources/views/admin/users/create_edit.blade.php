<?php


?>


@extends('admin.master')

@section('css')
	<link rel="stylesheet" href="{{ '/application/application/assets/js/tagsinput/jquery.tagsinput.css' }}" />
@stop


@section('content')

<div id="admin-container">
<!-- This is where -->
	
	<div class="admin-section-title">
	@if(!empty($user->id))
		<h3><i class="entypo-user"></i> {{ $user->username }}</h3> 
		<a href="{{ URL::to('user') . '/' . $user->username }}" target="_blank" class="btn btn-info">
			<i class="fa fa-eye"></i> <?php echo _i("Preview");?> <i class="fa fa-external-link"></i>
		</a>
	@else
		<h3><i class="entypo-user"></i> <?php echo _i("Add New User");?></h3>
	@endif
	</div>
	<div class="clear"></div>
		<form method="POST" action="<?php echo $post_route; ?>" id="update_profile_form" accept-charset="UTF-8" file="1" enctype="multipart/form-data">

			<div id="user-badge">
				@if(isset($user->avatar) && $user->avatar != '')<?php $avatar = $user->avatar; ?>@else<?php $avatar = $default_avatar; ?>@endif
				<img src="<?php echo $avatar ?>" />
				<label for="avatar">@if(isset($user->username))<?php echo ucfirst($user->username). '\'s'; ?>@endif <?php echo _i("Profile Image");?></label>
				<input type="file" multiple="true" class="form-control" name="avatar" id="avatar" />
			</div>

			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><?php echo _i("Username");?></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
				<div class="panel-body" style="display: block;"> 
					<?php if($errors->first('username')): ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong><?php echo _i("Oh snap!");?></strong> <?php echo $errors->first('username'); ?>
                        </div>
                        <?php endif; ?>
					<p><?php echo _i("User's Username");?></p>
					<input type="text" class="form-control" name="username" id="username" value="<?php if(!empty($user->username)): ?><?php echo $user->username ?><?php endif; ?>" />
				</div>
			</div>

			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><?php echo _i("Email");?></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
				<div class="panel-body" style="display: block;"> 
					<?php if($errors->first('email')): ?>
                        <div class="alert alert-danger">
                            <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                            <strong><?php echo _i("Oh snap!");?></strong> <?php echo $errors->first('email'); ?>
                        </div>
                        <?php endif; ?>
					<p><?php echo _i("User's Email Address");?></p>
					<input type="text" class="form-control" name="email" id="email" value="<?php if(!empty($user->email)): ?><?php echo $user->email ?><?php endif; ?>" />
				</div>
			</div>

			<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
				<div class="panel-title"><?php echo _i("Password");?></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
				<div class="panel-body" style="display: block;">
					@if(isset($user->password))
						<p>(<?php echo _i("leave empty to keep your original password");?>)</p>
					@else
						<p><?php echo _i("Enter users password");?>:</p>
					@endif
					<input type="password" class="form-control" name="password" id="password" value="" />
				</div>
			</div>

			<div class="row"> 

				<div class="col-sm-4"> 
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><?php echo _i("User Role");?></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
						<div class="panel-body" style="display: block;"> 
						<p><?php echo _i("Select the user's role below");?></p>
							<select id="role" name="role">
								<option value="admin" @if(isset($user->role) && $user->role == 'admin')selected="selected"@endif><?php echo _i("Admin");?></option>
								<option value="demo" @if(isset($user->role) && $user->role == 'demo')selected="selected"@endif><?php echo _i("Demo");?></option>
								<option value="registered" @if(isset($user->role) && $user->role == 'registered')selected="selected"@endif><?php echo _i("Registered Users (free registration must be enabled)");?></option>
								<option value="subscriber" @if(isset($user->role) && $user->role == 'subscriber')selected="selected"@endif><?php echo _i("Subscriber");?></option>
							</select>
						</div>
					</div>
				</div>

				<div class="col-sm-4"> 
					<div class="panel panel-primary" data-collapsed="0"> <div class="panel-heading"> 
						<div class="panel-title"><?php echo _i("User Active Status");?></div> <div class="panel-options"> <a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a> </div></div>
						<div class="panel-body" style="display: block;"> 
							<label><?php echo _i("User Active Status");?></label>
							<input type="checkbox" id="active" name="active" @if(isset($user->active) && $user->active == 1)checked="checked" value="1" @else value="0" @endif />
						</div>
					</div>
				</div>
			</div><!-- row -->

			@if(isset($user->id))
				<input type="hidden" id="id" name="id" value="{{ $user->id }}" />
			@endif
			<input type="hidden" name="_token" value="<?php echo csrf_token() ?>" />
			<input type="submit" value="{{ $button_text }}" class="btn btn-success pull-right" />

			<div class="clear"></div>
		</form>

		<div class="clear"></div>
<!-- This is where now -->
</div>
	@section('javascript')
	<script type="text/javascript" src="{{ '/application/application/assets/js/tinymce/tinymce.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/application/application/assets/js/tagsinput/jquery.tagsinput.min.js' }}"></script>
	<script type="text/javascript" src="{{ '/application/application/assets/js/jquery.mask.min.js' }}"></script>
	<script type="text/javascript">
	$ = jQuery;

	$(document).ready(function(){

		$('#active, #disabled').change(function() {
			if($(this).is(":checked")) {
		    	$(this).val(1);
		    } else {
		    	$(this).val(0);
		    }
		    console.log('test ' + $(this).is( ':checked' ));
		});

	});
	</script>
	@stop
@stop