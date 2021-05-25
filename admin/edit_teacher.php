<?php
session_start();
include("../includes/admin_auth.php");
include('../includes/db.php');

if(isset($_GET['id'])){
$teacher_id = $_GET['id'];	
}else{
	header("Location:teacher_accounts.php");
}
$statement=$conn->prepare("SELECT * FROM teacher");
$statement->execute();
$select=array();
while($row=$statement->fetch(PDO::FETCH_BOTH)){
	$select[]=$row;
}
$stmt=$conn->prepare("SELECT * FROM teacher WHERE teacher_id=:tid");
$stmt->bindParam(":tid", $teacher_id);
$stmt->execute();

$record = $stmt->fetch(PDO::FETCH_BOTH);
if($stmt->rowCount()<1){
 header("Location:teacher_accounts.php");
 exit();	
}
if(isset($_POST['submit'])){
	$error=array();

if(empty($_POST['teacher_name'])){
	$error['teacher_name']= "Enter Teacher's Name";
	}
if(empty($_POST['teacher_email'])){
	$error['teacher_email']= "Enter Teacher's Email";
	}
if(empty($error)){
	$statement=$conn->prepare("UPDATE teacher SET teacher_name=:tnm, teacher_email=:tem WHERE teacher_id =:tid");
	$statement->bindParam(":tnm", $_POST['teacher_name']);
	$statement->bindParam(":tem", $_POST['teacher_email']);
	$statement->bindParam(":tid", $teacher_id);
	
	$statement->execute();
	
	header("Location:teacher_accounts.php?update=Info Updated Successfully!");
	exit();
	}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Teacher Account</title>
</head>

<body>
<h2>Edit Teacher Account</h2>
<?php include('../includes/admin_header.php');
?>

<form action="" method="post">
	<p>Name: <input type="text" name="teacher_name" placeholder="Teacher Name" value="<?=$record['teacher_name']?>"/> </p>
    <p>Email: <input type="text" name="teacher_email" placeholder="Teacher Email" value="<?=$record['teacher_email']?>"/> </p>
    <input type="submit" name="submit" value="Update Teacher Account" />
</form>

</body>
</html>