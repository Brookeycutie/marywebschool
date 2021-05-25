<?php
if(!isset($_SESSION['id'])&& !isset($_SESSION['name'])){
	header("location:student_login.php?error=The page you visited requires login") ;	
exit();
}


?>