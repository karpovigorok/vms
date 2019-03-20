<?php

require_once('config.php');
require_once('functions.php');

$max_upload = (int)(ini_get('upload_max_filesize'));
$max_post = (int)(ini_get('post_max_size'));
$memory_limit = (int)(ini_get('memory_limit'));
$upload_mb = min($max_upload, $max_post, $memory_limit);

if(isset($_GET['src'])){
	$source = clean($_GET['src']);
}else{
	$source = "";
}

if(isset($_GET['title'])){
	$title = clean($_GET['title']);
}else{
	$title = "";
}

if(isset($_GET['alt'])){
	$alt = clean($_GET['alt']);
}else{
	$alt = "";
}

if(isset($_GET['width'])){
	$width = clean($_GET['width']);
}else{
	$width = "";
}

if(isset($_GET['height'])){
	$height = clean($_GET['height']);
}else{
	$height = "";
}

if(isset($_GET['align'])){
	$align = clean($_GET['align']);
}else{
	$align = "";
}

if(isset($_GET['class'])){
	$class = clean($_GET['class']);
}else{
	$class = "";
}


?>
<!DOCTYPE html>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
		<title>TinyMCE 4 Image Manager</title>
		<link href="bootstrap/css/bootstrap.css" rel="stylesheet" media="screen">
		<script src="bootstrap/js/jquery.js"></script>
		<script src="bootstrap/js/bootstrap.min.js"></script>
		
		<link href="bootstrap/blueimp/css/style.css" rel="stylesheet" />
		<script src="bootstrap/blueimp/js/jquery.ui.widget.js"></script>
		<script src="bootstrap/blueimp/js/jquery.iframe-transport.js"></script>
		<script src="bootstrap/blueimp/js/jquery.fileupload.js"></script>
		
		<script>
		    var trans_change_name = "<?php e_lang('change_name'); ?>";
            var trans_delete = "<?php e_lang('delete'); ?>";
            var trans_no_images_in_lib = "<?php e_lang('no_images_in_lib'); ?>";
            var trans_no_images_in_search = "<?php e_lang('no_images_in_search'); ?>";
            var trans_no_images_in_recent = "<?php e_lang('no_images_in_recent'); ?>";
            var trans_no_images_in_folder = "<?php e_lang('no_images_in_folder'); ?>";
            var trans_please_provide_name_for_new_folder = "<?php e_lang('please_provide_name_for_new_folder'); ?>";
            var trans_creating = "<?php e_lang('creating'); ?>";
            var trans_done = "<?php e_lang('done'); ?>";
            var trans_error = "<?php e_lang('error'); ?>";
            var trans_are_you_sure_file = "<?php e_lang('are_you_sure_file'); ?>";
            var trans_are_you_sure_folder = "<?php e_lang('are_you_sure_folder'); ?>";
            var trans_please_enter_new_name = "<?php e_lang('please_enter_new_name'); ?>";
            var trans_loading = "<?php e_lang('loading'); ?>";
            var trans_sending = "<?php e_lang('sending'); ?>";
            var trans_searching = "<?php e_lang('searching'); ?>";
            var trans_clear = "<?php e_lang('clear'); ?>";
            var trans_deleting = "<?php e_lang('Deleting'); ?>";
            var trans_saving = "<?php e_lang('Saving'); ?>";


            var lib_folder_path = '<?php echo LIBRARY_FOLDER_PATH; ?>';
		
		<?php
		if(isset($_GET['src']) AND trim($_GET['src']) != ""){
			 echo 'var newImage = false;
			 ';
		}else{
			 echo 'var newImage = true;
			 ';
		}
		
		?>
		</script>
		
		<script src="app.js"></script>
		
<!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
<!--[if lt IE 9]>
<script src="bootstrap/js/html5shiv.js"></script>
<![endif]-->
<style>
.library-item div.item{
	margin: 9px;
	display: block;
	float: left;
	width: 130px;
	height: 135px;
	margin-bottom: 10px;
	margin-right: 20px;
}

.caption{
	padding: 4px; 
	background-color: #555; 
	color: #fff; 
	width: 100%; 
	-webkit-border-radius: 3px; 
	-moz-border-radius: 3px; 
	border-radius: 3px;
	line-height: 12px;
	font-size: 11px;
}

.pdf-fields {
	display: none;
}

