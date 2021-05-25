<?php
session_start();
include '../includes/db.php';

if(isset($_POST['submit'])){
	$error=array();

if(empty($_POST['admin_email'])){
	$error['admin_email']="Please Input Your Email Address";
	}

if(empty($_POST['hash'])){
	$error['hash']="Please Input Password";
	}

if(empty($error)){
	
	$stmt=$conn->prepare("SELECT * FROM admin WHERE admin_email= :ade");
	$stmt->bindParam(":ade",$_POST['admin_email']);
	$stmt->execute();
	$record = $stmt->fetch(PDO::FETCH_BOTH);
	
	if($stmt->rowCount()>0 &&password_verify($_POST['hash'],$record['hash'])){
	
		$_SESSION['admin_id']= $record['admin_id'];
		$_SESSION['admin_name']= $record['admin_name'];
	
		header("Location:home.php");
		}else{
		header("Location:login.php?error=Either email or password is incorrect");
			
			}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Login</title>
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
        <p>Email: <input type="email" name="admin_email" /></p>
<?php
if(isset($error['admin_email'])){
	echo "<p style=color:red>".$error['admin_email']."</p>";
	}
?>
        <p>Password: <input type="password" name="hash"/></p>
<?php
if(isset($error['hash'])){
	echo "<p style=color:red>".$error['hash']."</p>";
	}
?>
  <br />
        <button type="submit" name="submit">Login</button>
</form>

</body>
</html>