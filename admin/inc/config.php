<?php
// Error Reporting Turn On
ini_set('error_reporting', E_ALL);

// Setting up the time zone
date_default_timezone_set('Asia/Kolkata');

// Host Name
$dbhost = 'localhost';

// Database Name
$dbname = 'ctrlclick';
// $dbname = 'ctrl_ctrlclick_db';

// Database Username
$dbuser = 'root';
// $dbuser = 'ctrl_ctrlclick_user';

// Database Password
// $dbpass = 'xd^%rmfs!qriBD71';
$dbpass = '';


try {
	$pdo = new PDO("mysql:host={$dbhost};dbname={$dbname}", $dbuser, $dbpass);
	$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}
catch( PDOException $exception ) {
	echo "Connection error :" . $exception->getMessage();
}