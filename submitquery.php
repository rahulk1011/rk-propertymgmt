<?php
	include("configs/Config.php");
	$property = new Database_Conn();

	session_start();
	if ($_SESSION["login_user"])
	{
?>

<!DOCTYPE HTML>
<html>

<title>Mail Notification</title>

<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/style-nav.css">
</head>
<body>

<?php
include ("menu.php");
?>

<div style="margin-left:12%; padding:1px 16px;">
<br>

<?php
	$user_id = $_GET['user_id'];
	$prop_id = $_GET['prop_id'];

	$uQuery = $property->GetUserData($user_id);
	while ($row_u = mysqli_fetch_array($uQuery))
	{
		$Customer_ID = $row_u["unique_id"];
		$Customer_Name = $row_u["fullname"];
		$Customer_Email = $row_u["email_id"];
		$Customer_Address = $row_u["address"];
	}

	$pQuery = $property->GetPropertyData($prop_id);
	while($row_p = mysqli_fetch_array($pQuery))
	{
		$Dealer_ID = $row_p["unique_id"];
		$Dealer_Name = $row_p["fullname"];
		$Dealer_Email = $row_p["email_id"];
		$Dealer_Address = $row_p["address"];
		$Property_ID = $row_p["property_id"];
		$Property_Name = $row_p["prop_name"];
		$Property_Price = $row_p["prop_price"];
		$Property_Details = $row_p["prop_details"];
		$Property_Address = $row_p["prop_address"];
		$Property_City = $row_p["prop_city"];
		$Property_Type = $row_p["prop_type"];
		$Property_Available = $row_p["prop_available"];
	}
?>

<?php

	$msg_dealer = "
	<html><body>
	<b>To,</b><br>
	".$Dealer_Name."<br>
	".$Dealer_Email.",<br>
	".$Dealer_Address."<br>
	<br>
	This is to hereby inform you that <b>".$Customer_Name."</b> recently viewed one of your property, i.e <b>".$Property_Name."</b>, located in <b>".$Property_City."</b>.
	<br>
	The customer is interested to <b style='text-transform: lowercase'>".$Property_Available."</b> that.
	<br><br>
	<b>Property Details:</b><br>
	<b>Property ID :</b> ".$Property_ID."<br>
	<b>Property Name :</b> ".$Property_Name."<br>
	<b>Details :</b> ".$Property_Details."<br>
	<b>Price :</b> ".$Property_Price."<br>
	<b>Address :</b> ".$Property_Address."<br>
	<b>City :</b> ".$Property_City."<br>
	<b>Type :</b> ".$Property_Type."<br>
	<br>
	Please revert back to the customer. The corresponding email address is mentioned below.
	<br><br>
	<b>From,</b><br>
	".$Customer_Name."<br>
	".$Customer_Email."<br>
	".$Customer_Address."</body></html>";

	$msg_customer = "Your request for ".$Property_Name." has been notified to ".$Dealer_Name.". Thank you..!!";

?>

<?php

	require 'phpMailer/PHPMailerAutoload.php';
	
	$cust_mail = new PHPMailer;

	$cust_mail->IsSMTP();
	$cust_mail->Host = 'smtp.gmail.com';
	$cust_mail->Port = 587;
	$cust_mail->SMTPAuth = true;
	$cust_mail->Username = 'demo@gmail.com';
	$cust_mail->Password = 'password';
	$cust_mail->SMTPSecure = 'tls';

	$cust_mail->From = 'risktesting.demo@gmail.com';
	$cust_mail->FromName = 'R-Estate Admin';
	$cust_mail->AddAddress($Customer_Email, $Customer_Name);
	$cust_mail->AddAddress($Customer_Email);

	$cust_mail->IsHTML(true);

	$cust_mail->Subject = 'Property Interest';
	$cust_mail->Body    = $msg_customer;
	$cust_mail->AltBody = $msg_customer;

	if(!$cust_mail->Send())
	{
	   echo "<h2>Message could not be sent..</h2>";
	   echo "<h2>Mailer Error: " . $cust_mail->ErrorInfo . "</h2>";
	   exit;
	}
	else
	{
		echo "<h2>E-Mail Receipt Sent The User..!!</h2>";
	}

	$dealer_mail = new PHPMailer;

	$dealer_mail->IsSMTP();
	$dealer_mail->Host = 'smtp.gmail.com';
	$dealer_mail->Port = 587;
	$dealer_mail->SMTPAuth = true;
	$dealer_mail->Username = 'risktesting.demo@gmail.com';
	$dealer_mail->Password = 'rahul1011!';
	$dealer_mail->SMTPSecure = 'tls';

	$dealer_mail->From = 'risktesting.demo@gmail.com';
	$dealer_mail->FromName = 'R-Estate Admin';
	$dealer_mail->AddAddress($Dealer_Email, $Dealer_Name);
	$dealer_mail->AddAddress($Dealer_Email);

	$dealer_mail->IsHTML(true);

	$dealer_mail->Subject = 'Property Interest';
	$dealer_mail->Body    = $msg_dealer;
	$dealer_mail->AltBody = $msg_dealer;

	if(!$dealer_mail->Send())
	{
	   echo "<h2>Message could not be sent..</h2>";
	   echo "<h2>Mailer Error: " . $dealer_mail->ErrorInfo . "</h2>";
	   exit;
	}
	else
	{
		$logQuery = $property->RequestLog($Customer_ID, $Dealer_ID, $Property_ID);
		echo "<h2>Interest Notified To The Dealer. You Will Be Contacted Shortly..!!</h2>";
	}
?>

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
