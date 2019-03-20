@extends('admin.master')

@section('css')	
	<link rel="stylesheet" href="{{ '/application/assets/admin/css/media/media.css' }}" />
	<link rel="stylesheet" type="text/css" href="{{ '/application/assets/admin/js/select2-x/select2.css' }}">
	<link rel="stylesheet" href="{{ '/application/assets/admin/css/media/dropzone.css' }}" />
@stop

@section('content')

<div id="admin-container" class="media-section">
<!-- This is where -->
	
	<div class="admin-section-title">
		<h3><i class="entypo-picture"></i> <?php echo _i("Media");?></h3>
	</div>
	<div class="clear"></div>

	<div id="filemanager">

		<div id="toolbar">
			<div class="btn-group offset-right">
                <button type="button" class="btn btn-primary" id="upload"><i class="fa fa-upload"></i> <?php echo _i("Upload");?></button>
                <button type="button" class="btn btn-primary" id="new_folder" onclick="jQuery('#new_folder_modal').modal('show');">
                    <i class="fa fa-folder"></i> <?php echo _i("Add folder");?></button>
            </div>
            <button type="button" class="btn btn-default" id="refresh"><i class="fa fa-refresh"></i></button>
			<div class="btn-group offset-right">
                <button type="button" class="btn btn-default" id="move"><i class="fa fa-reply-all"></i> <?php echo _i("Move");?></button>
                <button type="button" class="btn btn-default" id="delete"><i class="fa fa-trash"></i> <?php echo _i("Delete");?></button>
            </div>
		</div>

		<div id="uploadPreview" style="display:none;"></div>
		
		<div id="uploadProgress" class="progress active progress-striped">
			<div class="progress-bar progress-bar-success" style="width: 0%"></div>
		</div>
		
		<div class="loader"></div>

		<div id="content">


		<div class="breadcrumb-container">
			<ol class="breadcrumb filemanager">
				<li data-folder="/" data-index="0"><span class="arrow"></span><strong><?php echo _i("Media Library");?></strong></li>
				<template v-for="folder in folders">
					<li data-folder="@{{folder}}" data-index="@{{ $index+1 }}"><span class="arrow"></span>@{{folder}}</li>
				</template>
			</ol>

			<div class="toggle"><span><?php echo _i("Close");?></span><i class="icon fa fa-toggle-right"></i></div>
		</div>
			<div class="flex">

				<div id="left">

					<ul id="files">
						
						<li v-for="file in files.items">
							<div class="file_link @{{file.type}}" data-folder="@{{file.name}}" data-index="@{{ $index }}">
								<div class="link_icon">
									<i class="icon"></i>
									<template v-if="file.type == 'image'">
										<div class="img_icon" style="background-image:url({{ URL::to('/') }}@{{file.path.replace('./', '/')}}); background-position:center center; background-size: auto 50px; background-repeat:no-repeat"></div>
									</template>	
									
								</div>
								<div class="details"><h4>@{{ file.name }}</h4><small><span class="num_items">@{{ file.items }} item(s)</span><span class="file_size">@{{ file.size }}</span></small></div>
							</div>
						</li>

					</ul>

					<div id="no_files">
						 <h3><i class="fa fa-meh-o"></i> <?php echo _i("No files in this folder.");?></h3>
					</div>

				</div>

				<div id="right">
					<div class="right_none_selected">
						<i class="fa fa-mouse-pointer"></i>
						<p><?php echo _i("No File or Folder Selected");?></p>
					</div>
					<div class="right_details">
						<div class="detail_img @{{selected_file.type}}">
							<template v-if="selected_file.type == 'image'">
								<img src="/@{{selected_file.path}}" />
							</template>
							<template v-if="selected_file.type == 'video'">
								<video width="100%" height="auto" controls>
									<source src="/@{{selected_file.path}}" type="video/mp4">
									<source src="/@{{selected_file.path}}" type="video/ogg">
									<source src="/@{{selected_file.path}}" type="video/webm">
									Your browser does not support the video tag.
								</video>
							</template>
							<template v-if="selected_file.type == 'audio'">
								<audio controls style="width:100%; margin-top:5px;">
									<source src="/@{{selected_file.path}}" type="audio/ogg">
									<source src="/@{{selected_file.path}}" type="audio/mpeg">
									Your browser does not support the audio element.
								</audio>
							</template>
							<template v-if="selected_file.type == 'file'">
								<i class="fa fa-file"></i>
							</template>
							<i class="fa fa-folder"></i>
						</div>
						<div class="detail_info @{{selected_file.type}}">
							<span><h4><?php echo _i("Title");?>:</h4>
							<p>@{{selected_file.name}}</p></span>
							<span><h4><?php echo _i("Size");?>:</h4>
							<p><span class="selected_file_count">@{{ selected_file.items }} item(s)</span><span class="selected_file_size">@{{selected_file.size}}</span></p></span>
							<span><h4><?php echo _i("Public URL");?>:</h4>
							<p><a href="{{ URL::to('/') }}@{{selected_file.path.replace('./', '/')}}" target="_blank"><?php echo _i("Click Here");?></a></p></span>
							<span><h4><?php echo _i("Last Modified");?>:</h4>
							<p>@{{selected_file.last_modified}}</p></span>
						</div>
					</div>

				</div>

			</div>

			<div class="nothingfound">
				<div class="nofiles"></div>
				<span><?php echo _i("No files here.");?></span>
			</div>
		
		</div>

		<!-- Move File Modal -->
		<div class="modal fade" id="move_file_modal">
			<div class="modal-dialog">
				<div class="modal-content">
					
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
						<h4 class="modal-title"><i class="fa fa-reply"></i> <?php echo _i("Move File/Folder");?></h4>
					</div>
					
					<div class="modal-body">
					   <h4><?php echo _i("Destination Folder");?></h4>
					   <select id="move_folder_dropdown">
					  		<option value="">media/</option>
					   		<template v-for="dir in directories">
					   			<option value="@{{ dir }}">media/@{{ dir }}/</option>
					   		</template>
					   </select>
					</div>
					
					<div class="modal-footer">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _i("Cancel");?></button>
						<button type="button" class="btn btn-warning" id="move_btn"><?php echo _i("Move");?></button>
					</div>
				</div>
			</div>
		</div>
		<!-- End Move File Modal -->			

	</div><!-- #filemanager -->

	<!-- New Folder Modal -->
	<div class="modal fade" id="new_folder_modal">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-folder"></i> <?php echo _i("Add New Folder");?></h4>
				</div>
				
				<div class="modal-body">
				   <input name="new_folder_name" id="new_folder_name" placeholder="<?php echo _i("New Folder Name");?>" class="form-control" value="" />
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _i("Cancel");?></button>
					<button type="button" class="btn btn-info" id="new_folder_submit"><?php echo _i("Create New Folder");?></button>
				</div>
			</div>
		</div>
	</div>
	<!-- End New Folder Modal -->

	<!-- Delete File Modal -->
	<div class="modal fade" id="confirm_delete_modal">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-warning"></i> <?php echo _i("Are You Sure");?></h4>
				</div>
				
				<div class="modal-body">
				   <h4><?php echo _i("Are you sure you want to delete");?> '<span class="confirm_delete_name"></span>'</h4>
				   <h5 class="folder_warning"><i class="fa fa-warning"></i> <?php echo _i("Deleting a folder will remove all files and folders contained inside");?></h5>
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo _i("Cancel");?></button>
					<button type="button" class="btn btn-danger" id="confirm_delete"><?php echo _i("Yes, Delete it!");?></button>
				</div>
			</div>
		</div>
	</div>
	<!-- End Delete File Modal -->

<div id="dropzone"></div>
	<!-- Delete File Modal -->
	<div class="modal fade" id="upload_files_modal">
		<div class="modal-dialog">
			<div class="modal-content">
				
				<div class="modal-header">
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
					<h4 class="modal-title"><i class="fa fa-warning"></i> <?php echo _i("Drag and drop files or click below to upload");?></h4>
				</div>
				
				<div class="modal-body">
				   
				</div>
				
				<div class="modal-footer">
					<button type="button" class="btn btn-success" data-dismiss="modal"><?php echo _i("All done");?></button>
				</div>
			</div>
		</div>
	</div>
	<!-- End Delete File Modal -->
</div>
	<!-- Include our script files -->
	<script src="{{ '/application/assets/admin/js/jquery-1.11.0.min.js' }}"></script>
	<script src="{{ '/application/assets/admin/js/select2-x/select2.min.js' }}"></script>
	<script src="{{ '/application/assets/admin/js/media/dropzone.js' }}"></script>
	<script src="{{ '/application/assets/admin/js/media/media.js' }}"></script>
@stop