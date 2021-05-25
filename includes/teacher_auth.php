<?php
if(!isset($_SESSION['teacher_id'])&& !isset($_SESSION['teacher_name'])){
	header("location:teacher_login.php?error=The page you visited requires login") ;	
exit();
}


?>