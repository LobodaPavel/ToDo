<?php 
	require "db.php";

	setcookie("logged_user", $data['reg_login'], time()-36000);

	header('location: /index.php');
 ?>