<?php
session_start();
include("../includes/admin_auth.php");
include('../includes/db.php');

if(isset($_GET['id'])){
$course_id = $_GET['id'];	
}else{
	header("Location:course.php");
}
$statement=$conn->prepare("SELECT * FROM course");
$statement->execute();
$select=array();
while($row=$statement->fetch(PDO::FETCH_BOTH)){
	$select[]=$row;
}
$stmt=$conn->prepare("SELECT * FROM course WHERE course_id=:cid");
$stmt->bindParam(":cid", $course_id);
$stmt->execute();

$record = $stmt->fetch(PDO::FETCH_BOTH);
if($stmt->rowCount()<1){
 header("Location:course.php");
 exit();	
}
if(isset($_POST['submit'])){
	$error=array();

if(empty($_POST['course_code'])){
	$error['course_code']= "Enter Course Code";
	}
if(empty($_POST['course_title'])){
	$error['course_title']= "Enter Course Title";
	}

if(empty($_POST['department'])){
	$error['department']= "Select Department";
	}
if(empty($_POST['teacher'])){
	$error['teacher']= "Select Teacher";
	}
if(empty($error)){
	$statement=$conn->prepare("UPDATE course SET course_code=:cd, course_title=:ct, department_id=:did, teacher_id=:tid WHERE course_id =:cid");
	$statement->bindParam(":cd", $_POST['course_code']);
	$statement->bindParam(":ct", $_POST['course_title']);
	$statement->bindParam(":did", $_POST['department']);
	$statement->bindParam(":tid", $_POST['teacher']);
	$statement->bindParam(":cid", $course_id);
	
	$statement->execute();
	
	header("Location:course.php?update=Info Updated Successfully!");
	exit();
	}

}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Edit Course</title>
</head>

<body>
<h2>Edit Course</h2>
<?php include('../includes/admin_header.php');
?>

<form action="" method="post">
	<p>Course Code: <input type="text" name="course_code" placeholder="Course Code" value="<?=$record['course_code']?>"/> </p>
  	<p>Course Title: <input type="text" name="course_title" placeholder="Course Title" value="<?=$record['course_title']?>"/> </p>
   	<p>Department:
 	<?php
   $stmt=$conn->prepare("SELECT * FROM department");
   $stmt->execute();
   
   echo "<select name='department'>";
   while($row=$stmt->fetch(PDO::FETCH_BOTH)){
	   echo "<option value='".$row['department_id']."'>".$row['department_name']."</option>";
	   }
	echo "<select> <br>";   
?></p>
	<p>Teacher In-charge:
    <?php
   $stmt=$conn->prepare("SELECT * FROM teacher");
   $stmt->execute();
   
   echo "<select name='teacher'>";
   while($row=$stmt->fetch(PDO::FETCH_BOTH)){
	   echo "<option value='".$row['teacher_id']."'>".$row['teacher_name']."</option>";
	   }
	echo "<select>";   
 ?></p>
 <input type="submit" name="submit" value="Update Course" />
     <br />
</form>


</body>
</html>