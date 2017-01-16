<?php
define('HOST', 'localhost');

// define('USER', 'root');
// define('PASS', '');
// define('DB', 'db_images');

define('USER', 'olbx_chintan');
define('PASS', '1/2*3-4+56789');
define('DB', 'olbx_db_images');

$con = mysqli_connect(HOST,USER,PASS,DB) or die('Unable to Connect...');