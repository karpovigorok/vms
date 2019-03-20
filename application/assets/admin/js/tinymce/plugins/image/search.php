<?php

require_once('config.php');
require_once('functions.php');

$output = SearchFiles(LIBRARY_FOLDER_PATH);

header("Content-type: text/plain;");
echo json_encode($output);
exit();
