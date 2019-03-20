<?php

require_once('config.php');
require_once('functions.php');
require_once('Image_lib.php');

$output = DoUpload('upl');

header("Content-type: text/plain;");
echo json_encode($output);
exit();
