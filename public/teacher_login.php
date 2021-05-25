<?php
session_start();
include '../includes/db.php';

if(isset($_POST['submit'])){
	$error=array();

if(empty($_POST['teacher_email'])){
	$error['teacher_email']="Please Input Your Email Address";
	}

if(empty($_POST['hash'])){
	$error['hash']="Please Input Password";
	}

if(empty($error)){
	
	$stmt=$conn->prepare("SELECT * FROM teacher WHERE teacher_email= :tde");
	$stmt->bindParam(":tde",$_POST['teacher_email']);
	$stmt->execute();
	$record = $stmt->fetch(PDO::FETCH_BOTH);
	
	if($stmt->rowCount()>0 &&password_verify($_POST['hash'],$record['hash'])){
	
		$_SESSION['teacher_id']= $record['teacher_id'];
		$_SESSION['teacher_name']= $record['teacher_name'];
	
		header("Location:teacher_home.php");
		}else{
		header("Location:teacher_login.php?error=Either email or password is incorrect");
			
			}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Teacher Login</title>
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
if(isset($error['teacher_email'])){
	echo "<p style=color:red>".$error['teacher_email']."</p>";
	}
?>
        <p>Email: <input type="email" name="teacher_email" /></p>
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