<!DOCTYPE html>
<html>

<title>Registration</title>

<head>
	<link rel="stylesheet" type="text/css" href="css/style-login.css">
</head>

<?php

include('configs/config.php');
$registration = new Database_Conn();

if(isset($_POST["register"]))
{	
	$fullname = $_POST["fullname"];
	$uname = $_POST["username"];
    $pass = $_POST["password"];
    $email = $_POST["email_id"];
    $address = $_POST["address"];
    $usertype = $_POST["user_type"];

    $result = $registration->RegisterUser($fullname, $uname, $pass, $email, $address, $usertype);

    if ($result)
    {
    	$alert_msg = "<h3><font color='black'>Registration Successful..</font></h3><br>";
    }
    else
    {
    	$alert_msg = "<h3><font color='black'>Registration Failed..</font></h3><br>";
    }
}

?>

<body>

<div class="container-login100">
	<div class="wrap-login100">

	<form class="login100-form" action="" method="post" enctype="multipart/form-data">
		<h1>REGISTRATION PAGE</h1>
		<br>
		<div>
			<input type="text" name="fullname" required="true" class="form-control" placeholder="Full Name">
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
		<div>
			<input type="email" name="email_id" required="true" class="form-control" placeholder="Email-ID">
		</div>
		<br>
		<div>
			<input type="text" name="address" required="true" class="form-control" placeholder="Address">
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
			<p><input type="submit" name="register" value="REGISTER" class="button"></p>
		</div>
		<br>
		<div>
			<?php if (!empty($alert_msg)){
				echo $alert_msg;
			} ?>
		</div>
	</form>

	<h4><a href="index.php"><font color="white"> Go Back!! </font></a></h4>
	
	</div>
</div>

</body>

</html>