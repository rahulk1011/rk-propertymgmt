<?php
	$utype = $_SESSION["user_type"];
?>

<ul>
	<li><a href="welcome.php">Home</a></li>
	<?php

	// Admin Menu Panel
	if ($utype == 0)
	{
		echo "<li><a href='adminlist.php'>Admin List</a></li>";
		echo "<li><a href='dealerlist.php'>Dealer List</a></li>";
		echo "<li><a href='customerlist.php'>Customer List</a></li>";
		echo "<li><a href='propertylist.php'>Property List</a></li>";
	}

	// Dealer Menu Panel
	if ($utype == 1)
	{
		echo "<li><a href='addproperty.php'>Add Property</a></li>";
		echo "<li><a href='propertylist.php'>Property List</a></li>";
	}

	// Customer Menu Panel
	if ($utype == 2)
	{
		echo "<li><a href='propertylist.php'>Property List</a></li>";
	}
	?>
	<li><a href="logout.php">Logout</a></li>
</ul>