<?php
	include('configs/propConfig.php');
	$property = new Property_Conn();

	session_start();

	if ($_SESSION["login_user"])
	{
?>

<!DOCTYPE html>
<html>

<title>Property List</title>

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
				if (charCode > 31 && (charCode < 48 || charCode > 57)) 
				{	return false;	}
				return true;
			}
			catch (err) 
			{	alert(err.Description);	}
		}
	</script>

	<style type="text/css">
        b {
        	color: black;
        	font-size: medium;
        	text-transform: uppercase;
        }
        img {
        	border: solid 2px black;
        }
        .no-result {
        	background-color: lavender;
        	padding: 5px;
        }
        .top-bar {
        	position: fixed;
        	margin-left: -16px;
			top: 0;
			width: 88%;
			overflow: hidden;
			background: linear-gradient(to right, #003366 0%, #0099cc 100%);
			border-bottom: 4px solid black;
        }
		table {
			align-self: center;
			background-color: white;
			border-radius: 5px;
		}
		tr {
			color: white;
			text-align: left;
			padding: 2px;
			height: 30px;
		}
		td {
			color: black;
			padding: 2px 2px 2px 10px;
			height: 30px;
			border: none;
		}
		.notify {
			margin-left: 2.5%;
			width: 95%;			
		}
		.notify td {
			text-align: center;
			background: linear-gradient(to right, #cc6600 0%, #eee8aa 50%, #cc6600 100%);
		}
	</style>
</head>

<body>

<?php
include ("menu.php");
?>

<?php

function TableOutput($serial, $fullname, $p_name, $p_details, $p_address, $p_city, $p_type, $p_available, $p_price, $p_image)
{
	$tbl_output = "<table width='95%' align='center'>
		<tr>
			<td rowspan='4' width='15px' align='center'><b>".$serial.".</b></td>
			<td width='400px'><b>Dealer Name: </b>".$fullname."</td>
			<td width='250px'><b>City: </b>".$p_city."</td>
			<td rowspan='4' width='150px' align='center'><img border='1' height='100px' width='100px' src='".$p_image."' /></td>
		</tr>
		<tr>
			<td><b>Property Name: </b>".$p_name."</td>
			<td><b>Type: </b>".$p_type."</td>
		</tr>
		<tr>
			<td><b>Details: </b>".$p_details."</td>
			<td><b>Availability: </b>".$p_available."</td>
		</tr>
		<tr>
			<td><b>Address: </b>".$p_address."</td>
			<td><b>Price: ".$p_price."</b></td>
		</tr>
	</table>";
	return $tbl_output;
}
?>

<div style="margin-left:12%; padding:1px 16px;">
	<div class="top-bar">
		<h2><font color="white">List of Properties</font></h2>
		<form method="post" action="">
			<table cellspacing="0" border="1" width="95%" align="center">
			<tr>
				<th>Filter By:</th>
				<th>
					<select name="type"> 
						<option value=""> Type </option>
						<option value="House"> House </option>
						<option value="Villa"> Villa </option>
						<option value="Residential"> Residential </option>
						<option value="Land"> Land </option>
						<option value="Studio"> Studio </option>
					</select>
				</th>
				<th width="150px">
					<select name="available"> 
						<option value=""> Available For </option>
						<option value="Buy"> Buy </option>
						<option value="Rent"> Rent </option>
					</select>
				</th>
				<th>
					Price Range: <input type="text" name="fPrice" placeholder="From-Price" onkeypress="return onlyNos(event, this);"> < <input type="text" name="tPrice" placeholder="To-Price" onkeypress="return onlyNos(event, this);">
				</th>
				<th><input type="text" name="city" placeholder="Location"></th>
				<th><input type="submit" name="sort" value="Show Results" class="button-anchor"></th>
			</tr>
			</table>
		</form>
		<br>
	</div>

	<div style="padding-top: 150px;">
	<?php

	// Dealer Property List..
	if ($utype == 1)
	{
		$dealer = $_SESSION["login_user"];
		$dealer_id = $_SESSION["unique_id"];

		if(isset($_POST["sort"]))
		{
			$type = $_POST["type"];
			$available = $_POST["available"];
			$fPrice = $_POST["fPrice"];
			$tPrice = $_POST["tPrice"];
			$city = $_POST["city"];

			$whereClause = array();

			if (!empty($_POST['type'])) 
				$whereClause[] = "pDetail.prop_type ='".$_POST['type']."'"; 
			$where = '';

			if (!empty($_POST['available'])) 
				$whereClause[] ="pDetail.prop_available ='".$_POST['available']."'"; 
			$where = '';

			if (!empty($_POST['city'])) 
				$whereClause[] ="pDetail.prop_city ='".$_POST['city']."'"; 
			$where = '';

			if (!empty($_POST['fPrice']) && !empty($_POST['tPrice'])) 
				$whereClause[] ="pMaster.prop_price >='".$_POST['fPrice']."' AND pMaster.prop_price <= '".$_POST['tPrice']."'"; 
			$where = '';

			$whereClause[] = "pMaster.dealer_id = '".$dealer_id."'";

			if (count($whereClause) > 0)
			{ 
				$where = ' WHERE '.implode(' AND ', $whereClause); 
			}

			$sql_query = "SELECT * FROM tbl_property_master pMaster
				JOIN tbl_property_details pDetail ON (pDetail.property_id = pMaster.property_id)
				JOIN tbl_dealerlist dList ON (dList.unique_id = pMaster.dealer_id)".$where;

			if ($fPrice > $tPrice)
			{
				echo "<script language='javascript'>alert('From-Price must be lower than To-Price..!!')</script>";
				header('Refresh:0; URL=propertylist.php');
			}
			else
			{
				$query = $property->PropertySort($sql_query);
				if (mysqli_num_rows($query) > 0)
				{
					$serial = 1;
					while($row = mysqli_fetch_array($query))
					{
						$prop_id = $row["property_id"];
						$fullname = $row["fullname"];					
						$p_name = $row["prop_name"];
						$p_details = $row["prop_details"];
						$p_address = $row["prop_address"];
						$p_city = $row["prop_city"];
						$p_type = $row["prop_type"];					
						$p_available = $row["prop_available"];					
						$p_price = $row["prop_price"];
						$p_image = $row["prop_image"];

						$tbl_result = TableOutput($serial, $fullname, $p_name, $p_details, $p_address, $p_city, $p_type, $p_available, $p_price, $p_image);
						echo $tbl_result;
						echo "<table class='notify'><tr><td><a href='editproperty.php?prop_id=".$prop_id."'><font color='black'>EDIT</font></a></td></tr></table>";
						$serial++;
						echo "<br>";
					}
				}
				else
				{
					echo "<div class='no-result'><h3><font color='black'>No Results Found..</font></h3></div>";
				}
			}
		}
		else
		{
			$query = $property->DealerPropertyList($dealer);
			if (mysqli_num_rows($query) > 0)
			{
				$serial = 1;
				while($row = mysqli_fetch_array($query))
				{
					$prop_id = $row["property_id"];
					$fullname = $row["fullname"];					
					$p_name = $row["prop_name"];
					$p_details = $row["prop_details"];
					$p_address = $row["prop_address"];
					$p_city = $row["prop_city"];
					$p_type = $row["prop_type"];					
					$p_available = $row["prop_available"];					
					$p_price = $row["prop_price"];
					$p_image = $row["prop_image"];

					$tbl_result = TableOutput($serial, $fullname, $p_name, $p_details, $p_address, $p_city, $p_type, $p_available, $p_price, $p_image);
					echo $tbl_result;
					echo "<table class='notify'><tr><td><a href='editproperty.php?prop_id=".$prop_id."'><font color='black'>EDIT</font></a></td></tr></table>";
					$serial++;
					echo "<br>";
				}
			}
			else
			{
				echo "<div class='no-result'><h3><font color='black'>No Results Found..</font></h3></div>";
			}
		}
	}
	// Admin & Customer Property List..
	else
	{
		if(isset($_POST["sort"]))
		{
			$type = $_POST["type"];
			$available = $_POST["available"];
			$fPrice = $_POST["fPrice"];
			$tPrice = $_POST["tPrice"];
			$city = $_POST["city"];

			$whereClause = array();

			if (!empty($_POST['type'])) 
				$whereClause[] = "pDetail.prop_type ='".$_POST['type']."'"; 
			$where = '';

			if (!empty($_POST['available'])) 
				$whereClause[] ="pDetail.prop_available ='".$_POST['available']."'"; 
			$where = '';

			if (!empty($_POST['city'])) 
				$whereClause[] ="pDetail.prop_city ='".$_POST['city']."'"; 
			$where = '';

			if (!empty($_POST['fPrice']) && !empty($_POST['tPrice'])) 
				$whereClause[] ="pMaster.prop_price >='".$_POST['fPrice']."' AND pMaster.prop_price <= '".$_POST['tPrice']."'"; 
			$where = '';

			if (count($whereClause) > 0)
			{ 
				$where = ' WHERE '.implode(' AND ', $whereClause); 
			}

			$sql_query = "SELECT * FROM tbl_property_master pMaster
				JOIN tbl_property_details pDetail ON (pDetail.property_id = pMaster.property_id)
				JOIN tbl_dealerlist dList ON (dList.unique_id = pMaster.dealer_id)".$where;

			if ($fPrice > $tPrice)
			{
				echo "<script language='javascript'>alert('From-Price must be lower than To-Price..!!')</script>";
				header('Refresh:0; URL=propertylist.php');
			}
			else
			{
				$query = $property->PropertySort($sql_query);
				if (mysqli_num_rows($query) > 0)
				{
					$serial = 1;
					while($row = mysqli_fetch_array($query))
					{
						$fullname = $row["fullname"];					
						$p_name = $row["prop_name"];
						$p_details = $row["prop_details"];
						$p_address = $row["prop_address"];
						$p_city = $row["prop_city"];
						$p_type = $row["prop_type"];					
						$p_available = $row["prop_available"];					
						$p_price = $row["prop_price"];
						$p_image = $row["prop_image"];

						$tbl_result = TableOutput($serial, $fullname, $p_name, $p_details, $p_address, $p_city, $p_type, $p_available, $p_price, $p_image);
						echo $tbl_result;
						$serial++;

						if ($utype == 2)
						{
							$prop_id = $row['property_id'];
							$user_id = $_SESSION["login_user"];
							echo "<table class='notify'><tr><td><a href='submitquery.php?prop_id=".$prop_id."&user_id=".$user_id."'><font color='black'>NOTIFY DEALER</font></a></td></tr></table>";
						}
						echo "<br>";
					}
				}
				else
				{
					echo "<div class='no-result'><h3><font color='black'>No Results Found..</font></h3></div>";
				}
			}
		}
		else
		{
			$query = $property->AdminPropertyList();
			if (mysqli_num_rows($query) > 0)
			{
				$serial = 1;
				while($row = mysqli_fetch_array($query))
				{
					$fullname = $row["fullname"];					
					$p_name = $row["prop_name"];
					$p_details = $row["prop_details"];
					$p_address = $row["prop_address"];
					$p_city = $row["prop_city"];
					$p_type = $row["prop_type"];					
					$p_available = $row["prop_available"];					
					$p_price = $row["prop_price"];
					$p_image = $row["prop_image"];

					$tbl_result = TableOutput($serial, $fullname, $p_name, $p_details, $p_address, $p_city, $p_type, $p_available, $p_price, $p_image);
					echo $tbl_result;
					$serial++;

					if ($utype == 2)
					{
						$prop_id = $row['property_id'];
						$user_id = $_SESSION["login_user"];
						echo "<table class='notify'><tr><td><a href='submitquery.php?prop_id=".$prop_id."&user_id=".$user_id."'><font color='black'>NOTIFY DEALER</font></a></td></tr></table>";
					}
					echo "<br>";
				}
			}
			else
			{
				echo "<div class='no-result'><h3><font color='black'>No Results Found..</font></h3></div>";
			}
		}
	}

	?>
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