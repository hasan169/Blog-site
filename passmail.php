<?php
	mysql_connect("localhost","root","");
	$name = $_POST['em'];
	if (!filter_var($name, FILTER_VALIDATE_EMAIL)) {
		echo "true"; 
	}
	else{
		$sql = "select user_email from user_info";
		mysql_select_db('blog_user');
		$ret = mysql_query($sql);
		$flag = false;
		while($row = mysql_fetch_array($ret)){
			if($row['user_email'] == $name){
				$flag  = true;
				break;
			}
		}
		if($flag){
			echo "true";
		}
		else{
			echo "false";
		}
	}
?>