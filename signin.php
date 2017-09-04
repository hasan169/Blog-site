<?php 
	$username = $_POST['username'];
	$usermail = $_POST['usermail'];
	$password = $_POST['password'];	
	$gender = $_POST['gender'];	
	$dob = $_POST['dob'];
	mysql_connect("localhost","root","");
	$sql = "select max(user_id) as id from user_info";
	mysql_select_db('blog_user');
	$retval =  mysql_query($sql);
	$id = 1;
	if($row = mysql_fetch_array($retval)){
		$id = $row['id'];
		$id = $id + 1;
	}
	$sql = "insert into user_info (user_id,user_name,user_email,user_password,gender,dob) values ($id,'$username','$usermail','$password','$gender','$dob')";
	mysql_select_db('blog_user');
	$retval = mysql_query($sql);
?>