.transparent {
	zoom: 1;
	filter: alpha(opacity=50);
	opacity: 0.5;
}

.transparent:hover {
	zoom: 1;
	filter: alpha(opacity=90);
	opacity: 0.9;
}
			
.img-polaroid:hover{
	border-color: #0088cc;
	-webkit-box-shadow: 0 1px 4px rgba(0, 105, 214, 0.25);
	-moz-box-shadow: 0 1px 4px rgba(0, 105, 214, 0.25);
	box-shadow: 0 1px 4px rgba(0, 105, 214, 0.25);
}
			
#ajax-loader-div {
    height: 400px;
    position: relative;
}
.ajax-loader {
    position: absolute;
    left: 50%;
    top: 50%;
    margin-left: -16px; /* -1 * image width / 2 */
    margin-top: -16px;  /* -1 * image height / 2 */
    display: block;     
}
<?php
if(!CanDeleteFiles()){
?>
.delete-file{
	display: none; 
}
<?php
}
?>
<?php
if(!CanDeleteFolder()){
?>
.delete-folder{
	display: none; 
}
<?php
}
?>

<?php
if(!CanRenameFiles()){
?>
.change-file{
	display: none; 
}
<?php
}
?>
<?php
if(!CanRenameFolder()){
?>
.change-folder{
	display: none; 
}
<?php
}
?>
</style>		
	</head>
	<body>
		<div class="container-fluid">
			<div class="row-fluid">
			
				<div class="span12" style="margin-top: 20px;">
					
					
					<div class="tabbable tabs-left">
						<ul class="nav nav-tabs" id="myTab">
							<li><a href="#tab1" data-toggle="tab"><i class="icon-globe"></i> <?php e_lang('insert_from_url'); ?></a></li>
							<?php if(CanAcessLibrary()){?>
							<li><a href="#tab2" data-toggle="tab" id="get-lib"><i class="icon-folder-open"></i> <?php e_lang('get_from_library'); ?></a></li>
							<?php }?>
							<?php if(CanAcessUploadForm()){?>
							<li><a href="#tab3" data-toggle="tab" id="upload-now"><i class="icon-upload"></i> <?php e_lang('upload_now'); ?></a></li>
							<?php }?>
							<li><a href="#tab4" data-toggle="tab" id="get-recent"><i class="icon-time"></i> <?php e_lang('recent'); ?></a></li>
						</ul>
						<div class="tab-content">
							<div class="tab-pane" id="tab1">
								
<div class="row-fluid" style="padding-top: 5px;">
			
				<div class="pull-left" style="width: 50%;">								
							<form class="form-horizontal" action="" method="">
<p class="pdf-fields">
<input type="text" id="source_pdf" name="source_pdf" value="<?php echo $source;?>" placeholder="<?php e_lang('url'); ?>" title="<?php e_lang('url'); ?>">
</p>

<p class="pdf-fields">
<input type="text" id="title_pdf" name="title_pdf" value="<?php echo $title;?>" placeholder="<?php e_lang('link_text'); ?>" title="<?php e_lang('link_text'); ?>">
</p>

<p class="pdf-fields">
<input type="text" id="class_pdf" name="class_pdf" value="<?php echo $class;?>" placeholder="<?php e_lang('classes_separate_with_space'); ?>" title="<?php e_lang('classes'); ?>">
</p>

<p class="pdf-fields">
<select id="target_pdf" name="target_pdf">
<option value="_self">Target: None</option>
<option value="_blank">New window</option>
</select>
</p>

<p class="image-fields">
<input type="text" id="source" name="source" value="<?php echo $source;?>" placeholder="<?php e_lang('url'); ?>" title="<?php e_lang('url'); ?>">
</p>

<p class="image-fields">
<input type="text" id="title" name="title" value="<?php echo $title;?>" placeholder="<?php e_lang('title'); ?>" title="<?php e_lang('title'); ?>">
</p>

