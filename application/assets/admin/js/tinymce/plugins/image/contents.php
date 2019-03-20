<?php

if(isset($_SESSION['tinymce_toggle_view'])){
	$view = $_SESSION['tinymce_toggle_view'];
}else{
	$view = 'grid';
}

$current_folder_content = scandirSorted($current_folder);

if(isset($_GET['page'])){
	$page = intval($_GET['page']);
}else{
	$page = 1;
}
$rows = ROWS_PER_PAGE;
$offset = ($page -1) * $rows;

$number_of_records = count($current_folder_content);

$latest = array_slice($current_folder_content, $offset, $rows);

$number_of_pages = ceil( $number_of_records / $rows );

if(count($latest) > 0 AND CanAcessLibrary()){
	$html = '';
	foreach($latest as $c){
		if($view == 'list'){
			if($c['is_file'] == false){
				$html .= '<tr>
				<td>
				<i class="icon-folder-open"></i>&nbsp;
				<a class="lib-folder" href="" rel="'. urlencode($c['path']).'" title="'. $c['name'] .'">
					'. TrimText($c['name'], 50) .'
				</a>
				</td>
				<td width="20%">
				'. $c['i'] .' Items
				</td>
				<td width="10%">
					<a href="" class="transparent change-folder" title="'.lang('change_name').'" rel="'. $c['name'] .'"><i class="icon-pencil"></i></a>&nbsp;&nbsp;
					<a href="" class="transparent delete-folder" rel="'. urlencode($c['path']).'" title="'.lang('delete').'"><i class="icon-trash"></i></a>
				</td>
				</tr>';
			}else{
				$extension = GetExtension($c['name']);
				
				if(!is_image_extenstion($extension)){
					$html .= '<tr>
					<td>
					<i class="icon-picture"></i>&nbsp;
					<a href="" class="pdf-thumbs" rel="' .$c['path'] . '" title="'. $c['name'] .'">
						'. TrimText($c['name'], 50) .'
					</a>
					</td>
					<td width="20%">
					'. formatSizeUnits($c['s']) .'
					</td>
					<td width="10%">
						<a href="" class="transparent change-file" title="'.lang('change_name').'" rel="'. $c['name'] .'"><i class="icon-pencil"></i></a>&nbsp;&nbsp;
						<a href="" class="transparent delete-file" rel="'. urlencode($c['p']).'" title="'.lang('delete').'"><i class="icon-trash"></i></a>
					</td>
					</tr>';	
				}else{	
					$html .= '<tr>
					<td>
					<i class="icon-picture"></i>&nbsp;
					<a href="" class="img-thumbs" rel="' .$c['path'] . '" title="'. $c['name'] .'">
						'. TrimText($c['name'], 50) .'
					</a>
					</td>
					<td width="20%">
					'. formatSizeUnits($c['s']) .'
					</td>
					<td width="10%">
						<a href="" class="transparent change-file" title="'.lang('change_name').'" rel="'. $c['name'] .'"><i class="icon-pencil"></i></a>&nbsp;&nbsp;
						<a href="" class="transparent delete-file" rel="'. urlencode($c['p']).'" title="'.lang('delete').'"><i class="icon-trash"></i></a>
					</td>
					</tr>';
				}
			}
		
		}else{
			if($c['is_file'] == false){
				$html .= '<div class="item">
			<a class="lib-folder" href="" rel="'. urlencode($c['path']).'" title="'. $c['name'] .'">
			<img src="bootstrap/img/130x90.png" class="img-polaroid" width="130" height="90">
			</a>
			<div>
			<a href="" class="pull-left transparent change-folder" title="'.lang('change_name').'" rel="'. $c['name'] .'"><i class="icon-pencil"></i></a>
			<a href="" class="pull-right transparent delete-folder" rel="'. urlencode($c['path']).'" title="'.lang('delete').'"><i class="icon-trash"></i></a>
			<div class="clearfix"></div>
			<p class="caption">'. TrimText($c['name'], 17) .'</p>
			</div>
			</div>';
			}else{
				$extension = GetExtension($c['name']);
				
				if(!is_image_extenstion($extension)){
					$html .= '<div class="item">
				<a href="" class="pdf-thumbs" data-icon="'.get_file_icon_path($extension).'" rel="' .$c['path'] . '" title="'. $c['name'] .'">
				<img src="' . get_file_icon_path($extension) . '" class="img-polaroid" width="130" height="90">
				</a>
				<div>
				<a href="" class="pull-left transparent change-file" title="'.lang('change_name').'" rel="'. $c['name'] .'"><i class="icon-pencil"></i></a>
				<a href="" class="pull-right transparent delete-file" data-path="'. urlencode($c['x']).'" rel="'. urlencode($c['p']).'" title="'.lang('delete').'"><i class="icon-trash"></i></a>
				<div class="clearfix"></div>
				<p class="caption">'. TrimText($c['name'], 17) .'</p>
				</div>
				</div>';
				}else{	
					$html .= '<div class="item">
				<a href="" class="img-thumbs" rel="' .$c['path'] . '" title="'. $c['name'] .'">
				<img src="timthumb.php?src=' . $c['path'] . '&w=130&h=90" class="img-polaroid" width="130" height="90">
				</a>
				<div>
				<a href="" class="pull-left transparent change-file" title="'.lang('change_name').'" rel="'. $c['name'] .'"><i class="icon-pencil"></i></a>
				<a href="" class="pull-right transparent delete-file" data-path="'. urlencode($c['x']).'" rel="'. urlencode($c['p']).'" title="'.lang('delete').'"><i class="icon-trash"></i></a>
				<div class="clearfix"></div>
				<p class="caption">'. TrimText($c['name'], 17) .'</p>
				</div>
				</div>';
				}
			}
		}
	}
	if($html != ''){
		if($view == 'list'){
			$html = '<br/><table class="table">' . $html . '</table>';
		}

		$output["html"] = $html . '<div class="clearfix"></div><div style="margin-top: 20px;"><center>'.Paginate($current_folder, $page, $number_of_pages, 3).'</center></div>';
	}else{
		$output["html"] = '<center>'.lang('no_images_in_the_folder').'</center>';
	}
}else{
	$output["html"] = '<center>'.lang('no_images_in_the_folder').'</center>';
}
