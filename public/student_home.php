<?php
session_start();
include ('../includes/db.php');
include "../includes/student_auth.php";

	$fetch=$conn->prepare("SELECT * FROM student WHERE student_id=:sid");
	$fetch->bindParam(":sid", $_SESSION['id']);
	$fetch->execute();
   	$row=$fetch->fetch(PDO::FETCH_BOTH);
	
	
	$ftc=$conn->prepare("SELECT * FROM department WHERE department_id=:did");
	$ftc->bindParam(":did", $row['department_id']);
	$ftc->execute();
   	$records=$ftc->fetch(PDO::FETCH_BOTH);
	
	$select = $conn->prepare("SELECT * FROM course WHERE department_id=:did");
	$select->bindParam(":did",$row['department_id']);
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
<title>Student Homepage</title>
</head>

<body>
<?php
include "../includes/student_header.php";
?>

<h2>Department: <?=$records['department_name']?></h2>

<h4>The courses to be undergone in <?=$records['department_name']?> department are as follows:</h4>
<table border="2">
	<tr>
    	<th>Course Code</th>
        <th>Course Title</th>
    </tr>
 <?php foreach($record as $value):?> 
    <tr>
    	<td><?=$value['course_code']?></td>
        <td><?=$value['course_title']?></td>
    </tr>
 <?php endforeach?>
</table>
</body>
</html>