<p class="image-fields">
<input type="text" id="alt" name="alt" value="<?php echo $alt;?>" placeholder="<?php e_lang('description'); ?>" title="<?php e_lang('description'); ?>">
</p>
<p class="image-fields">
<input type="text" id="class" name="class" value="<?php echo $class;?>" placeholder="<?php e_lang('classes_separate_with_space'); ?>" title="<?php e_lang('classes'); ?>">
</p>
<br/>
<p class="image-fields">
<input type="text" id="width" name="width" class="input-small dimensions" placeholder="<?php e_lang('width'); ?>" title="<?php e_lang('width'); ?>" value="<?php echo $width;?>"> &times; <input type="text" id="height" name="height" class="input-small dimensions" placeholder="<?php e_lang('height'); ?>" title="<?php e_lang('height'); ?>" value="<?php echo $height;?>"> <br/><input type="checkbox" id="constrain" name="constrain" checked="checked"> <?php e_lang('force_original_aspect_ratio'); ?>
</p>
<br/>
<p class="image-fields">
<select id="float" name="float">
<option value=""><?php e_lang('width'); ?><?php e_lang('alignment_none'); ?></option>
<option value="left" <?php echo ($align == 'left' ? 'selected="selected"' : '');?>><?php e_lang('left'); ?></option>
<option value="right" <?php echo ($align == 'right' ? 'selected="selected"' : '');?>><?php e_lang('right'); ?></option>
</select>
</p>

<?php if(!isset($_GET['src']) OR trim($_GET['src']) == ""){?>
<br/>
<p class="image-fields">
<input type="checkbox" id="do_link" name="do_link"> <?php e_lang('wrap_image_in_a_link'); ?>
</p>

<p class="image-fields">
<input type="text" id="link_url" name="link_url" disabled placeholder="<?php e_lang('link_url'); ?>" title="<?php e_lang('link_url'); ?>">
</p>

<p class="image-fields">
<select id="target" name="target" disabled>
<option value="_self"><?php e_lang('target_none'); ?></option>
<option value="_blank"><?php e_lang('new_window'); ?></option>
</select>
</p>

<?php }?>

</form>	
</div>
<div class="pull-right" style="width: 50%; height: 70%;">						
<img id="preview" src="<?php echo $source;?>" alt="<?php e_lang('preview'); ?>" style="margin: 2px; padding: 5px; max-width: 300px; overflow:hidden; max-height: 400px; border: 1px solid rgb(192, 192, 192);"/>
						
						
						
						</div>
						<div style="clear: both;"></div>
						</div>

								
							
								
							</div>
							<div class="tab-pane" id="tab2">
								<div>
								<div class="pull-left" style="padding-left: 11px;">
									<button class="btn" disabled id="lib-back" rel="<?php echo LIBRARY_FOLDER_PATH; ?>"><i class="icon-hand-left"></i> <?php e_lang('back'); ?></button>&nbsp;&nbsp;&nbsp;<a href="" title="<?php e_lang('refresh'); ?>" rel="<?php echo LIBRARY_FOLDER_PATH; ?>" id="refresh"><i class="icon-refresh"></i></a>
					
								</div>
								
								<div class="pull-right" style="padding-right: 12px;">
									<input type="text" class="input-medium" id="search" placeholder="<?php e_lang('search'); ?>">
								</div>
								<?php if(CanCreateFolders()){?>
								<div class="pull-right" style="padding-right: 12px;">
									<span id="new-folder-msg"></span>
									<div class="input-append">
										<input class="input-medium" id="newfolder_name" type="text" placeholder="<?php e_lang('create_folder_here'); ?>">
										<button id="newfolder_btn" class="btn" type="button"><i class="icon-plus"></i></button>
									</div>
								</div>
								<?php }?>
								<div style="clear: both;"></div>
								</div>
								<div>
								<p class="pull-left muted" id="lib-title" style="padding-left: 12px;"><?php e_lang('home'); ?></p>
								
								<p style="padding-right: 20px;" class="pull-right transparent"><a id="toggle-layout" href="" title="<?php e_lang('toggle_list_grid_views'); ?>"><i class="icon-th-list"></i></a></p>
								<div style="clear: both;"></div>
								</div>
								<div class="library-item" id="gallery-images"></div>
							</div>
							<div class="tab-pane" id="tab3">
