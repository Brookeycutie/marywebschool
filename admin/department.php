<?php
session_start();
include("../includes/admin_auth.php");
include('../includes/db.php');

if(array_key_exists('submit', $_POST)){
	 $error=array();
	 if(empty($_POST['department_name'])){
		 $error['department_name']="Enter Department Name";
		 }
	if(empty($error)){
		$stmt=$conn->prepare("INSERT INTO department VALUES(NULL, :dn, :cb, NOW(), NOW() )");
		$stmt->bindParam(":dn", $_POST['department_name']);
		$stmt->bindParam(":cb", $_SESSION['admin_id']);
		$stmt->execute();
		
		header("Location:department.php");
		exit();
	}
}

$fetch=$conn->prepare("SELECT * FROM department");
$fetch->execute();

$records=array();

while($row=$fetch->fetch(PDO::FETCH_BOTH)){
	$records[]=$row;	
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create Department</title>
</head>

<body>
<?php include('../includes/admin_header.php');?>
<h4>Create your departments below</h4>
    <form action"" method="post">
	<input type="text" name="department_name" placeholder="Department Name" />
    <input type="submit" name="submit" value="Create">
    </form>
    
<table border="2">
<tr>
	<th>Department Name</th>
    <th>Admin</th>
    <th>Edit</th>
    <th>Delete</th>
    <th>Date Created</th>
    <th>Time Created</th>
</tr>
<?php foreach($records as $value): ?>
<tr>
    <td><?=$value['department_name']?></td>
    <td><?=$_SESSION['admin_name']?></td>
    <td><a href="edit_department.php?id=<?=$value['department_id']?>">Edit</a></td>
    <td><a href="delete_department.php?id=<?=$value['department_id']?>">Delete</a></td>
    <td><?=$value['date_created']?></td>
    <td><?=$value['time_created']?></td>
</tr>

<?php endforeach;?>
</table>

</body>
</html>