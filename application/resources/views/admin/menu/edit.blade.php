<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
	<h4 class="modal-title"><?php echo _i("Update Menu Item");?></h4>
</div>

<div class="modal-body">
	<form id="update-menu-form" accept-charset="UTF-8" action="{{ URL::to('admin/menu/update') }}" method="post">
        <label for="name"><?php echo _i("Menu Item Name");?></label>
        <input name="name" id="name" placeholder="<?php echo _i("Menu Item Name");?>" class="form-control" value="{{ $menu->name }}" /><br />
        <label for="slug"><?php echo _i("URL (ex. %s)", "/site/url"); ?></label>
        <input name="url" id="url" placeholder="<?php echo _i("URL Slug");?>" class="form-control" value="{{ $menu->url }}" <?php if($menu->type != 'none'): ?>disabled="disabled"<?php endif; ?> />
        <label for="dropdown"><?php echo _i("or Dropdown for");?>:</label>
        <div class="clear"></div>
        <input type="radio" class="menu-dropdown-radio" name="type" value="none" @if($menu->type == 'none') checked="checked" @endif /> <?php echo _i("None");?>
        <input type="radio" class="menu-dropdown-radio" name="type" value="videos"  @if($menu->type == 'videos') checked="checked" @endif /> <?php echo _i("Video Categories");?>
        <input type="radio" class="menu-dropdown-radio" name="type" value="posts"  @if($menu->type == 'posts') checked="checked" @endif /> <?php echo _i("Post Categories");?>
        <input type="hidden" name="id" id="id" value="{{ $menu->id }}" />
        <input type="hidden" name="_token" value="<?php echo csrf_token() ?>" />
    </form>
</div>

<div class="modal-footer">
	<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _i("Close");?></button>
	<button type="button" class="btn btn-info" id="submit-update-menu"><?php echo _i("Update");?></button>
</div>

<script>
	$(document).ready(function(){
		$('#submit-update-menu').click(function(){
			$('#update-menu-form').submit();
		});

		$('#update-menu-form .menu-dropdown-radio').change(function(){
			changeNewMenuDropdownRadio($(this));
		});

	});

	function changeNewMenuDropdownRadio(object){
		if($(object).val() == 'none'){
			$('#update-menu-form #url').removeAttr('disabled');
		} else {
			$('#update-menu-form #url').attr('disabled', 'disabled');
		}
	}
</script>