<?php

$servername = "localhost";
$dBUsername = "root";
$dBPassword = "";
$dBName = "viewcount";

$conn = mysqli_connect($servername, $dBUsername, $dBPassword, $dBName);

if (!$conn) {
	die("Verbindung unterbrochen: ".mysqli_connect_error());
}