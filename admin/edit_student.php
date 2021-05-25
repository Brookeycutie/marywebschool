<?php
session_start();
include("../includes/admin_auth.php");
include('../includes/db.php');

if(isset($_GET['id'])){
$student_id = $_GET['id'];	
}else{
	header("Location:student_accounts.php");
}
$statement=$conn->prepare("SELECT * FROM student");
$statement->execute();
$select=array();
while($row=$statement->fetch(PDO::FETCH_BOTH)){
	$select[]=$row;
}
$stmt=$conn->prepare("SELECT * FROM student WHERE student_id=:sid");
$stmt->bindParam(":sid", $student_id);
$stmt->execute();

$record = $stmt->fetch(PDO::FETCH_BOTH);
if($stmt->rowCount()<1){
 header("Location:student_accounts.php");
 exit();	
}
if(isset($_POST['submit'])){
	$error=array();

if(empty($_POST['student_name'])){
	$error['student_name']= "Enter Student's Name";
	}
if(empty($_POST['student_email'])){
	$error['student_email']= "Enter Student's Email";
	}
if(empty($error)){
	$statement=$conn->prepare("UPDATE student SET student_name=:snm, student_email=:sem, department_id=:did WHERE student_id =:sid");
	$statement->bindParam(":snm", $_POST['student_name']);
	$statement->bindParam(":sem", $_POST['student_email']);
	$statement->bindParam(":did", $_POST['department']);
	$statement->bindParam(":sid", $student_id);
	
	$statement->execute();
	
	header("Location:student_accounts.php?update=Info Updated Successfully!");
	exit();
	}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Student Account</title>
</head>

<body>
<h2>Edit Student Account</h2>
<?php include('../includes/admin_header.php');
?>

<form action="" method="post">
	<p>Name: <input type="text" name="student_name" placeholder="Student Name" value="<?=$record['student_name']?>"/> </p>
    <p>Email: <input type="text" name="student_email" placeholder="Student Email" value="<?=$record['student_email']?>"/></p>
    	<?php
   $stmt=$conn->prepare("SELECT * FROM department");
   $stmt->execute();
   	
   echo "<select name='department'>";
   while($row=$stmt->fetch(PDO::FETCH_BOTH)){
	   echo "<option value='".$row['department_id']."'>".$row['department_name']."</option>";
	   }
	echo "<select> <br>";   
?>
    <input type="submit" name="submit" value="Update Student Account" />
</form>

</body>
</html>