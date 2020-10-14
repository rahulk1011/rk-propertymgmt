<!DOCTYPE html>
<html>

<title>Property Edit</title>

<head>
	<link rel="stylesheet" type="text/css" href="css/style.css">
	<link rel="stylesheet" type="text/css" href="css/style-nav.css">
	
	<style>
		p {
			text-align: center;
		}
	</style>
</head>

<body>
<h3>Edit Property Info</h3>

<div class="box">

<form action="" method="post" enctype="multipart/form-data">
	
<table align="center" width="80%">
<?php

include ("configs/propConfig.php");
$property = new Property_Conn();

$prop_id = $_GET["prop_id"];

$query = $property->PropertyFind($prop_id);

while($row = mysqli_fetch_array($query))
{
?>
	<tr>
		<th>Dealer ID</th>
		<td><input type="text" name="dealer_id" value="<?php echo htmlentities($row['dealer_id']) ?>" class="form-control" readonly></td>
	</tr>
	<tr>
		<th>Property Name</th>
		<td><input type="text" name="prop_name" value="<?php echo htmlentities($row['prop_name']) ?>" class="form-control" required></td>
	</tr>
	<tr>
		<th>Property Details</th>
		<td><input type="text" name="prop_details" value="<?php echo htmlentities($row['prop_details']) ?>" class="form-control" required></td>
	</tr>
	<tr>
		<th>Property Address</th>
		<td><input type="text" name="prop_address" value="<?php echo htmlentities($row['prop_address']) ?>" class="form-control" required></td>
	</tr>
	<tr>
		<th>Property City</th>
		<td><input type="text" name="prop_city" value="<?php echo htmlentities($row['prop_city']) ?>" class="form-control" required></td>
	</tr>
	<tr>
		<th>Property Price</th>
		<td><input type="text" name="prop_price" value="<?php echo htmlentities($row['prop_price']) ?>" class="form-control" required></td>
	</tr>
	<tr>
		<th>Property Image</th>
		<td>
			<?php
				$p_image = $row["prop_image"]; echo "<img height='100px' width='100px' src='".$p_image."' />";
			?>
			&nbsp;&nbsp;&nbsp;
			<input type="file" name="prop_image" id="prop_image">
		</td>
	</tr>
	<tr>
		<td colspan="2"><input type="submit" name="update" value="UPDATE" class="button"></td>
	</tr>
<?php
}
?>
</table>

</form>

<?php
if(isset($_POST['update']))
{
	$prop_id = $_GET["prop_id"];
	$dealer_id = $_POST["dealer_id"];

	$prop_name = $_POST["prop_name"];
	$prop_details = $_POST["prop_details"];
	$prop_address = $_POST["prop_address"];
	$prop_city = $_POST["prop_city"];
	$prop_price = $_POST["prop_price"];

	$prop_image = $_FILES['prop_image']['tmp_name'];
    if ($prop_image == "")
	{
		$image_file = $p_image;
	}
	else
	{
		$image_file = "property/".$dealer_id."/".$prop_id."/". basename($_FILES["prop_image"]["name"]);
		move_uploaded_file($prop_image, $image_file);
	}

    $u_query = $property->PropertyUpdate($prop_id, $prop_name, $prop_price, $image_file, $prop_details, $prop_address, $prop_city);
    //$d_query = $property->PropertyUpdate($prop_id, $prop_details, $prop_address, $prop_city);

    if ($u_query)
    {
    	echo "<h3><font color='white'>Property Update Successful..</font></h3>";
    	header('Refresh:3; URL=propertylist.php');
    }
    else
    {
    	echo "<h3><font color='white'>Property Update Failed..</font></h3>";
    }
}
?>

<p><a href="propertylist.php">
    <button style="border-radius: 5px; background-color: black; height: 35px; width: 130px; cursor: pointer;">
        <font color="gainsboro">GO BACK</font>
    </button>
</a></p>

</div>

</body>
</html>