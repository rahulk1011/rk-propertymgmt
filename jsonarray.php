<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "rahulestate";
$conn = mysqli_connect($servername, $username, $password, $dbname);

$i = 1;
$sql = mysqli_query($conn, "SELECT * FROM tbl_adminlist");
while ($row = mysqli_fetch_assoc($sql))
{
	$array["estate"]["admin"][$i]["ID"] = $row["id"];
	$array["estate"]["admin"][$i]["name"] = $row["fullname"];
	$array["estate"]["admin"][$i]["username"] = $row["username"];
	$array["estate"]["admin"][$i]["email"] = $row["email_id"];
	$i++;
}

$i = 1;
$query = mysqli_query($conn, "SELECT * FROM tbl_dealerlist");
while ($row = mysqli_fetch_assoc($query))
{
	$array["estate"]["employee"][$i]["ID"] = $row["id"];
	$array["estate"]["employee"][$i]["name"] = $row["fullname"];
	$array["estate"]["employee"][$i]["username"] = $row["username"];
	$array["estate"]["employee"][$i]["email"] = $row["email_id"];
	$i++;
}

$i = 1;
$query = mysqli_query($conn, "SELECT * FROM tbl_customerlist");
while ($row = mysqli_fetch_assoc($query))
{
	$array["estate"]["customer"][$i]["ID"] = $row["id"];
	$array["estate"]["customer"][$i]["name"] = $row["fullname"];
	$array["estate"]["customer"][$i]["username"] = $row["username"];
	$array["estate"]["customer"][$i]["email"] = $row["email_id"];
	$i++;
}

$i = 1;
$sql = mysqli_query($conn, "SELECT * FROM tbl_property_master");
while ($row = mysqli_fetch_array($sql))
{
	$array["estate"]["property"][$i]["ID"] = $row["id"];
	$array["estate"]["property"][$i]["PID"] = $row["property_id"];
	$array["estate"]["property"][$i]["Name"] = $row["prop_name"];
	$array["estate"]["property"][$i]["Price"] = $row["prop_price"];
	$i++;
}

$i = 1;
$sql = mysqli_query($conn, "SELECT * FROM tbl_property_details");
while ($row = mysqli_fetch_array($sql))
{
	$array["estate"]["details"][$i]["ID"] = $row["id"];
	$array["estate"]["details"][$i]["PID"] = $row["property_id"];
	$array["estate"]["details"][$i]["City"] = $row["prop_city"];
	$array["estate"]["details"][$i]["Type"] = $row["prop_type"];
	$i++;
}

echo json_encode($array, JSON_PRETTY_PRINT)."<br>";

?>