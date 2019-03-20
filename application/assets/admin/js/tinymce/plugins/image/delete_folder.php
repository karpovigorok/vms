<?php

require_once('config.php');
require_once('functions.php');

$output = array();

$output["success"] = 1;
$output["msg"] = "";

if(isset($_GET["path"]) AND $_GET["path"] != ""){
	$current_folder = urldecode(clean($_GET["path"]));
}else{
	$current_folder = LIBRARY_FOLDER_PATH;
}


if(!CanDeleteFolder()){
	$output["success"] = 0;
	$output["msg"] = lang('you_do_not_have_the_permission_to_delete_folders');
	header("Content-type: text/plain;");
	echo json_encode($output);
	exit();
}

if(isset($_GET["folder"]) AND $_GET["folder"] != ""){
	$folder = urldecode(clean($_GET["folder"]));
}else{
	$output["success"] = 0;
	$output["msg"] = lang('the_folder_name_is_required');
	header("Content-type: text/plain;");
	echo json_encode($output);
	exit();
}

if(!startsWith($folder, LIBRARY_FOLDER_PATH)){
	$output["success"] = 0;
	$output["msg"] = lang('you_can_not_delete_folder');
	header("Content-type: text/plain;");
	echo json_encode($output);
	exit();
}

if(!file_exists($folder)){
	$output["success"] = 0;
	$output["msg"] = lang('the_folder_does_not_exist');
	header("Content-type: text/plain;");
	echo json_encode($output);
	exit();
}

if(!is_dir($folder)){
	$output["success"] = 0;
	$output["msg"] = lang('that_is_not_a_folder');
	header("Content-type: text/plain;");
	echo json_encode($output);
	exit();
}

lc_delete($folder);


include 'contents.php';


header("Content-type: text/plain;");
echo json_encode($output);
exit();
