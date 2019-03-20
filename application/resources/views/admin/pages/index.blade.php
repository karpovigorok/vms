@extends('admin.master')

@section('content')

	<div class="admin-section-title">
		<div class="row">
			<div class="col-md-8">
				<h3><i class="entypo-newspaper"></i> <?php echo _i("Page");?></h3><a href="{{ URL::to('admin/pages/create') }}" class="btn btn-success"><i class="fa fa-plus-circle"></i> <?php echo _i("Add New");?></a>
			</div>
			<!--div class="col-md-4">	
				<form method="get" role="form" class="search-form-full"> <div class="form-group"> <input type="text" class="form-control" name="s" id="search-input" placeholder="Search..."> <i class="entypo-search"></i> </div> </form>
			</div-->
		</div>
	</div>
	<div class="clear"></div>


	<table class="table table-striped pages-table">
		<tr class="table-header">
			<th><?php echo _i("Page");?></th>
			<th><?php echo _i("URL");?></th>
			<th><?php echo _i("Active");?></th>
			<th><?php echo _i("Actions");?></th>
			@foreach($pages as $page)
			<tr>
				<td>
					<a href="{{ URL::to('page') . '/' . $page->slug }}" target="_blank">{{ TextHelper::shorten($page->title, 80) }}</span></a>
				</td>
				<td valign="bottom"><p>{{ $page->slug }}</p></td>
				<td><p>{{ $page->active }}</p></td>
				<td>
					<p>
						<a href="{{ URL::to('admin/pages/edit') . '/' . $page->id }}" class="btn btn-xs btn-info">
                            <span class="fa fa-edit"></span> <?php echo _i("Edit");?>
                        </a>
						<a href="{{ URL::to('admin/pages/delete') . '/' . $page->id }}" class="btn btn-xs btn-danger delete">
                            <span class="fa fa-trash"></span> <?php echo _i("Delete");?>
                        </a>
					</p>
				</td>
			</tr>
			@endforeach
	</table>

	<div class="clear"></div>

	<div class="pagination-outter"><?= $pages->render(); ?></div>

	<script>

		$ = jQuery;
		$(document).ready(function(){
			$('.delete').click(function(e){
				e.preventDefault();
				if (confirm("Are you sure you want to delete this page?")) {
			       window.location = $(this).attr('href');
			    }
			    return false;
			});
		});

	</script>


@stop

