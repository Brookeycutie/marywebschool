<?php
session_start();
include("../includes/admin_auth.php");
include('../includes/db.php');


if(!isset($_GET['id'])){
	header("Location:course.php");
	exit();
}

$statement = $conn->prepare("DELETE FROM course WHERE course_id=:cid");
$statement->bindParam(":cid", $_GET['id']);
$statement->execute();

header("Location:course.php");
exit();