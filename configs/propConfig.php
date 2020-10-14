<?php

define('servername','localhost');
define('username','root');
define('password' ,'');
define('dbname', 'rahulestate');

class Property_Conn
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
	
	function AdminPropertyList()
	{
		$query = "SELECT * FROM tbl_property_master pMaster
			JOIN tbl_property_details pDetail ON (pDetail.property_id = pMaster.property_id)
			JOIN tbl_dealerlist dList ON (dList.unique_id = pMaster.dealer_id)";

		$sql = mysqli_query($this->db_conn, $query);
		return $sql;
	}

	function DealerPropertyList($dealer)
	{
		$query = "SELECT * FROM tbl_property_master pMaster
			JOIN tbl_property_details pDetail ON (pDetail.property_id = pMaster.property_id)
			JOIN tbl_dealerlist dList ON (dList.unique_id = pMaster.dealer_id)
			WHERE dList.username = '$dealer' ";

		$sql = mysqli_query($this->db_conn, $query);
		return $sql;
	}

	function PropertyFind($prop_id)
	{
		$query = "SELECT * FROM tbl_property_master pMaster
			JOIN tbl_property_details pDetail ON (pDetail.property_id = pMaster.property_id)
			WHERE pMaster.property_id = '$prop_id' ";

		$sql = mysqli_query($this->db_conn, $query);
		return $sql;
	}

	function PropertyUpdate($prop_id, $prop_name, $prop_price, $image_file, $prop_details, $prop_address, $prop_city)
	{
		$m_Query = "UPDATE tbl_property_master SET prop_name='$prop_name', prop_price='$prop_price', prop_image='$image_file' WHERE property_id='$prop_id'";
		$m_sql = mysqli_query($this->db_conn, $m_Query);

		$d_Query = "UPDATE tbl_property_details SET prop_details='$prop_details', prop_address='$prop_address', prop_city='$prop_city' WHERE property_id='$prop_id'";
		$d_sql = mysqli_query($this->db_conn, $d_Query);
		return $d_sql;
	}

	function PropertySort($sql_query)
	{
		$sql = mysqli_query($this->db_conn, $sql_query);
		return $sql;
	}
}

?>