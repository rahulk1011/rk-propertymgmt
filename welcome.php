<?php
	include('configs/config.php');
	$welcome = new Database_Conn();
	session_start();

	// validation
	$user_check = $_SESSION["login_user"];
	$utype = $_SESSION["user_type"];

	$validate = $welcome->CheckUser($utype, $user_check);
	$row = mysqli_fetch_array($validate, MYSQLI_ASSOC);

	if ($_SESSION["login_user"])
	{
?>

<!DOCTYPE html>
<html>

<title>Welcome</title>

<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/style-nav.css">
	
	<style type="text/css">
        b {
        	color: lavender;
        	font-size: larger;
        	text-transform: uppercase;
        }
        .container .box {
            width: 100%;
            display: table;
            color: lavender;
        }
	</style>
</head>

<body>

<?php
include ("menu.php");
?>

<div style="margin-left:12%;padding:1px 16px;">

	<h2>Welcome <?php echo $row["fullname"]; ?>..</h2>
	<hr/>
	<br>

	<div class="container" style="padding: 20px;">		
		<div class="box"><b>Username :</b> <?php echo $row["username"]; ?></div>
		<br>
		<div class="box"><b>Unique-ID :</b> <?php echo $row["unique_id"]; $_SESSION["user_id"] = $row["unique_id"]; ?></div>
		<br>
		<div class="box"><b>Address :</b> <?php echo $row["address"]; ?></div>
		<br>
		<div class="box"><b>Email-ID :</b> <?php echo $row["email_id"]; ?></div>
		<br>
		<div class="box">
			<b>Usertype :</b>
			<?php
			switch ($_SESSION["user_type"])
			{
				case 0: echo "Admin"; break;
				case 1: echo "Dealer"; break;
				case 2: echo "Customer"; break;
			}
			?>
		</div>
	</div>

</div>

<?php
	}
	else 
	{
    	header("Location:index.php");
	}	
?>

</body>

</html>