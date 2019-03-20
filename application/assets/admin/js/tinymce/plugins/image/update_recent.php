<?php

require_once('config.php');
require_once('functions.php');

if(isset($_POST["src"]) AND is_url_exist(clean($_POST["src"]))){
	if(!isset($_SESSION['SimpleImageManager'])){
		$_SESSION['SimpleImageManager'] = array();
		$_SESSION['SimpleImageManager'][] = clean($_POST["src"]);
	}else{
		if(!in_array(clean($_POST["src"]), $_SESSION['SimpleImageManager'])){
			$_SESSION['SimpleImageManager'][] = clean($_POST["src"]);
		}
	}
	
}
