<?php
	include('configs/config.php');
	$index = new Database_Conn();
	session_start();
?>

<!DOCTYPE html>
<html>

<title>Login</title>

<head>
	<link rel="stylesheet" type="text/css" href="css/style-login.css">
</head>

<?php

if(isset($_POST["login"]))
{
	$uname = $_POST["username"];
	$pass = $_POST["password"];
	$utype = $_POST["usertype"];

	$result = $index->LoginUser($uname, $pass, $utype);
	$row = mysqli_fetch_array($result);

	if($row["username"] == $uname && $row["password"] == $pass)
	{
		$_SESSION["login_user"] = $uname;
		$_SESSION["user_type"] = $utype;
		$_SESSION["unique_id"] = $row["unique_id"];

		header("location: welcome.php");
	}
	else
	{
		$alert_msg = "<h3><font color='black'>Invalid Username / Password..</font></h3>";
	}
}

?>

<body>

<div class="container-login100">
	<div class="wrap-login100">
	<form class="login100-form" action="" method="post">
		<h1>RAHUL-ESTATE</h1>
		<h3>Property Management System</h3>
		<br>
		<div>
			<img src="css/images/logo.jpg" class="login100-form-logo">
		</div>
		<br>
		<div>
			<input type="text" name="username" required="true" class="form-control" placeholder="Username">
		</div>
		<br>
		<div>
			<input type="password" name="password" required="true" class="form-control" placeholder="Password">
		</div>
		<br>
		<div class="form-control">
			<input type="radio" name="usertype" value="0" required="true"> <b>Admin</b>
			&nbsp;
			<input type="radio" name="usertype" value="1" required="true"> <b>Dealer</b>
			&nbsp;
			<input type="radio" name="usertype" value="2" required="true"> <b>Customer</b>
		</div>
		<div>
			<p><input type="submit" name="login" value="LOGIN" class="button"></p>
		</div>
		<br>
		<div>
			<?php if (!empty($alert_msg)){
				echo $alert_msg;
			} ?>
		</div>
	</form>
	<br>

	<h4 style="color: black;"><a href="register.php"> New User! Register </a>&nbsp;|&nbsp;<a href="forgotpassword.php"> Forgot Password! </a></h4>
	
	</div>
</div>

</body>

</html>