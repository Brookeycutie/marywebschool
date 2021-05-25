<?php
session_start();
include("../includes/admin_auth.php");
include('../includes/db.php');

$fetch=$conn->prepare("SELECT * FROM teacher");
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
<title>Teacher Accounts</title>
</head>

<body>
<?php include('../includes/admin_header.php');
if(isset($_GET['update'])){
	echo "<p style=color:green>".$_GET['update']."</p>";
	}
?>
<h2>Teacher Accounts</h2>

<table border="2">
<tr>
    <th>Teacher Name</th>
    <th>Teacher Email</th>
    <th>Created By</th>
    <th>Edit</th>
    <th>Delete</th>
    <th>Date Created</th>
    <th>Time Created</th>
</tr>
<?php foreach($records as $value): ?>
<tr>
    <td><?=$value['teacher_name']?></td>
    <td><?=$value['teacher_email']?></td>
    <td><?=$value['created_by']?></td>
    <td><a href="edit_teacher.php?id=<?=$value['teacher_id']?>">Edit</a></td>
    <td><a href="delete_teacher.php?id=<?=$value['teacher_id']?>">Delete</a></td>
    <td><?=$value['date_created']?></td>
    <td><?=$value['time_created']?></td>
</tr>

<?php endforeach;?>
</table>
</body>
</html>