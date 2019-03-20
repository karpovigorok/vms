@extends('admin.master')

@section('content')

	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-12">
				<h3><i class="entypo-list"></i> <?php echo _i("Menu Items");?></h3>
                <a href="javascript:;" onclick="jQuery('#add-new').modal('show');" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?php echo _i("Add New");?></a>
			</div>
		</div>
	</div>

	<!-- Add New Modal -->
	<div class="modal fade" id="add-new">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><?php echo _i("New Menu Item");?></h4>
				</div>
				
				<div class="modal-body">
					<form id="new-menu-form" accept-charset="UTF-8" action="{{ URL::to('admin/menu/store') }}" method="post">
				        <label for="name"><?php echo _i("Enter the new menu item name below");?></label>
				        <input name="name" id="name" placeholder="<?php echo _i("Menu Item Name");?>" class="form-control" value="" /><br />
				        <label for="url"><?php echo _i("Menu Item URL (ex. %s)", "/site/url");?></label>
				        <input name="url" id="url" placeholder="<?php echo _i("URL");?>" class="form-control" value="" /><br />
				        <label for="dropdown"><?php echo _i("or Dropdown for");?>:</label>
				        <div class="clear"></div>
				        <input type="radio" class="menu-dropdown-radio" name="type" value="none" checked="checked" /> <?php echo _i("None");?>
				        <input type="radio" class="menu-dropdown-radio" name="type" value="videos" /> <?php echo _i("Video Categories");?>
				        <input type="radio" class="menu-dropdown-radio" name="type" value="posts" /> <?php echo _i("Post Categories");?>
				        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
				    </form>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _i("Close");?></button>
					<button type="button" class="btn btn-info" id="submit-new-menu"><?php echo _i("Save changes");?></button>
				</div>
			</div>
		</div>
	</div>

	<!-- Add New Modal -->
	<div class="modal fade" id="update-menu">
		<div class="modal-dialog">
			<div class="modal-content">
				
			</div>
		</div>
	</div>

	<div class="clear"></div>
		
		
		<div class="panel panel-primary menu-panel" data-collapsed="0">
					
			<div class="panel-heading">
				<div class="panel-title">
                    <?php echo _i("Organize the Menu Items below: (max of 3 levels)");?>
				</div>
				
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>
			
			
			<div class="panel-body">
		
				<div id="nestable" class="nested-list dd with-margins">

					<ol class="dd-list">

					<?php $previous_item = array(); ?>
					<?php $first_parent_id = 0; ?>
					<?php $second_parent_id = 0; ?>
					<?php $depth = 0; ?>
					@foreach($menu as $menu_item)

						@if( (isset($previous_item->id) && $menu_item->parent_id == $previous_item->parent_id) || $menu_item->parent_id == NULL )
							</li>
						@endif

						@if( (isset($previous_item->parent_id) && $previous_item->parent_id !== $menu_item->parent_id) && $previous_item->id != $menu_item->parent_id )
							@if($depth == 2)
								</li></ol>
								<?php $depth -= 1; ?>
							@endif
							@if($depth == 1 && $menu_item->parent_id == $first_parent_id)
								</li></ol>
								<?php $depth -= 1; ?>
							@endif
							
						@endif

						@if(isset($previous_item->id) && $menu_item->parent_id == $previous_item->id && $menu_item->parent_id !== $previous_item->parent_id )
							<?php if($first_parent_id != 0):
								$first_parent_id = $menu_item->parent_id;
							else:
								$second_parent_id = $menu_item->parent_id;
							endif; ?>
							<ol class="dd-list">
							<?php $depth += 1; ?>
						@endif


						<li class="dd-item @if($menu_item->type == 'videos' || $menu_item->type == 'posts') video_post @endif" data-id="{{ $menu_item->id }}">
							<div class="dd-handle">{{ $menu_item->name}}<span class="slug">{{ $menu_item->url }}@if($menu_item->type == 'videos' || $menu_item->type == 'posts') (<?php echo _i("Note: Categories should only be in the top level menu item!");?> @endif</span></div>
							<div class="actions"><a href="/admin/menu/edit/{{ $menu_item->id }}" class="edit">Edit</a> <a href="/admin/menu/delete/{{ $menu_item->id }}" class="delete"><?php echo _i("Delete");?></a></div>

						<?php $previous_item = $menu_item; ?>

					@endforeach
						
						

					</ol>
						
				</div>
		
			</div>
		
		</div>

	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />

	<?php if(isset($_GET['menu_first_level'])): ?>
		<input type="hidden" id="menu_first_level" value="1" />
	<?php endif; ?>

	@section('javascript')

		<script src="{{ '/application/assets/admin/js/jquery.nestable.js' }}"></script>

		<script type="text/javascript">

		jQuery(document).ready(function($){


			if($('#menu_first_level').val() == 1){
				console.log('yup!');
				toastr.warning('Should only be added as a top level menu item!', "Video Or Post Category Menu Item", opts);
			}

			$('#nestable').nestable({ maxDepth: 3 });

			$('#add-new .menu-dropdown-radio').change(function(){
				changeNewMenuDropdownRadio($(this));
			});

			// Add New Menu
			$('#submit-new-menu').click(function(){
				$('#new-menu-form').submit();
			});

			$('.actions .edit').click(function(e){
				$('#update-menu').modal('show', {backdrop: 'static'});
				e.preventDefault();
				href = $(this).attr('href');
				$.ajax({
					url: href,
					success: function(response)
					{
						$('#update-menu .modal-content').html(response);
					}
				});
			});

			$('.actions .delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to delete this menu item?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});

			$('.dd').on('change', function(e) {
				if($('.video_post').parents('.dd-list').length > 1){
					console.log('show error');
					window.location = '/admin/menu?menu_first_level=true';
				} else {
				
	    			$('.menu-panel').addClass('reloading');
	    			$.post('/admin/menu/order', { order : JSON.stringify($('.dd').nestable('serialize')), _token : $('#_token').val() }, function(data){
	    				console.log(data);
	    				$('.menu-panel').removeClass('reloading');
	    			});

	    		}

			});


		});

		function changeNewMenuDropdownRadio(object){
			if($(object).val() == 'none'){
				$('#new-menu-form #url').removeAttr('disabled');
			} else {
				$('#new-menu-form #url').attr('disabled', 'disabled');
			}
		}

		</script>



	@stop

@stop