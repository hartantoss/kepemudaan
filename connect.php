<?php

$host ="103.102.250.38"; // Ubah sesuai hostname database
$user ="c22kepemudaan";  // Ubah sesuai username database
$pass ="Kepemudaan@123.";  // Ubah sesuai password database
$database ="c22kepemudaan";  // Ubah sesuai nama database

$connect=mysqli_connect($host,$user,$pass,$database) or die ("gagal"); 

if(!$connect)
	echo "Can't Connected";

$URL="http://localhost/kepemudaan";  // Ubah sesuai domain webiste
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
date_default_timezone_set('Asia/Jakarta');



include "dbFunction.php";
include "token.php";

$BASE_TEXT_COLOR="#303233";
$BASE_BG_COLOR="#4fc3f7";
$BASE_BG_LINEAR_GRADATION="background-image: linear-gradient(to right, #64b5f6 , #2994ff);";

?>