<?php

define('servername','localhost');
define('username','root');
define('password' ,'');
define('dbname', 'rahulestate');

class Database_Conn
{
	function __construct()
	{
		$conn = mysqli_connect(servername, username, password, dbname);
		$this->db_conn = $conn;

		// Check connection
		if (mysqli_connect_errno())
		{
			echo "Failed to connect to MySQL: " . mysqli_connect_error();
		}
	}

	function LoginUser($uname, $pass, $utype)
	{
		if ($utype == 0)
		{
			$sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_adminlist WHERE username = '$uname' AND password = '$pass'");
			return $sql;
		}
		elseif ($utype == 1)
		{
			$sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_dealerlist WHERE username = '$uname' AND password = '$pass'");
			return $sql;
		}
		elseif ($utype == 2)
		{
			$sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_customerlist WHERE username = '$uname' AND password = '$pass'");
			return $sql;
		}
	}

	function CheckUser($utype, $user_check)
	{
		if ($utype == 0)
		{
			$ses_sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_adminlist WHERE username = '$user_check' ");
			return $ses_sql;
		}
		elseif ($utype == 1)
		{
			$ses_sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_dealerlist WHERE username = '$user_check' ");
			return $ses_sql;
		}
		elseif ($utype == 2)
		{
			$ses_sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_customerlist WHERE username = '$user_check' ");
			return $ses_sql;
		}
	}

	function RegisterUser($fullname, $uname, $pass, $email, $address, $usertype)
	{
		if ($usertype == 0)
		{
			date_default_timezone_set("Asia/Calcutta");
			$unique_id = strval("A-".date('dm-Hi', time()));

			$check = mysqli_query($this->db_conn, "SELECT * FROM tbl_adminlist WHERE username='$uname'");
		    $checkrows = mysqli_num_rows($check);

		    if($checkrows > 0)
		    {
				header('Refresh:0; URL=register.php');
		    }
		    else
		    {
		    	$sql = mysqli_query($this->db_conn, "INSERT INTO tbl_adminlist (unique_id, fullname, username, password, email_id, address) VALUES ('$unique_id', '$fullname', '$uname', '$pass', '$email', '$address')");
		    	return $sql;
		    }
		}
		elseif ($usertype == 1)
		{
			date_default_timezone_set("Asia/Calcutta");
			$dealer_id = strval("D-".date('dm-Hi', time()));

			$check = mysqli_query($this->db_conn, "SELECT * FROM tbl_dealerlist WHERE username='$uname'");
		    $checkrows = mysqli_num_rows($check);

		    if($checkrows > 0)
		    {
				header('Refresh:0; URL=register.php');
		    }
		    else
		    {
				$sql = mysqli_query($this->db_conn, "INSERT INTO tbl_dealerlist (unique_id, fullname, username, password, email_id, address) VALUES ('$dealer_id', '$fullname', '$uname', '$pass', '$email', '$address')");
				return $sql;
		    }
		}
		elseif ($usertype == 2)
		{
			date_default_timezone_set("Asia/Calcutta");
			$customer_id = strval("C-".date('dm-Hi', time()));

			$check = mysqli_query($this->db_conn, "SELECT * FROM tbl_customerlist WHERE username='$uname'");
		    $checkrows = mysqli_num_rows($check);

		    if($checkrows > 0)
		    {
				header('Refresh:0; URL=register.php');
		    }
		    else
		    {
				$sql = mysqli_query($this->db_conn, "INSERT INTO tbl_customerlist (unique_id, fullname, username, password, email_id, address) VALUES ('$customer_id', '$fullname', '$uname', '$pass', '$email', '$address')");
				return $sql;
		    }
		}
	}

	function AdminList()
	{
		$sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_adminlist");
		return $sql;
	}

	function DealerList()
	{
		$sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_dealerlist");
		return $sql;
	}

	function CustomerList()
	{
		$sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_customerlist");
		return $sql;
	}

	function AddPropertyMaster($prop_id, $dealer_id, $prop_name, $prop_price, $image_file)
	{
		$prop_Mquery = mysqli_query($this->db_conn, "INSERT INTO tbl_property_master (property_id, dealer_id, prop_name, prop_price, prop_image) VALUES ('".$prop_id."', '".$dealer_id."', '".$prop_name."', '".$prop_price."', '".$image_file."')");
		return $prop_Mquery;		
	}

	function AddPropertyDetail($prop_id, $prop_details, $prop_address, $prop_city, $prop_type, $prop_available)
	{
		$prop_Dquery = mysqli_query($this->db_conn, "INSERT INTO tbl_property_details (property_id, prop_details, prop_address, prop_city, prop_type, prop_available) VALUES ('".$prop_id."', '".$prop_details."', '".$prop_address."', '".$prop_city."', '".$prop_type."', '".$prop_available."')");
		return $prop_Dquery;
	}

	function GetUserData($user_id)
	{
		$sql = mysqli_query($this->db_conn, "SELECT * FROM tbl_customerlist WHERE username = '$user_id'");
		return $sql;
	}

	function GetPropertyData($prop_id)
	{
		$prop_query = "SELECT * FROM tbl_property_master pMaster
			JOIN tbl_property_details pDetail ON (pDetail.property_id = pMaster.property_id)
			JOIN tbl_dealerlist dList ON (dList.unique_id = pMaster.dealer_id)
			WHERE pMaster.property_id = '$prop_id'";
		$sql = mysqli_query($this->db_conn, $prop_query);
		return $sql;
	}

	function RequestLog($Customer_ID, $Dealer_ID, $Property_ID)
	{
		date_default_timezone_set("Asia/Calcutta");
		$log_date = date('Y-m-d H:i:s');

		$sql = mysqli_query($this->db_conn, "INSERT INTO tbl_request_log (customer_id, dealer_id, property_id, request_date) VALUES ('".$Customer_ID."', '".$Dealer_ID."', '".$Property_ID."', '".$log_date."')");
		return $sql;
	}
}

?>