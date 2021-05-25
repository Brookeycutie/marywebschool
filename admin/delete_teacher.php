<?php
session_start();
include("../includes/admin_auth.php");
include('../includes/db.php');


if(!isset($_GET['id'])){
	header("Location:teacher_accounts.php");
	exit();
}

$statement = $conn->prepare("DELETE FROM teacher WHERE teacher_id=:tid");
$statement->bindParam(":tid", $_GET['id']);
$statement->execute();

header("Location:teacher_accounts.php");
exit();