<?php
class catoperation
{
	function connect_init()
	{
		$con = mysqli_connect("localhost", "root", "", "rahul_demo");
		return $con;
	}

	function categoryTreerec($parent_id = 0, $sub_mark = '')
	{
		$con = $this->connect_init();
		$list_sql = "SELECT * FROM tbl_categories WHERE parent_id = $parent_id ORDER BY catname ASC";
	    $query = mysqli_query($con, $list_sql);
	    
		while($row = mysqli_fetch_array($query, MYSQLI_ASSOC))
		{
			echo  '<option value="'.$row['id'].'">'.$sub_mark.$row['catname'].'</option>';
			$this->categoryTreerec($row['id'], $sub_mark.'_');
		}
		return $str;
	}
	
	function addCategory($arr)
	{
		unset($arr['submit']);
		$insert_fields = '';
		foreach($arr as $key => $val)
		{
			$insert_fields.= $key."='".trim($val)."',";			
		}
		$insert_fields = rtrim($insert_fields, ',');
		$insert_sql = "INSERT INTO tbl_categories SET ".$insert_fields;
		$con = $this->connect_init();
		mysqli_query($con, $insert_sql);
		header("location:categories.php");
		exit;
	}
}

$obj = new catoperation;

if(!empty($_POST))
{
	$obj->addCategory($_POST);	
}

?>

<div align="center">
	<form action="" method="post">
		<select name="parent_id">
			<option value="0">Select Parent</option>
			<?php echo $obj->categoryTreerec(); ?>
		</select>
		<br>
		<br>
		<input type="text" placeholder="Enter catname" name="catname" required>
		<br>
		<br>
		<input type="submit" name="submit" value="Add">
	</form>
</div>