<?php
/* Database credentials. Assuming you are running MySQL
server with default setting (user 'root' with no password) */
define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'vkopuijw_anonytrick');
define('DB_PASSWORD', 'vkopuijw_anonytrick');
define('DB_NAME', 'vkopuijw_anonytrick');
/* Attempt to connect to MySQL database */
$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);
// Check connection
if($link === false){
    die("ERROR: Khong the ket noi. " . mysqli_connect_error());
}
?>