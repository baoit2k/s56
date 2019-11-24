<?php
$host = "localhost";
$username = "id8930202_bot";
$password = "12345";
$dbname = "id8930202_bot";

$page_name = 'xxx.local';
$version = 'v.1,1';

$connection = mysqli_connect($host,$username,$password);

if (!$connection)

{

die('Could not connect: ' . mysqli_error($connection));

}

mysqli_select_db($connection, $dbname) or die(mysqli_error($connection));

mysqli_query($connection, "SET NAMES utf8");
