<?php
	include('configs/config.php');
	$property = new Database_Conn();
	session_start();

	if ($_SESSION["login_user"])
	{
?>

<!DOCTYPE html>
<html>

<title>Add Property</title>

<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/style-nav.css">

	<script>
		function onlyNos(e, t)
		{
			try 
			{
				if (window.event)
				{	var charCode = window.event.keyCode;	}
				else if (e)
				{	var charCode = e.which;	}
				else {	return true;	}
				if (charCode > 31 && (charCode < 46 || charCode > 57)) 
				{	return false;	}
				return true;
			}
			catch (err) 
			{	alert(err.Description);	}
		}
	</script>

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

<div style="margin-left:12%; padding:1px 16px;">

	<h2>Add Property</h2>
	<hr/>

	<form action="" method="post" enctype="multipart/form-data">
		<table align="center" width="80%" cellspacing="0">
			<tr>
				<th>Dealer ID</th>
				<td><?php echo $_SESSION["user_id"]; ?></td>
			</tr>
			<tr>
				<th>Property Name</th>
				<td><input type="text" name="prop_name" class="form-control" required></td>
			</tr>
			<tr>
				<th>Details</th>
				<td><input type="text" name="prop_details" class="form-control" required></td>
			</tr>
			<tr>
				<th>Address</th>
				<td><input type="text" name="prop_address" class="form-control" required></td>
			</tr>
			<tr>
				<th>City</th>
				<td><input type="text" name="prop_city" class="form-control" required></td>
			</tr>
			<tr>
				<th>Price</th>
				<td><input type="text" name="prop_price" class="form-control" required onkeypress="return onlyNos(event, this);"></td>
			</tr>
			<tr>
				<th>Type</th>
				<td>
					<select name="prop_type" required="true" class="form-control"> 
						<option value=""> Select Type </option>
						<option value="House"> House </option>
						<option value="Villa"> Villa </option>
						<option value="Residential"> Residential </option>
						<option value="Land"> Land </option>
						<option value="Studio"> Studio </option>
					</select>
				</td>
			</tr>
			<tr>
				<th>Availability</th>
				<td>
					<select name="prop_available" required="true" class="form-control"> 
						<option value=""> Select Type </option>
						<option value="Buy"> Buy </option>
						<option value="Rent"> Rent </option>
					</select>
				</td>
			</tr>
			<tr>
				<th>Image</th>
				<td><input type="file" name="prop_image" id="prop_image" class="form-control" placeholder="Upload Image" required></td>
			</tr>
			<tr>
				<td colspan="2"><input type="submit" name="save" value="Save" class="button"></td>
			</tr>
		</table>
	</form>

	<?php
	
	if(isset($_POST["save"]))
	{
		$str_result = "0123456789";
		$prop_id = "P-".substr(str_shuffle($str_result), 0, 5);

		$dealer_id = $_SESSION["user_id"];
		$prop_name = $_POST["prop_name"];
		$prop_details = $_POST["prop_details"];
		$prop_address = $_POST["prop_address"];
		$prop_city = $_POST["prop_city"];
		$prop_price = $_POST["prop_price"];
		$prop_type = $_POST["prop_type"];
		$prop_available = $_POST["prop_available"];

		$parent_dir = mkdir("property/".$dealer_id."/", 0777);
		$child_dir = mkdir("property/".$dealer_id."/".$prop_id."/", 0777);

        $tmpFilePath = $_FILES['prop_image']['tmp_name'];

        if ($tmpFilePath != "")
        {
            $image_file = "property/".$dealer_id."/".$prop_id."/". basename($_FILES["prop_image"]["name"]);
        }
        
		if (move_uploaded_file($tmpFilePath, $image_file))
        {
        	$pMaster = $property->AddPropertyMaster($prop_id, $dealer_id, $prop_name, $prop_price, $image_file);

			$pDetail = $property->AddPropertyDetail($prop_id, $prop_details, $prop_address, $prop_city, $prop_type, $prop_available);

			if ($pMaster && $pDetail)
			{
				echo "<h3><font color='black'>Property Details Save Successful..</font></h3>";
			}
			else
			{
				echo "<h3><font color='black'>Property Details Save Failed..</font></h3>";
			}
        }
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