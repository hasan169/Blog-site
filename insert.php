<?php
	mysql_connect("localhost","root","");
	$user = $_COOKIE['userid'];
	$pid = $_POST['name'];
	$str = trim($_POST['cmnt']);
	$str = stripcslashes($str);
	$str = mysql_real_escape_string($str);
	$id = 1;
	$sql = "select max(comment_id) as id from user_comments";
	mysql_select_db('blog_user');
	$ret = mysql_query($sql);
	if( $row = mysql_fetch_array($ret)){
		$id = $row['id'];
		$id = $id + 1;
	}
	$sql = "insert into user_comments (comment_id,user_id,post_id,comment_date,comment_time,post) values ($id,$user,$pid,CURDATE(),CURTIME(),'$str')";
	mysql_select_db('blog_user');
	$ret = mysql_query($sql);
	echo $id;			
?>
						