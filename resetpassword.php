<!DOCTYPE html>
<html>

<title>Reset Password</title>

<head>
	<link rel="stylesheet" type="text/css" href="css/style-login.css">
</head>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rahulestate";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if(isset($_POST["reset"]))
{
	$uname = $_POST["username"];
    $temp_password = $_POST["temp_password"];
    $new_password = $_POST["new_password"];
    $c_password = $_POST["c_password"];
    $usertype = $_POST["user_type"];

    if ($new_password != $c_password)
    {
    	$alert_msg = "New Password & Confirm Password should be same..";
    }
    else
    {
    	if ($usertype == 0)
    	{
    		$query = mysqli_query($conn, "SELECT * FROM tbl_adminlist WHERE username = '$uname' AND tmp_password = '$temp_password'");
			$row = mysqli_fetch_array($query);

			if ($row["username"] == $uname && $row["tmp_password"] == $temp_password)
			{
				$sql = mysqli_query($conn, "UPDATE tbl_adminlist SET password = '$new_password', tmp_password = '' WHERE username = '$uname' AND tmp_password = '$temp_password'");
				$alert_msg = "Password Reset Successful..";
			}
			else
			{
				$alert_msg = "Password Reset Failed..";
			}
    	}
    	if ($usertype == 1)
    	{
    		$query = mysqli_query($conn, "SELECT * FROM tbl_dealerlist WHERE username = '$uname' AND tmp_password = '$temp_password'");
			$row = mysqli_fetch_array($query);

			if ($row["username"] == $uname && $row["tmp_password"] == $temp_password)
			{
				$sql = mysqli_query($conn, "UPDATE tbl_dealerlist SET password = '$new_password', tmp_password = '' WHERE username = '$uname' AND tmp_password = '$temp_password'");
				$alert_msg = "Password Reset Successful..";
			}
			else
			{
				$alert_msg = "Password Reset Failed..";
			}
    	}
    	if ($usertype == 2)
    	{
    		$query = mysqli_query($conn, "SELECT * FROM tbl_customerlist WHERE username = '$uname' AND tmp_password = '$temp_password'");
			$row = mysqli_fetch_array($query);

			if ($row["username"] == $uname && $row["tmp_password"] == $temp_password)
			{
				$sql = mysqli_query($conn, "UPDATE tbl_customerlist SET password = '$new_password', tmp_password = '' WHERE username = '$uname' AND tmp_password = '$temp_password'");
				$alert_msg = "Password Reset Successful..";
			}
			else
			{
				$alert_msg = "Password Reset Failed..";
			}
    	}
    }
}

?>

<body>

<div class="container-login100">
	<div class="wrap-login100">

	<form class="login100-form" action="" method="post">
		<h1>RESET PASSWORD</h1>
		<br>
		<div>
			<input type="text" name="username" required="true" class="form-control" placeholder="Username">
		</div>
		<br>
		<div>
			<input type="text" name="temp_password" required="true" class="form-control" placeholder="Temporary Password">
		</div>
		<br>
		<div>
			<input type="password" name="new_password" required="true" class="form-control" placeholder="New Password">
		</div>
		<br>
		<div>
			<input type="password" name="c_password" required="true" class="form-control" placeholder="Confirm Password">
		</div>
		<br>
		<div>
			<select name="user_type" required="true" class="form-control"> 
				<option value=""> Select User Type </option>
				<option value="0"> Admin </option>
				<option value="1"> Dealer </option>
				<option value="2"> Customer </option>
			</select>
		</div>
		<br>
		<div>
			<p><input type="submit" name="reset" value="RESET" class="button"></p>
		</div>
		<br>
		<div>
			<?php if (!empty($alert_msg)){
				echo "<h3><font color='white'>".$alert_msg."</font></h3><br>";
			} ?>
		</div>
	</form>

	<h4><a href="index.php"><font color="white"> Go Back!! </font></a></h4>
	
	</div>
</div>

</body>

</html>