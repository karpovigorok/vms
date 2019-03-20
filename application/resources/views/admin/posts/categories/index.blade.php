@extends('admin.master')

@section('content')

	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-12">
				<h3><i class="entypo-archive"></i> <?php echo _i("Post Categories");?></h3>
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
					<h4 class="modal-title"><?php echo _i("New Post Category");?></h4>
				</div>
				
				<div class="modal-body">
					<form id="new-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/posts/categories/store') }}" method="post">
				        <label for="name"><?php echo _i("Enter the new category name below");?></label>
				        <input name="name" id="name" placeholder="<?php echo _i("Category Name");?>" class="form-control" value="" /><br />
				        <label for="slug"><?php echo _i("URL slug (ex. %s)", "posts/categories/slug-name");?></label>
				        <input name="slug" id="slug" placeholder="<?php echo _i("URL Slug");?>" class="form-control" value="" />
				        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />
				    </form>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _i("Close");?></button>
					<button type="button" class="btn btn-info" id="submit-new-cat"><?php echo _i("Save changes");?></button>
				</div>
			</div>
		</div>
	</div>

	<!-- Add New Modal -->
	<div class="modal fade" id="update-category">
		<div class="modal-dialog">
			<div class="modal-content">
				
			</div>
		</div>
	</div>

	<div class="clear"></div>
		
		
		<div class="panel panel-primary category-panel" data-collapsed="0">
					
			<div class="panel-heading">
				<div class="panel-title">
                    <?php echo _i("Organize the Categories below: (max of 3 levels)");?>
				</div>
				
				<div class="panel-options">
					<a href="#" data-rel="collapse"><i class="entypo-down-open"></i></a>
				</div>
			</div>
			
			
			<div class="panel-body">
		
				<div id="nestable" class="nested-list dd with-margins">

					<ol class="dd-list">

					<?php $previous_cat = array(); ?>
					<?php $first_parent_id = 0; ?>
					<?php $second_parent_id = 0; ?>
					<?php $depth = 0; ?>
					@foreach($post_categories as $category)

						@if( (isset($previous_cat->id) && $category->parent_id == $previous_cat->parent_id) || $category->parent_id == NULL )
							</li>
						@endif

						@if( (isset($previous_cat->parent_id) && $previous_cat->parent_id !== $category->parent_id) && $previous_cat->id != $category->parent_id )
							@if($depth == 2)
								</li></ol>
								<?php $depth -= 1; ?>
							@endif
							@if($depth == 1 && $category->parent_id == $first_parent_id)
								</li></ol>
								<?php $depth -= 1; ?>
							@endif
							
						@endif

						@if(isset($previous_cat->id) && $category->parent_id == $previous_cat->id && $category->parent_id !== $previous_cat->parent_id )
							<?php if($first_parent_id != 0):
								$first_parent_id = $category->parent_id;
							else:
								$second_parent_id = $category->parent_id;
							endif; ?>
							<ol class="dd-list">
							<?php $depth += 1; ?>
						@endif


						<li class="dd-item" data-id="{{ $category->id }}">
							<div class="dd-handle">{{ $category->name}}<span class="slug">posts/categories/{{ $category->slug }}</span></div>
							<div class="actions"><a href="/admin/posts/categories/edit/{{ $category->id }}" class="edit"><?php echo _i("Edit");?></a> <a href="/admin/posts/categories/delete/{{ $category->id }}" class="delete"><?php echo _i("Delete");?></a></div>

						<?php $previous_cat = $category; ?>

					@endforeach
						
						

					</ol>
						
				</div>
		
			</div>
		
		</div>

	<input type="hidden" id="_token" name="_token" value="<?= csrf_token() ?>" />

	@section('javascript')

		<script src="{{ '/application/assets/admin/js/jquery.nestable.js' }}"></script>

		<script type="text/javascript">

		jQuery(document).ready(function($){


			$('#nestable').nestable({ maxDepth: 3 });

			// Add New Category
			$('#submit-new-cat').click(function(){
				$('#new-cat-form').submit();
			});

			$('.actions .edit').click(function(e){
				$('#update-category').modal('show', {backdrop: 'static'});
				e.preventDefault();
				href = $(this).attr('href');
				$.ajax({
					url: href,
					success: function(response)
					{
						$('#update-category .modal-content').html(response);
					}
				});
			});

			$('.actions .delete').click(function(e){
				e.preventDefault();
				if (confirm("<?php echo _i("Are you sure you want to delete this category?");?>")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});

			$('.dd').on('change', function(e) {
    			$('.category-panel').addClass('reloading');
    			$.post('/admin/posts/categories/order', { order : JSON.stringify($('.dd').nestable('serialize')), _token : $('#_token').val() }, function(data){
    				console.log(data);
    				$('.category-panel').removeClass('reloading');
    			});

			});


		});
		</script>

	@stop

@stop