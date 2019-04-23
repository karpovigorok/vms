@extends('admin.master')

@section('content')

	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-user"></i> <?php echo _i("Users");?></h3>
                <a href="{{ URL::to('admin/user/create') }}" class="btn btn-success">
                    <i class="fa fa-plus-circle"></i> <?php echo _i("Add New");?>
                </a>
			</div>
			<div class="col-md-4">	
				<?php $search = Input::get('s'); ?>
				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" name="s" id="search-input" value="@if(!empty($search)){{ $search }}@endif" placeholder="<?php echo _i("Search...");?>"> <i class="entypo-search"></i> </div> </form>
			</div>
		</div>
	</div>
	<div class="clear"></div>


	<table class="table table-striped">
		<tr class="table-header">
			<th><?php echo _i("Username");?></th>
			<th><?php echo _i("Email");?></th>
			<th><?php echo _i("User Type");?></th>
			<th><?php echo _i("Active");?></th>
			<th><?php echo _i("Subscription Status");?></th>
			<th><?php echo _i("Actions");?></th>
			@foreach($users as $user)
			<tr>
				<td><a href="{{ URL::to('user') . '/' . $user->username }}" target="_blank">
					<?php if(strlen($user->username) > 40){
							echo substr($user->username, 0, 40) . '...';
						  } else {
						  	echo $user->username;
						  }
					?>
					</a>
				</td>
				<td>@if(Auth::user()->role == 'demo')<?php echo _i("email n/a in demo mode");?> @else{{ $user->email }}@endif</td>
				<td>
					@if($user->role == 'subscriber')
						<div class="label label-success"><i class="fa fa-user"></i>
                            <?php echo _i("Subscribed User");?></div>
					@elseif($user->role == 'registered')
						<div class="label label-info"><i class="fa fa-envelope"></i>
                            <?php echo _i("Registered User");?></div>
					@elseif($user->role == 'demo')
						<div class="label label-danger"><i class="fa fa-life-saver"></i>
                            <?php echo _i("Demo User");?></div>
					@elseif($user->role == 'admin')
						<div class="label label-primary"><i class="fa fa-star"></i>
						<?php echo ucfirst($user->role) ?> <?php echo _i("User");?></div>
					@endif
					 
				</td>
				<td>{{ $user->active }}</td>
				<td>
                    <?php //dd($user->subscribed('main'));
					if($user->subscribed('main') && $user->subscription('main')->onGracePeriod()):?>
						<div class="label label-warning"><i class="fa fa-meh-o"></i> <?php echo _i("Grace Period");?></div>
                    <?php elseif( $user->subscribed('main') && $user->subscription('main')->cancelled()):?>
						<div class="label label-danger"><i class="fa fa-frown-o"></i> <?php echo _i("Cancelled");?></div>
                    <?php elseif( $user->subscribed('main') || ($user->role == 'admin' || $user->role == 'demo')):?>
						<div class="label label-success"><i class="fa fa-ticket"></i> <?php echo _i("Subscribed");?></div>
					<?php endif;?>
					
				</td>
				<td>
					<a href="{{ URL::to('admin/user/edit') . '/' . $user->id }}" class="btn btn-xs btn-info"><span class="fa fa-edit"></span> <?php echo _i("Edit");?></a>
					<a href="{{ URL::to('admin/user/delete') . '/' . $user->id }}" class="btn btn-xs btn-danger delete"><span class="fa fa-trash"></span> <?php echo _i("Delete");?></a>
				</td>
			</tr>
			@endforeach
	</table>
	@section('javascript')
	<script>
		$ = jQuery;
		$(document).ready(function(){
			$('.delete').click(function(e){
				e.preventDefault();
				if (confirm("<?php echo _i("Are you sure you want to delete this user?");?>") {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});
		});
	</script>

	@stop

@stop

