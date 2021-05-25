<?php
session_start();
include("../includes/admin_auth.php");
include('../includes/db.php');


if(!isset($_GET['id'])){
	header("Location:student_accounts.php");
	exit();
}

$statement = $conn->prepare("DELETE FROM student WHERE student_id=:sid");
$statement->bindParam(":sid", $_GET['id']);
$statement->execute();

header("Location:student_accounts.php");
exit();