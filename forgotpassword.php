<!DOCTYPE html>
<html>

<title>Forgot Password</title>

<head>
	<link rel="stylesheet" type="text/css" href="css/style-login.css">
</head>

<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rahulestate";
$conn = mysqli_connect($servername, $username, $password, $dbname);

if(isset($_POST["forgot"]))
{
    $uname = $_POST["username"];
    $email = $_POST["email_id"];
    $usertype = $_POST["user_type"];

    $str_result = "ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
	$temp_password = substr(str_shuffle($str_result), 0, 7);

	$msg_password = "Dear User,<br><br>
    Your temporary password is <b>".$temp_password."</b>. Kindly use this password to reset your password.<br><br>
    Thank you..!!";

    require 'phpMailer/PHPMailerAutoload.php';
	
	$pass_mail = new PHPMailer;

	$pass_mail->IsSMTP();
	$pass_mail->Host = 'smtp.gmail.com';
	$pass_mail->Port = 587;
	$pass_mail->SMTPAuth = true;
	$pass_mail->Username = 'risktesting.demo@gmail.com';
	$pass_mail->Password = 'rahul1011!';
	$pass_mail->SMTPSecure = 'tls';

	$pass_mail->From = 'risktesting.demo@gmail.com';
	$pass_mail->FromName = 'R-Estate Admin';
	$pass_mail->AddAddress($email);

	$pass_mail->IsHTML(true);

	$pass_mail->Subject = 'Temporary Password';
	$pass_mail->Body = $msg_password;
	$pass_mail->AltBody = $msg_password;

    if ($usertype == 0)
	{
		$query = mysqli_query($conn, "SELECT * FROM tbl_adminlist WHERE username = '$uname' AND email_id = '$email'");
		$row = mysqli_fetch_array($query);

		if ($row["username"] == $uname && $row["email_id"] == $email)
		{
			$sql = mysqli_query($conn, "UPDATE tbl_adminlist SET tmp_password = '$temp_password' WHERE email_id = '$email'");
			$alert_msg = "Action Success. Temporary Password Sent In Email.";
    		$pass_mail->Send();
		}
		else
		{
			$alert_msg = "Action Failed. Message could not be sent. Mail Error: " . $pass_mail->ErrorInfo;
		}
	}
	if ($usertype == 1)
	{
		$query = mysqli_query($conn, "SELECT * FROM tbl_dealerlist WHERE username = '$uname' AND email_id = '$email'");
		$row = mysqli_fetch_array($query);

		if ($row["username"] == $uname && $row["email_id"] == $email)
		{
			$sql = mysqli_query($conn, "UPDATE tbl_dealerlist SET tmp_password = '$temp_password' WHERE email_id = '$email'");
			$alert_msg = "Action Success. Temporary Password Sent In Email.";
    		$pass_mail->Send();
		}
		else
		{
			$alert_msg = "Action Failed. Message could not be sent. Mail Error: " . $pass_mail->ErrorInfo;
		}
	}
	if ($usertype == 2)
	{
		$query = mysqli_query($conn, "SELECT * FROM tbl_customerlist WHERE username = '$uname' AND email_id = '$email'");
		$row = mysqli_fetch_array($query);
		
		if ($row["username"] == $uname && $row["email_id"] == $email)
		{
			$sql = mysqli_query($conn, "UPDATE tbl_customerlist SET tmp_password = '$temp_password' WHERE email_id = '$email'");
			$alert_msg = "Action Success. Temporary Password Sent In Email.";
    		$pass_mail->Send();
		}
		else
		{
			$alert_msg = "Action Failed. Message could not be sent. Mail Error: " . $pass_mail->ErrorInfo;
		}
	}
}

?>

<body>

<div class="container-login100">
	<div class="wrap-login100">

	<form class="login100-form" action="" method="post">
		<h1>FORGOT PASSWORD</h1>
		<br>
		<div>
			<input type="text" name="username" required="true" class="form-control" placeholder="Username">
		</div>
		<br>
		<div>
			<input type="email" name="email_id" required="true" class="form-control" placeholder="Email-ID">
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
			<p><input type="submit" name="forgot" value="SUBMIT" class="button"></p>
		</div>
		<br>
		<div>
			<?php if (!empty($alert_msg)){
				echo "<h3><font color='white'>".$alert_msg."</font></h3><br>";
			} ?>
		</div>
	</form>

    <p>
    	<h4>Already Have Temporary Password?<a href="resetpassword.php"><font color="white"> CLICK HERE </font></a></h4>
    	<br>
    	<h4><a href="index.php"><font color="white"> Go Back!! </font></a></h4>
    </p>
	
	</div>
</div>

</body>

</html>