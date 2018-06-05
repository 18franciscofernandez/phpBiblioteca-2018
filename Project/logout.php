<?php		
		$_SESSION['estado'] = "out";
		setcookie("finsesion","yes");
		session_start();
		session_unset();
		session_destroy();
		header("Location: index.php");
?>