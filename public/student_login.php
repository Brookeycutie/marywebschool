<?php
session_start();
include '../includes/db.php';

if(isset($_POST['submit'])){
	$error=array();

if(empty($_POST['student_email'])){
	$error['student_email']="Please Input Your Email Address";
	}

if(empty($_POST['hash'])){
	$error['hash']="Please Input Password";
	}

if(empty($error)){
	
	$stmt=$conn->prepare("SELECT * FROM student WHERE student_email= :sde");
	$stmt->bindParam(":sde",$_POST['student_email']);
	$stmt->execute();
	$record = $stmt->fetch(PDO::FETCH_BOTH);
	
	if($stmt->rowCount()>0 &&password_verify($_POST['hash'],$record['hash'])){
	
		$_SESSION['id']= $record['student_id'];
		$_SESSION['name']= $record['student_name'];
	
		header("Location:student_home.php");
		}else{
		header("Location:student_login.php?error=Either email or password is incorrect");
			
			}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Student Login</title>
</head>

<body>
	<h1>Mary's Web School</h1>
    <h3>Welcome to Mary's Web School.</h3>
    <p style="font-size:18px"><i>Please Login to Proceed!</i></p>
    <hr />
<?php
if(isset($_GET['error'])){
	echo "<p style=color:red>".$_GET['error']."</p>";
	}
?>
<form action="" method="post">
<?php
if(isset($error['student_email'])){
	echo "<p style=color:red>".$error['student_email']."</p>";
	}
?>
        <p>Email: <input type="email" name="student_email" /></p>
<?php
if(isset($error['hash'])){
	echo "<p style=color:red>".$error['hash']."</p>";
	}
?>
        <p>Password: <input type="password" name="hash"/></p>

        <button type="submit" name="submit">Login</button>
</form>
</body>
</html>