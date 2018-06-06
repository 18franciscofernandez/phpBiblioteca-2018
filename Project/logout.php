<?php		
		$_SESSION['estado'] = "out";
		setcookie("finsesion","yes");
		session_start();
		session_unset();
		session_destroy();
        echo "<script type=\"text/javascript\">alert(\"Se ha cerrado sesión correctamente.\");</script>";
		header("Location: index.php");
?>