<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title"><?php echo _i("Update Category");?></h4>
</div>

<div class="modal-body">
	<form id="update-cat-form" accept-charset="UTF-8" action="{{ URL::to('admin/videos/categories/update') }}" method="post" file="1" enctype="multipart/form-data">
        <label for="name"><?php echo _i("Category Name");?></label>
        <input name="name" id="name" placeholder="<?php echo _i("Category Name");?>" class="form-control" value="{{ $category->name }}" /><br />
        <label for="slug"><?php echo _i("URL slug (ex. %s)", "videos/categories/slug-name");?></label>
        <input name="slug" id="slug" placeholder="<?php echo _i("URL Slug");?>" class="form-control" value="{{ $category->slug }}" />
        <input type="hidden" name="id" id="id" value="{{ $category->id }}" />
        <input type="hidden" name="_token" value="<?= csrf_token() ?>" />

        <div id="category-badge mt10">
            @if(isset($category))<?php $avatar = $category->thumb; ?>@else<?php $avatar = 'default.png'; ?>@endif
            <img width="185" src="<?php echo $avatar; ?>" />
            <label for="thumb">@if(isset($category->thumb))<?= ucfirst($category->thumb). '\'s'; ?>@endif <?php echo _i("Category Thumbnail");?></label>
            <input type="file" multiple="true" class="form-control" name="thumb" id="thumb" />
        </div>
    </form>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _i("Close");?></button>
	<button type="button" class="btn btn-info" id="submit-update-cat"><?php echo _i("Update");?></button>
</div>

<script>
	$(document).ready(function(){
		$('#submit-update-cat').click(function(){
			$('#update-cat-form').submit();
		});
	});
</script>