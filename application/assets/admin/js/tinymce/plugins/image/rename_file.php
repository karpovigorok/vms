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


if(!CanRenameFiles()){
	$output["success"] = 0;
	$output["msg"] = lang('you_do_not_have_permission_to_rename_files');
	header("Content-type: text/plain;");
	echo json_encode($output);
	exit();
}

if(isset($_GET["new_name"]) AND $_GET["new_name"] != ""){
	$new_name = clean($_GET["new_name"]);
}else{
	$output["success"] = 0;
	$output["msg"] = lang('the_new_name_is_required');
	header("Content-type: text/plain;");
	echo json_encode($output);
	exit();
}

if(isset($_GET["current_name"]) AND $_GET["current_name"] != ""){
	$current_name = clean($_GET["current_name"]);
	$file = $current_folder .  $current_name;
}else{
	$output["success"] = 0;
	$output["msg"] = lang('the_current_name_is_required');
	header("Content-type: text/plain;");
	echo json_encode($output);
	exit();
}

if(!startsWith($file, LIBRARY_FOLDER_PATH)){
	$output["success"] = 0;
	$output["msg"] = lang('you_can_not_edit_this_file');
	header("Content-type: text/plain;");
	echo json_encode($output);
	exit();
}

if(!file_exists($file)){
	$output["success"] = 0;
	$output["msg"] = lang('the_file_does_not_exist');
	header("Content-type: text/plain;");
	echo json_encode($output);
	exit();
}

if(!is_file($file)){
	$output["success"] = 0;
	$output["msg"] = lang('that_is_not_a_file');
	header("Content-type: text/plain;");
	echo json_encode($output);
	exit();
}

if(file_exists(($current_folder .  $new_name))){
	$output["success"] = 0;
	$output["msg"] = lang('the_new_name_is_already_in_use');
	header("Content-type: text/plain;");
	echo json_encode($output);
	exit();
}

rename(($current_folder .  $current_name), ($current_folder .  $new_name));

include 'contents.php';


header("Content-type: text/plain;");
echo json_encode($output);
exit();
