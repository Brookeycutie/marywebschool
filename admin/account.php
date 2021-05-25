<?php
session_start();
include('../includes/admin_auth.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Accounts Section</title>
</head>

<body>
<?php include('../includes/admin_header.php');
if(isset($_GET['success'])){
	echo "<p style=color:green>".$_GET['success']."</p>";
	}
?>
<h1>Accounts Section</h1>
<a href="create_teacher.php">Create Teacher Account</a>
<br />
<a href="create_student.php">Create Student Account</a>
<br />
<a href="teacher_accounts.php">Teacher Accounts</a>
<br />
<a href="student_accounts.php">Student Accounts</a>
</body>
</html>