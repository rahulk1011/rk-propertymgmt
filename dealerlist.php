<?php
	include('configs/config.php');
	$dealer = new Database_Conn();
	session_start();

	if ($_SESSION["login_user"])
	{
?>

<!DOCTYPE html>
<html>

<title>Dealers List</title>

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

	<h2>List of Dealers</h2>
	<hr/>

	<table align="center" width="80%" cellspacing="0">
		<tr>
			<th>Serial</th>
			<th>Dealer Name</th>
			<th>Username</th>
			<th>Email-ID</th>
			<th>Address</th>
		</tr>
		<?php
		$query = $dealer->DealerList();
		if (mysqli_num_rows($query) > 0)
		{
			$serial = 1;
			while($row = mysqli_fetch_array($query))
			{
			?>
			<tr>
				<td><?php echo $serial; ?></td>
				<td><?php echo $row["fullname"]; ?></td>
				<td><?php echo $row["username"]; ?></td>
				<td><?php echo $row["email_id"]; ?></td>
				<td><?php echo $row["address"]; ?></td>
			</tr>
			<?php
			$serial++;
			}
		}
		else
		{
		?>
			<tr>
				<td colspan="5">-- No Records Found --</td>
			</tr>
		<?php
		}
		?>
	</table>
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