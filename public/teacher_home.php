<?php
session_start();
include ('../includes/db.php');
include "../includes/teacher_auth.php";


	$fetch=$conn->prepare("SELECT * FROM course WHERE teacher_id=:tid");
	$fetch->bindParam(":tid", $_SESSION['teacher_id']);
	$fetch->execute();

	$records=array();

while($row=$fetch->fetch(PDO::FETCH_BOTH)){
	$records[]=$row;
	
	$ftc=$conn->prepare("SELECT * FROM department WHERE department_id=:did");
	$ftc->bindParam(":did", $row['department_id']);
	$ftc->execute();
   	$record=$ftc->fetch(PDO::FETCH_BOTH);
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teacher Homepage</title>
</head>

<body>
<?php
include "../includes/teacher_header.php";
?>

<h4>Welcome <?=$_SESSION['teacher_name']?>, you are incharge of these courses:</h4>
	<table border="2">
    	<tr>
        	<th>Course Code</th>
            <th>Course Title</th>
            <th>Department Name</th>
        </tr>
 <?php foreach($records as $value): ?>
	<tr>
    	<td><?=$value['course_code']?></td>
    	<td><?=$value['course_title']?></td>
        <td><?=$record['department_name']?></td>
    </tr>
<?php endforeach ?>
	</table>
</body>
</html>