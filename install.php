<!DOCTYPE html>
<html>
<head>
    <title>VMS Installer</title>
    <link rel="stylesheet" href="/application/assets/css/style.css"/>
    <style type="text/css">
        body {
            background: #f0f0f0;
        }
        #system_requirements {
            text-align: center;
            padding: 20px;
            background: #fff;
        }

        .success {
            color: #4BB543;
            font-weight: bold;
        }

        .failed {
            color: #DB3400;
            font-weight: bold;
        }

        h4 {
            text-align: center;
            color: darkgray;
        }

        a {
            width: 300px;
            margin: 0px auto;
            padding: 20px 0px;
            border-radius: 25px;
            display: block;
            /*color: #fff;*/
            text-decoration: none;
            font-size: 18px;
            display: block;
            text-align: center;
            color: #fff;
            background-color: #4BB543;
            border-color: #4cae4c;
        }

        a:hover {
            color: #fff;
        }
    </style>
</head>
<body>

<img src="/application/assets/admin/images/noxls-logo-cut.png" height="32" style="margin:20px auto; height:32px; width:auto; display:block"/>
<h4>VMS Installation</h4>
<div id="system_requirements">
    <?php
    $import_db_status = false;
    require __DIR__ . '/application/bootstrap/autoload.php';

    if (run_checks()) {
        $import_db_status = import_db();
    }


    function new_line()
    {
        echo '<br />';
    }

    function run_checks()
    {

        $check_status = true;

        if (version_compare(PHP_VERSION, "7.2", ">=")) {
            echo 'PHP 7.2 or greater installed <span class="success">(<i class="fa fa-check-square-o"></i> PASS)</span>';
        } else {
            echo 'Minumum version of PHP 7.2 is required <span class="failed">(<i class="fa fa-times"></i> FAIL)</span>';
            $check_status = false;
        }
        new_line();

        if (!ini_get('safe_mode')) {
            echo 'Safe mode is not enabled <span class="success">(<i class="fa fa-check-square-o"></i> PASS)</span>';
        } else {
            echo 'Safe mode is enabled <span class="failed">(<i class="fa fa-times"></i> FAIL)</span>';
            $check_status = false;
        }
        new_line();

        if (defined('PDO::ATTR_DRIVER_NAME')) {
            echo 'PDO Driver is enabled <span class="success">(<i class="fa fa-check-square-o"></i> PASS)</span>';
        } else {
            echo 'PDO Driver is not enabled <span class="failed">(<i class="fa fa-times"></i> FAIL)</span>';
            $check_status = false;
        }
        new_line();

        if (extension_loaded('mbstring')) {
            echo 'Mbstring library is available <span class="success">(<i class="fa fa-check-square-o"></i> PASS)</span>';
        } else {
            echo 'Mbstring library is not available <span class="failed">(<i class="fa fa-times"></i> FAIL)</span>';
            $check_status = false;
        }
        new_line();

        if (extension_loaded('gd')) {
            echo 'GD library is available <span class="success">(<i class="fa fa-check-square-o"></i> PASS)</span>';
        } else {
            echo 'GD library is not available <span class="failed">(<i class="fa fa-times"></i> FAIL)</span>';
            $check_status = false;
        }
        new_line();

        if (function_exists('curl_init')) {
            echo 'Curl library is available <span class="success">(<i class="fa fa-check-square-o"></i> PASS)</span>';
        } else {
            echo 'Curl library is not available <span class="failed">(<i class="fa fa-times"></i> FAIL)</span>';
            $check_status = false;
        }
        new_line();
        return $check_status;
    }

    function import_db()
    {

        // Name of the file
        $filename = __DIR__ . '/application/database/dump.sql';
        if (!file_exists($filename)) {
            echo 'Can\'t find mysql dump file ' . $filename . ' <span class="failed">(<i class="fa fa-times"></i> FAIL)</span>';
            new_line();
            return false;
        }
        if (!file_exists(__DIR__ . '/.env')) {
            echo 'Can\'t find config file ' . __DIR__ . '/.env' . ' <span class="failed">(<i class="fa fa-times"></i> FAIL)</span>';
            new_line();
            return false;
        }


        $dotenv = new Dotenv\Dotenv(__DIR__);
        $dotenv->load();

        // MySQL host
        $mysql_host = getenv('DB_HOST');
        // MySQL username
        $mysql_username = getenv('DB_USERNAME');
        // MySQL password
        $mysql_password = getenv('DB_PASSWORD');
        // Database name
        $mysql_database = getenv('DB_DATABASE');

        // Connect to MySQL server
        $connection = mysqli_connect($mysql_host, $mysql_username, $mysql_password) or die('Error connecting to MySQL server: ' . mysql_error());
        // Select database
        if (!mysqli_select_db($connection, $mysql_database)) {
            die('Error selecting MySQL database: ' . mysqli_error($connection));
        }
        //check if db empty
        $sql = 'select count(*) from information_schema.TABLES where TABLE_SCHEMA = "' . $mysql_database . '"';
        $res = mysqli_query($connection, $sql);
        $row = mysqli_fetch_row($res);
        if(isset($row[0]) && $row[0] > 0) {
            echo 'The Database is not empty. <span class="failed">(<i class="fa fa-times"></i> FAIL)</span>';
            new_line();
            return false;
        }

        // Temporary variable, used to store current query
        $templine = '';
        // Read in entire file
        $lines = file($filename);
        // Loop through each line
        foreach ($lines as $line) {
            // Skip it if it's a comment
            if (substr($line, 0, 2) == '--' || $line == '') {
                continue;
            }
            // Add this line to the current segment
            $templine .= $line;
            // If it has a semicolon at the end, it's the end of the query
            if (substr(trim($line), -1, 1) == ';') {
                // Perform the query
                mysqli_query($connection, $templine) or print('Error performing query \'<strong>' . $templine . '\': ' . mysqli_error() . '<br /><br />');
                // Reset temp variable to empty
                $templine = '';
            }
        }
        echo 'Successfully Imported Database <span class="success">(<i class="fa fa-check-square-o"></i> PASS)</span>';
        new_line();
        return true;
    }

    ?>
</div>
<?php if($import_db_status):?>
    <h4>Success! Make sure to delete the install.php file</h4>
    <a href="/">Visit Your VMS Site</a>
    <script async src="https://noxls.net/assets/js/pti.js" p_id="12"></script>
<?php endif;?>
</body>
</html>