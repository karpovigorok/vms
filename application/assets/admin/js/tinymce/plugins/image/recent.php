<?php

require_once('config.php');
require_once('functions.php');

$output = array();

$output["success"] = 1;

if(isset($_SESSION['SimpleImageManager']) AND count($_SESSION['SimpleImageManager']) > 0){
	$html = '';
	foreach($_SESSION['SimpleImageManager'] as $s){
		$me = false;
		$exists = is_url_exist($s);
		$url_host = parse_url($s, PHP_URL_HOST);
		if($url_host == $_SERVER['HTTP_HOST']){
			$me = true;
		}
		
		if($exists == false){
			continue;
		}
		
		$extension = GetExtension($s);
		
		if($me){
            if(!is_image_extenstion($extension)){
				$html .= '<div class="item"><a data-icon="'.get_file_icon_path($extension).'" href="" class="pdf-thumbs" title="' .$s . '" rel="' .$s . '"><img src="' . get_file_icon_path($extension) . '" class="img-polaroid" width="130" height="90"></a></div>';
			}else{
				$html .= '<div class="item"><a href="" class="img-thumbs" title="' .$s . '" rel="' .$s . '"><img src="timthumb.php?src=' . $s . '&w=130&h=90" class="img-polaroid" width="130" height="90"></a></div>';
			}
		}elseif($exists){
			$html .= '<div class="item"><a href="" class="img-thumbs" title="' .$s . '" rel="' .$s . '"><img src="' . $s . '" class="img-polaroid" width="130" height="90"></a></div>';
		}
	}
	if($html != ''){
		$output["html"] = $html;
	}else{
		$output["success"] = 0;
	}
}else{
	$output["success"] = 0;
}

header("Content-type: text/plain;");
echo json_encode($output);
exit();
