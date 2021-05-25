<?php
include '../includes/db.php';

if(isset($_POST['submit'])){
	$error=array();

if(empty($_POST['admin_name'])){
	$error['admin_name']="Please Input Your Name";
	}
	
if(empty($_POST['admin_email'])){
	$error['admin_email']="Please Input Your Email Address";
	}else{
			$statement=$conn->prepare("SELECT * FROM admin WHERE admin_email =:em");
			$statement->bindParam(":em",$_POST['admin_email']);
			$statement->execute();
			
			if($statement->rowCount()>0){
				$error['admin_email'] = "Email already Exist";
				}
				
if(empty($_POST['hash'])){
	$error['hash']="Please Input Password";
	}
	
if(empty($_POST['confirm_hash'])){
	$error['confirm_hash']="Please Confirm Password";
	}elseif($_POST['hash']!==$_POST['confirm_hash']){
			$error['confirm_hash']="Password Mismatch";
			}

if(empty($error)){
		$encrypted=password_hash($_POST['hash'],PASSWORD_BCRYPT);
		$stmt=$conn->prepare("INSERT INTO admin VALUES(NULL, :adn, :ade, :hsh, NOW(), NOW() )");
		$data = array(
				":adn"=>$_POST['admin_name'],
				":ade"=>$_POST['admin_email'],
				":hsh"=>$encrypted
				);
		$stmt->execute($data);
		header("Location:login.php");
		exit();
						
		}
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Admin Signup</title>
</head>

<body>
    <h1>Mary's Web School</h1>
    <h3>Welcome to Mary's Web School.</h3>
    <p style="font-size:18px"><i>Proceed with signing up!</i></p>
    <hr />
	<form action="" method="post">
    	<p>Name: <input type="text" name="admin_name" /></p>
<?php
if(isset($error['admin_name'])){
	echo "<p style=color:red>".$error['admin_name']."</p>";
	}
?>
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
        <p>Confirm Password: <input type="password" name="confirm_hash"/></p>
<?php
if(isset($error['confirm_hash'])){
	echo "<p style=color:red>".$error['confirm_hash']."</p>";
	}
?>
  <br />
        <button type="submit" name="submit">Sign Up</button>
    </form>
</body>
</html>