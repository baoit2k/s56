<?php
// Chèn file config
require_once "config.php";
// Xác định biến và khởi tạo với giá trị trống
$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
// Xử lý dữ liệu biểu mẫu khi biểu mẫu được gửi
if($_SERVER["REQUEST_METHOD"] == "POST"){
    // Xác thực tên người dùng
    if(empty(trim($_POST["username"]))){
        $username_err = "Please enter a username.";
    } else{
        // Chuẩn bị một câu lệnh chọn
        $sql = "SELECT id FROM users WHERE username = ?";
     
        if($stmt = mysqli_prepare($link, $sql)){
            // Ràng buộc các biến vào câu lệnh đã chuẩn bị làm tham số
            mysqli_stmt_bind_param($stmt, "s", $param_username);
         
            // Đặt thông số
            $param_username = trim($_POST["username"]);
         
            // Cố gắng thực thi câu lệnh đã chuẩn bị
            if(mysqli_stmt_execute($stmt)){
                /* store result */
                mysqli_stmt_store_result($stmt);
             
                if(mysqli_stmt_num_rows($stmt) == 1){
                    $username_err = "Tên người dùng này đã được sử dụng.";
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Rất tiếc! Đã xảy ra sự cố. Vui lòng thử lại sau.";
            }
        }
       
        // Câu lệnh đóng
        mysqli_stmt_close($stmt);
    }
 
    // Xác nhận mật khẩu
    if(empty(trim($_POST["password"]))){
        $password_err = "Please enter a password.";   
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Mật khẩu phải có ít nhất 6 ký tự.";
    } else{
        $password = trim($_POST["password"]);
    }
 
    // Xác nhận mật khẩu xác nhận
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please confirm password.";   
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Mật khẩu không khớp.";
        }
    }
 
    // Kiểm tra lỗi đầu vào trước khi chèn vào cơ sở dữ liệu
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
     
        // Chuẩn bị một câu lệnh chèn
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
       
        if($stmt = mysqli_prepare($link, $sql)){
            // Ràng buộc các biến vào câu lệnh đã chuẩn bị làm tham số
            mysqli_stmt_bind_param($stmt, "ss", $param_username, $param_password);
         
            // Đặt thông số
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash
         
            // Cố gắng thực thi câu lệnh đã chuẩn bị
            if(mysqli_stmt_execute($stmt)){
                // Redirect to login pages
                header("location: index.php");
            } else{
                echo "Đã xảy ra sự cố. Vui lòng thử lại sau.";
            }
        }
       
        // Câu lệnh đóng
        mysqli_stmt_close($stmt);
    }
 
    // Đóng kết nối
    mysqli_close($link);
}
?>
<!DOCTYPE html>
<html lang="en">
      <?php include("head.php"); ?>
<body>
<div class="container">

  

    <div class="row">
  
        <div class="col-md-12">
        
            <div class="panel panel-default">
            
                <div class="panel-body">
    <div class="panel panel-default">



  <div class="panel-body">
      
    <div class="row">
      
    </div>
    <!-- /.row -->
    <div class="row">
        <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
            <div class="form-group">
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
                <label>Nhập User Name Người Dùng</label>
                <input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
                <span class="help-block"><?php echo $username_err; ?></span>
            </div> 
            <div  class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
                <label>Key Của Người Dùng</label>
                <input type="password" name="password" class="form-control" value="<?php echo $password; ?>">
                <span class="help-block"><?php echo $password_err; ?></span>
            </div>
            <div  class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
                <label>Nhập lại Key</label>
                <input type="password" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
                <span class="help-block"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Tạo Người Dùng">
            </div>

        </form>
        							<?php
	include 'config1.php';
	$table = 'token'; // table lưu token 
	$graph = 'https://graph.facebook.com/';
	$success = 0;
	if(isset($_POST['list'])){
		foreach(explode("\n", $_POST['list']) as $token){
			//Check info 
			$info = cURL($graph.'me?access_token='.trim($token), false, true);
			if(@$info->error) continue;
			$r = mysqli_query( $conn, 'SELECT * FROM '.$table.' WHERE idfb = "'.addslashes($info->id).'"');
			if(mysqli_num_rows($r) > 0) continue;
			mysqli_query( $conn, 'INSERT INTO '.$table.'(idfb,ten,token) VALUES("'.addslashes($info->id).'", "'.addslashes($info->name).'", "'.trim(addslashes($token)).'")');
			++$success;
		}
		echo '<script>alert("Add total: '.count(explode("\n", $_POST['list'])).'\nsuccess: '.$success.'")</script>';
	}
	//Đổi file .php
	function cURL($u, $pArray = false, $json = false){
		$s = curl_init();
		$options = array(
			CURLOPT_URL => $u,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_SSL_VERIFYPEER => false,
			CURLOPT_FOLLOWLOCATION => true
		);
		if($pArray){
			$options[CURLOPT_POST] = true;
			$options[CURLOPT_POSTFIELDS] = http_build_query($pArray);
		}
		curl_setopt_array($s, $options);
		$r = curl_exec($s);
		curl_close($s);
		if($json) return json_decode($r);
		return $r;
	}
?>
<!DOCTYPE html>
<html lang="vi-vn">
	<head>
		<meta charset="utf-8" />

		<title>Token Adder</title>
		<style>

		</style>
	</head>
	<body>
	    <center>
		<h3 style="
    color: #333;
    font-family: Arial;
" >Thêm Token</h3></center>
<center>
<tokendangco style="
    font-family: Arial;
">Số Token Đang Có:</tokendangco> <numbertoken style="
    color: #080dc5;
"><?php echo mysqli_num_rows(mysqli_query( $conn, "SELECT `id` FROM `token`")); ?></numbertoken></center>
<hr/>
<center>
		<form method="POST">
			<textarea class="form-control" name="list" cols="60" rows="15"></textarea>
			<input class="btn btn-primary" type="submit" value="&gt; Thêm Token &gt;&gt;" />
			<a href="del.php"><input class="btn btn-primary" type="submit" value="&gt; Xóa Token Die &gt;&gt;" /></a>
		</form></center>
		<footer>Code By Võ Hữu Nhân</footer>
	</body>
</html>
    </div> 
</body>
</html>