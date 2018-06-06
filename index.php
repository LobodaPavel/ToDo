<?php 	
		require "libs/rb.php";
		
		if (isset($_COOKIE["logged_user"])) {
			header('location: /home.php');
		}else{
			header('location: /regpage.php');
		}

 ?>