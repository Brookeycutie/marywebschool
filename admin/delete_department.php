<?php
session_start();
include("../includes/admin_auth.php");
include('../includes/db.php');


if(!isset($_GET['id'])){
	header("Location:department.php");
	exit();
}

$statement = $conn->prepare("DELETE FROM department WHERE department_id=:did");
$statement->bindParam(":did", $_GET['id']);
$statement->execute();

header("Location:department.php");
exit();