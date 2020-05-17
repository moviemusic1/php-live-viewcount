<?php 

require "dbh.inc.php";

if(!isset($_COOKIE['viewcount_userid'])) {
	header('Location: home');
	exit();
}

$userid = mysqli_real_escape_string($conn, $_COOKIE['viewcount_userid']);
$time = time();
$deleteOldEntries = mysqli_query($conn, "DELETE FROM usercount WHERE last_timestamp < '$time' - 20");
$checkID = mysqli_query($conn, "SELECT * FROM usercount ORDER BY last_timestamp DESC");
$usercount = 0;

$response = array();

foreach($checkID as $user) {
	$timestamp = $user['last_timestamp'];
	if(time() - $timestamp < 30) {
		$usercount++;
	}
}

echo $usercount;