<script>
$(function(){

    var ul = $('#upload ul');

    $('#drop a').click(function(){
        // Simulate a click on the file input button
        // to show the file browser dialog
        $(this).parent().find('input').click();
    });

    // Initialize the jQuery File Upload plugin
    $('#upload').fileupload({
	dataType: 'json',
	acceptFileTypes: /(\.|\/)(<?php echo implode("|", explode(",", ALLOWED_IMG_EXTENSIONS));?>)$/i,
        maxFileSize: <?php echo MBToBytes($upload_mb);?>,
	
        // This element will accept file drag/drop uploading
        dropZone: $('#drop'),

        // This function is called when a file is added to the queue;
        // either via the browse button, or via drag/drop:
        add: function (e, data) {

            var tpl = $('<li><div class="alert alert-info"><img class="loader" src="bootstrap/blueimp/img/ajax-loader.gif"> <a class="close" data-dismiss="alert">×</a></div></li>');

            // Append the file name and file size
           // Append the file name and file size
            tpl.find('div').append(data.files[0].name + ' <small>[<i>' + formatFileSize(data.files[0].size) + '</i>]</small>');

            // Add the HTML to the UL element
            data.context = tpl.appendTo(ul);

            // Automatically upload the file once it is added to the queue
            var jqXHR = data.submit();
        },
        
        done: function (e, data) {
            if(data.result.success == true){
        		data.context.remove();
        		if(data.result.is_pdf == 1){
        			$("#uploaded-images").append('<a style="margin: 9px; margin-right: 27px;" href="" class="pdf-thumbs" title="' + data.result.file + '" rel="' + data.result.file + '" data-icon="' + data.result.icon + '"><img src="' + data.result.icon + '" class="img-polaroid" width="130" height="90"></a>');
        		}else{
        			$("#uploaded-images").append('<a style="margin: 9px; margin-right: 27px;" href="" class="img-thumbs" title="' + data.result.file + '" rel="' + data.result.file + '"><img src="timthumb.php?src=' + encodeURIComponent(data.result.file) + '&w=130&h=90" class="img-polaroid" width="130" height="90"></a>');
        		}
        	}else{
        		data.context.empty();
            		var tpl = $('<li><div class="alert alert-error"><a class="close" data-dismiss="alert">×</a></div></li>');
			tpl.find('div').append('<b>Error:</b> ' + data.files[0].name + ' <small>[<i>' + formatFileSize(data.files[0].size) + '</i>]</small> ' + data.result.reason);
			data.context.append(tpl);
        	}
        },
         fail: function (e, data) {
            data.context.empty();
            		var tpl = $('<li><div class="alert alert-error"><a class="close" data-dismiss="alert">×</a></div></li>');
			tpl.find('div').append('<b>Error:</b> ' + data.files[0].name + ' <small>[<i>' + formatFileSize(data.files[0].size) + '</i>]</small> ' + data.errorThrown);
			data.context.append(tpl);
        }
    });


    // Prevent the default action when a file is dropped on the window
    $(document).on('drop dragover', function (e) {
        e.preventDefault();
    });

    // Helper function that formats the file sizes
    function formatFileSize(bytes) {
        if (typeof bytes !== 'number') {
            return '';
        }

        if (bytes >= 1000000000) {
            return (bytes / 1000000000).toFixed(2) + ' GB';
        }

        if (bytes >= 1000000) {
            return (bytes / 1000000).toFixed(2) + ' MB';
        }

        return (bytes / 1000).toFixed(2) + ' KB';
    }

});
</script>
<div>
<div class="pull-left">
	<p class="muted"><?php e_lang('maximum_upload_file_size'); ?>: <?php echo $upload_mb;?> MB</p>
</div>
<div class="pull-right">
<p>
<span id="select-dir-msg"></span>
<select  id="select-dir" class="input-medium">
<?php echo Dirtree(LIBRARY_FOLDER_PATH);?>
</select>&nbsp;&nbsp;&nbsp;<a href="" title="refresh folders list" id="refresh-dirs"><i class="icon-refresh"></i></a>
</p>
</div>
<div class="clearfix"></div>
</div>
<form id="upload" method="post" action="upload.php" enctype="multipart/form-data">
			
			<div id="drop">
				

				<a class="btn"><?php e_lang('click_or_drop'); ?></a>
				<input type="file" name="upl" multiple />
			</div>
			<br/>
			<ul id="upload-msg">
				<!-- The file uploads will be shown here -->
			</ul>

		</form>
<br/>
<div class="library-item" id="uploaded-images"></div>

							
							</div>
							
							<div class="tab-pane" id="tab4">
								<div class="library-item" id="recent-images"></div>
							</div>
						</div>
					</div> <!-- /tabbable -->
<script>
  $(function () {
    $('#myTab a[href="#tab1"]').tab('show');
  })
</script>					
				</div>
			</div>
		</div> <!-- /container -->	
	</body>
</html>
