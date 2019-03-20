<?php

require_once('config.php');
require_once('functions.php');

if(isset($_GET["toggle"]) AND $_GET["toggle"] != ""){
	if(isset($_SESSION['tinymce_toggle_view'])){
		if($_SESSION['tinymce_toggle_view'] == 'grid'){
			$_SESSION['tinymce_toggle_view'] = 'list';	
		}else{
			$_SESSION['tinymce_toggle_view'] = 'grid';	
		}
	}else{
		$_SESSION['tinymce_toggle_view'] = 'list';	
	}
}

$output = array();

$output["success"] = 1;

if(isset($_GET["path"]) AND $_GET["path"] != ""){
	if(!startsWith(urldecode($_GET["path"]), LIBRARY_FOLDER_PATH)){
		$current_folder = LIBRARY_FOLDER_PATH;
	}else{
		$current_folder = urldecode(clean($_GET["path"]));
	}
}else{
	$current_folder = LIBRARY_FOLDER_PATH;
}

include 'contents.php';


header("Content-type: text/plain;");
echo json_encode($output);
exit();
