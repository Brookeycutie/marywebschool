<?php
session_start();
include("../includes/admin_auth.php");
include('../includes/db.php');

if(isset($_POST['submit'])){
	$error=array();
	
	if(empty($_POST['student_name'])){
		$error['student_name'] ="Please Enter Student's Name";
		}

	if(empty($_POST['student_email'])){
		$error['student_email'] ="Please Enter Student's Email";
		}else{
			$statement=$conn->prepare("SELECT * FROM student WHERE student_email =:sem");
			$statement->bindParam(":sem",$_POST['student_email']);
			$statement->execute();
			
			if($statement->rowCount()>0){
				$error['student_email'] = "Email already Exist";
				}
	if(empty($_POST['department'])){
	$error['department']="Please Select Department";
	}
	if(empty($_POST['hash'])){
		$error['hash'] ="Please Enter Password";
		}

	if(empty($error)){
		$encrypted=password_hash($_POST['hash'],PASSWORD_BCRYPT);
		$stmt=$conn->prepare("INSERT INTO student VALUES(NULL, :sn, :sem, :dep, :hsh, :cb, NOW(), NOW() )");
		$data = array(
				":sn"=>$_POST['student_name'],
				":sem"=>$_POST['student_email'],
				":dep"=>$_POST['department'],
				":hsh"=>$encrypted,
				":cb"=>$_SESSION['admin_name']
				);
		$stmt->execute($data);
		
		header("Location:account.php?success=Student's account created successfully");
		exit();
			
		}
	}
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create Student Account</title>
</head>

<body>
<?php include('../includes/admin_header.php');
?>
<h1>Create Student Account</h1>
<form action="" method="post">
<?php
if(isset($error['student_name'])){
	echo "<p style=color:red>".$error['student_name']."</p>";
	}
?>
	<p>Name: <input type="" name="student_name"/></p>
<?php
if(isset($error['student_email'])){
	echo "<p style=color:red>".$error['student_email']."</p>";
	}
?>
    <p>Email: <input type="email" name="student_email"/></p>
    <p>Department: 
<?php
	$stmt=$conn->prepare("SELECT * FROM department");
	$stmt->execute();
   
echo "<select name='department'>";
   while($row=$stmt->fetch(PDO::FETCH_BOTH)){
	   echo "<option value='".$row['department_id']."'>".$row['department_name']."</option>";
	   }
	  echo "<select>";   	
?></p>
<?php
if(isset($error['hash'])){
	echo "<p style=color:red>".$error['hash']."</p>";
	}
?>
    <p>Password: <input type="password" name="hash" /></p>
   <input type="submit" name="submit" value="Create Student Account"/>
</form>
</body>
</html>