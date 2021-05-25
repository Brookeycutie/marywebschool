<?php
session_start();
include("../includes/admin_auth.php");
include('../includes/db.php');

if(isset($_POST['submit'])){
	$error=array();
	
	if(empty($_POST['teacher_name'])){
		$error['teacher_name'] ="Please Enter Teacher's Name";
		}

	if(empty($_POST['teacher_email'])){
		$error['teacher_email'] ="Please Enter Teacher's Email";
		}else{
			$statement=$conn->prepare("SELECT * FROM teacher WHERE teacher_email =:tem");
			$statement->bindParam(":tem",$_POST['teacher_email']);
			$statement->execute();
			
			if($statement->rowCount()>0){
				$error['teacher_email'] = "Email already Exist";
				}

	if(empty($_POST['hash'])){
		$error['hash'] ="Please Enter Password";
		}

	if(empty($error)){
		$encrypted=password_hash($_POST['hash'],PASSWORD_BCRYPT);
		$stmt=$conn->prepare("INSERT INTO teacher VALUES(NULL, :tn, :tem, :hsh, :cb, NOW(), NOW() )");
		$data = array(
				":tn"=>$_POST['teacher_name'],
				":tem"=>$_POST['teacher_email'],
				":hsh"=>$encrypted,
				":cb"=>$_SESSION['admin_name']
				);
		$stmt->execute($data);
		
		header("Location:account.php?success=Teacher's account created successfully");
		exit();
			
		}
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create Teacher Account</title>
</head>

<body>
<?php include('../includes/admin_header.php');

?>
<h1>Create Teacher Account</h1>
<form action="" method="post">
<?php
if(isset($error['teacher_name'])){
	echo "<p style=color:red>".$error['teacher_name']."</p>";
	}
?>
	<p>Name: <input type="" name="teacher_name"/></p>
<?php
if(isset($error['teacher_email'])){
	echo "<p style=color:red>".$error['teacher_email']."</p>";
	}
?>
    <p>Email: <input type="email" name="teacher_email"/></p>
	
<?php
if(isset($error['hash'])){
	echo "<p style=color:red>".$error['hash']."</p>";
	}
?>
	<p> Password: <input type="password" name="hash"/></p>
   <input type="submit" name="submit" value="Create Teacher Account"/>
</form>
</body>
</html>