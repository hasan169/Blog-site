<?php
	mysql_connect("localhost","root","");
	$flag = true;
	$user = $_COOKIE['userid'];
	$follows  = $_POST['follower'];
	$sql = "select following_id from follower where user_id = '$user'";
	mysql_select_db('blog_user');
	$ret = mysql_query($sql);
	while( $row = mysql_fetch_array($ret)){
		if($row['following_id'] == $follows ){
			$flag = false;
			break;
		}
	}
	if($flag){
		$sql = "insert into follower (user_id,following_id) values ($user,$follows)";
		mysql_select_db('blog_user');
		$ret = mysql_query($sql); 
		echo "Unfollow";
	}
	else{
		$sql = "delete from follower where user_id = '$user' and following_id = '$follows'";
		mysql_select_db('blog_user');
		$ret = mysql_query($sql); 
		echo "Follow";
	}
?>