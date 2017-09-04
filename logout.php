<?php
	setcookie("userid","",time() - 60*60);
	header("Location:blog.php");
?>