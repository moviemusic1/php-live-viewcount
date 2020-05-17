<?php 

require "dbh.inc.php";

if(!isset($_POST['request']) || isset($_POST['request']) && $_POST['request'] == "post") {
	header('Location: ../home');
	exit();
}

if(!isset($_COOKIE['viewcount_userid'])) {
	header('Location: ../home');
	exit();
}

$userid = mysqli_real_escape_string($conn, $_COOKIE['viewcount_userid']);
$time = time();
$checkID = mysqli_query($conn, "SELECT * FROM usercount WHERE userid='$userid'");
if(mysqli_num_rows($checkID) <= 0) {
	mysqli_query($conn, "INSERT INTO usercount (userid, last_timestamp) VALUES ('$userid', '$time')");
} else {
	mysqli_query($conn, "UPDATE usercount SET last_timestamp='$time' WHERE userid='$userid'");
}

return "";