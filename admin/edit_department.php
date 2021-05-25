<?php
session_start();
include("../includes/admin_auth.php");
include('../includes/db.php');

if(isset($_GET['id'])){
$department_id = $_GET['id'];	
}else{
	header("Location:department.php");
}
$statement=$conn->prepare("SELECT * FROM department");
$statement->execute();
$select=array();
while($row=$statement->fetch(PDO::FETCH_BOTH)){
	$select[]=$row;
}
$stmt=$conn->prepare("SELECT * FROM department WHERE department_id=:did");
$stmt->bindParam(":did", $department_id);
$stmt->execute();

$record = $stmt->fetch(PDO::FETCH_BOTH);
if($stmt->rowCount()<1){
 header("Location:department.php");
 exit();	
}
if(isset($_POST['submit'])){
	$error=array();

if(empty($_POST['department_name'])){
	$error['department_name']= "Enter Department Name";
	}
if(empty($error)){
	$statement=$conn->prepare("UPDATE department SET department_name=:dn WHERE department_id =:did");
	$statement->bindParam(":dn", $_POST['department_name']);
	$statement->bindParam(":did", $department_id);
	
	$statement->execute();
	
	header("Location:department.php?update=Info Updated Successfully!");
	exit();
	}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Department</title>
</head>

<body>
<h2>Edit Department</h2>
<?php include('../includes/admin_header.php');
?>

<form action="" method="post">
	<p>Department: <input type="text" name="department_name" placeholder="Department Name" value="<?=$record['department_name']?>"/> </p>
    <input type="submit" name="submit" value="Update Department" />
</form>


</body>
</html>