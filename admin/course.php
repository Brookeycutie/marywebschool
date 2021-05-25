<?php
session_start();
include("../includes/admin_auth.php");
include('../includes/db.php');

if(array_key_exists('submit', $_POST)){
	 $error=array();
	 if(empty($_POST['course_code'])){
		 $error['course_code']="Enter Course Code";
		 }
	if(empty($_POST['course_title'])){
		 $error['course_title']="Enter Course Title";
		 }
	if(empty($_POST['department'])){
		 $error['department']="Enter Department";
		 }
	if(empty($_POST['teacher'])){
		 $error['teacher']="Enter Teacher-in-charge";
		 }
	if(empty($error)){
		$stmt=$conn->prepare("INSERT INTO course VALUES(NULL, :cd, :ct, :did, :tid, :cb, NOW(), NOW() )");
		$stmt->bindParam(":cd", $_POST['course_code']);
		$stmt->bindParam(":ct", $_POST['course_title']);
		$stmt->bindParam(":did", $_POST['department']);
		$stmt->bindParam(":tid", $_POST['teacher']);
		$stmt->bindParam(":cb", $_SESSION['admin_id']);
		$stmt->execute();
		
		header("Location:course.php");
		exit();
	}
}

$select = $conn->prepare("SELECT * FROM course");
$select->execute();
$record=array();

while($row=$select->fetch(PDO::FETCH_BOTH)){
	$record[]=$row;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Courses</title>
</head>

<body>
<?php include('../includes/admin_header.php');?>
<h4>Create your courses below</h4>
    <form action"" method="post">
	<input type="text" name="course_code" placeholder="Course Code" />
    <br />
    <input type="text" name="course_title" placeholder="Course Title" />
    <br />
 	<?php
   $stmt=$conn->prepare("SELECT * FROM department");
   $stmt->execute();
   
   echo "<select name='department'>";
   while($row=$stmt->fetch(PDO::FETCH_BOTH)){
	   echo "<option value='".$row['department_id']."'>".$row['department_name']."</option>";
	   }
	echo "<select> <br>";   
	
   $stmt=$conn->prepare("SELECT * FROM teacher");
   $stmt->execute();
   
   echo "<select name='teacher'>";
   while($row=$stmt->fetch(PDO::FETCH_BOTH)){
	   echo "<option value='".$row['teacher_id']."'>".$row['teacher_name']."</option>";
	   }
	echo "<select>";   
 ?>
 	<br />
    <input type="submit" name="submit" value="Create">
    </form>
    
<table border="2">
<tr>
	<th>Course Code</th>
    <th>Course Name</th>
    <th>Department ID</th>
    <th>Teacher ID</th>
    <th>Admin ID</th>
    <th>Edit</th>
    <th>Delete</th>
    <th>Date Created</th>
    <th>Time Created</th>
</tr>
<?php foreach($record as $value):?>

<tr>
	<td><?=$value['course_code']?></td>
    <td><?=$value['course_title']?></td>
    <td><?=$value['department_id']?></td>
    <td><?=$value['teacher_id']?></td>
	<td><?=$value['created_by']?></td>
    <td><a href="edit_course.php?id=<?=$value['course_id']?>">Edit</a></td>
    <td><a href="delete_course.php?id=<?=$value['course_id']?>">Delete</a></td>
	<td><?=$value['date_created']?></td>
	<td><?=$value['time_created']?></td>
</tr>

<?php endforeach; ?>
</table>
</body>
</html>