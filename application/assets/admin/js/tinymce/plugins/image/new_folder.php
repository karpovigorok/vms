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


if(!is_writable($current_folder)){
	$output["success"] = 0;
	$output["msg"] = lang('the_current_folder_is_not_writable');
	header("Content-type: text/plain;");
	echo json_encode($output);
	exit();
}

if(!CanCreateFolders()){
	$output["success"] = 0;
	$output["msg"] = lang('you_do_not_have_permission_to_create_folders');
	header("Content-type: text/plain;");
	echo json_encode($output);
	exit();
}

if(isset($_GET["folder"]) AND $_GET["folder"] != ""){
	$new_folder = $current_folder . '/' . clean($_GET["folder"]);
}else{
	$output["success"] = 0;
	$output["msg"] = lang('the_new_folder_name_is_required');
	header("Content-type: text/plain;");
	echo json_encode($output);
	exit();
}

if(file_exists($new_folder)) {
	$output["success"] = 0;
	$output["msg"] = lang('another_folder_with_the_same_name_exists');
	header("Content-type: text/plain;");
	echo json_encode($output);
	exit();   
}

if(!strpbrk($_GET["folder"], "\\/?%*:|\"<>") === FALSE){
	$output["success"] = 0;
	$output["msg"] = lang('the_folder_name_is_invalid');
	header("Content-type: text/plain;");
	echo json_encode($output);
	exit(); 
}

$old = umask(0);
if(!mkdir($new_folder, 0777)){
	$output["success"] = 0;
	$output["msg"] = lang('the_folder_could_not_be_created');
	header("Content-type: text/plain;");
	echo json_encode($output);
	exit(); 
}
umask($old);

include 'contents.php';


header("Content-type: text/plain;");
echo json_encode($output);
exit();
