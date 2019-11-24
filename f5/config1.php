<?php
$host = "localhost";
$username = "vkopuijw_anonytrick";
$password = "vkopuijw_anonytrick";
$dbname = "vkopuijw_anonytrick";
$conn = mysqli_connect($host,$username,$password,$dbname);
if(!$conn){
   die('Ket noi that bai:'.mysqli_connect_error());
}
mysqli_set_charset($conn,"utf8");
?>