<?php
	$conn = mysql_connect("localhost","root","");
	date_default_timezone_set("Asia/Dhaka");
	$user = $_COOKIE['userid'];
	$str = $_POST['status'];
	$str = mysql_real_escape_string($str);
	$str = trim($str);
	$str = stripcslashes($str);
	$heading = $_POST['heading'];
	$heading = mysql_real_escape_string($heading);
	$sql = "select max(post_id) as id from user_post";
	mysql_select_db('blog_user');
	$retval =  mysql_query($sql);
	$id = 1;
	if($row = mysql_fetch_array($retval)){
		$id = $row['id'];
		$id = $id + 1;
	}
	$sql = "insert into user_post(post_id,user_id,post_date,post_time,heading,post) values ($id,$user,CURDATE(),CURTIME(),'$heading','$str')";
	mysql_select_db('blog_user');
	$retval = mysql_query($sql);
	echo $id;
?>