<?php
// Initialize the session
session_start();
// Check if the user is logged in, if not then redirect him to login page
if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: index.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<?php include("head.php"); ?>
<body>
    <center>
    <div class="page-header">
        <h1>Xin Chào, <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Vui Lòng Tải Lại Trang Để Nhận Token Mới.</h1>
    </div></center>
   
<?php
//config database chứa token 
$host = "localhost"; //host
$username = "vkopuijw_anonytrick"; //username database
$password = "vkopuijw_anonytrick"; //database password
$dbname = "vkopuijw_anonytrick"; // database name
$connection = mysql_connect($host,$username,$password);
if (!$connection)
  {
  die('Could not connect: ' . mysql_error());
  }
mysql_select_db($dbname) or die(mysql_error());
mysql_query("SET NAMES utf8");
$listtoken = mysql_query("SELECT * FROM `token` ORDER BY RAND() LIMIT 0,1"); //số token 1 lần F5
while ($gettk = mysql_fetch_array($listtoken)){
$tokenok= trim($gettk['token']);

echo $tokenok."</br>"; }
?>
    <p>

        <center><a href="logout.php" class="btn btn-danger">Đăng Xuất Khỏi Hệ Thống</a></center>
    </p>
</body>
</html>