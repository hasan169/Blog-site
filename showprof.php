<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
     <title>Blog</title>
	<style>
		ul{
			list-style-type:none;
		}
		li{
			display:inline;
		}
	</style>
	<link type="text/css" href="css/showprof.css" rel="stylesheet">
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet"> 
	   <script src="js/jquery.min.js"></script>
  </head>
  	<?php
		if(!isset($_COOKIE['userid'])){
			header("Location:Blog.php");
		}
		if(isset($_POST['search_btn'])){
			$name = $_POST['search_bar'];
			if($name != ""){
				session_start();
				$_SESSION['srch_name'] = $name;
				header("Location:search.php");
				exit();
			}
		}
	?>
  <body class="jumbotron">
	<script>	
		function call_focus(ob){
			ob.style = "color:black";
			if(ob.value==" write a comment..."){
				ob.value=""; 
			}
		};
		function call_blur(ob){
			ob.style = "color:#bdbdbd";
			if(ob.value==""){
				ob.value=" write a comment...";
			}
		};
		function clicked(ob) {
			$.ajax({
				type: "POST",
				url: 'getid.php',
				data: 'follower='+ob.id,
				success: function(result) {
					document.getElementById(ob.id).innerHTML = result;
				}
			});
		};
		function convert_str(str) {
			str = str.replace(/&/g, "&amp;"); 
			str = str.replace(/"/g, "&quot;");
			str = str.replace(/'/g, "&#039;");
			str = str.replace(/</g, "&lt;");
			str = str.replace(/>/g, "&gt;");
			return str;
		};
		function del_comment(ob){
			var row = ob.parentNode.parentNode;
			row.parentNode.removeChild(row);
			$.ajax({
				type: "POST",
				url: 'profile.php',
				data: 'del_comment='+ob.id		
			});
		};
		function auto_grow(element) {
			element.style.height = "5px";
			element.style.height = (element.scrollHeight)+"px";	
		};
		function pressed(e,ob) {
			if ( e.keyCode == 13) { 
				<?php
					date_default_timezone_set("Asia/Dhaka");
				?>
				$.ajax({
					type: "POST",
					url: 'insert.php',
					data: 'name='+ob.name+'&cmnt='+ob.value,
					success: function(result) {
						var val = convert_str(ob.value);
						var username = document.getElementById("profile").innerHTML;
						var table = document.getElementById(ob.name);
						var row = table.insertRow(-1);
						var cell = row.insertCell(0);
						cell.innerHTML = '<h5>' + username + '<span onclick="del_comment(this)" id="'+ result +'"class="glyphicon glyphicon-remove"> </span><br><small><?php echo date("F j Y") . " at " . date("h:i a") ; ?></small></h5>' + '<p style="font-size:13px;margin-left:5px">' + val + '</p>';
						ob.value = "";
					}
				});
			}			
		};
		function func(){
			 window.location.href = "photo.php?user_id=" + userid;
		};
    </script>
	<div class="divide">
		<?php
			$conn = mysql_connect("localhost","root","");
			date_default_timezone_set("Asia/Dhaka");
			$user = $_COOKIE['userid'];
			$userid = $_GET['user_id'];
			if($user == $userid ){
				header("Location:profile.php");
			}
			include('nav.php');
			echo '<script> var userid ='. $userid .';</script>';
		?>
	<div class="left-div">
		<div style="margin-top:50px;margin-left:25px;">
			<?php
				$sql = "select photo_id from profile where user_id = '$userid'";
				mysql_select_db('blog_user');
				$ret = mysql_query($sql);
				if($row = mysql_fetch_array($ret)){
					$picid = $row['photo_id'];
					echo "<a href='showuserpic.php?photoid=".$picid."'> <img class = 'img-thumbnail' style='margin-left:20px;width:260px;height:220px' src='upload/".$picid."' /></a>";
				}
				else{
					echo "<img class = 'img-thumbnail' style='margin-left:20px;width:260px;height:220px' src='upload/0.jpg' />";
				}
			?>
		</div>
		<div style="margin-left:40px;background-color:white;width:330px">
		<ul style="margin-top:30px">
			<li> <img  style="margin-top:5px; width:35px;height:35px"src="photoicon.png" /></li>
			<li><a style="text-decoration:none" href="userphoto.php?user_id=<?php echo $userid; ?>"> <strong style="font-size:18px;color:black"> Photos </strong> </a></li>	
		</ul>
		<?php
			$sql = "select photo_id from user_photo where user_id = '$userid'";
			mysql_select_db('blog_user');
			$ret = mysql_query($sql);
			$counter = 0;
			while($row = mysql_fetch_array($ret)){
				if( $counter == 9 ){
					break;
				}
				echo "<a style='margin-left:15px' href='showuserpic.php?photoid=".$row['photo_id']."'><img style='width:100px;height:100px'src='upload/".$row['photo_id']."'/></a>";
				if($row = mysql_fetch_array($ret)){
					echo "<a style='margin-left:1px' href='showuserpic.php?photoid=".$row['photo_id']."'><img style='width:100px;height:100px'src='upload/".$row['photo_id']."'/></a>";
				}
				if($row = mysql_fetch_array($ret)){
					echo "<a style='margin-left:1px'href='showuserpic.php?photoid=".$row['photo_id']."'><img style='width:100px;height:100px'src='upload/".$row['photo_id']."'/></a>";
				}
				$counter = $counter + 3;
			}
		?>
		</div>
	</div>
	<div  style="margin-top:50px" class="right-div">
	<?php
		$user = $_COOKIE['userid'];
		$sql = "select user_name from user_info where user_id = '$user'";
		mysql_select_db('blog_user');
		$retval = mysql_query($sql);
		$row = mysql_fetch_array($retval);
		$username = $row['user_name'];?>
		<script>
			document.getElementById("profile").innerHTML = "<?php echo $username;?>";
		</script>
	<?php
			$userid = $_GET['user_id'];
			$sql = "select user_name from user_info where user_id = '$userid'";
			mysql_select_db('blog_user');
			$retval = mysql_query($sql);
			$row = mysql_fetch_array($retval);
			$username = $row['user_name'];?>	
			<button style="margin-top:10px"id="<?php echo $userid; ?>" class="btn btn-primary btn-sm" onclick="clicked(this)"> follow </button>
	<div style="margin-top:20px"></div>		
	<?php 
		$flag = true;
		$sql = "select following_id from follower where user_id = '$user'";
		mysql_select_db('blog_user');
		$ret = mysql_query($sql);
		while( $row = mysql_fetch_array($ret)){
			if($row['following_id'] == $userid ){
				$flag = false;
				break;
			}
		}
		if($flag){
	?>
	<script>
		var v = <?php echo $userid ?>;
		document.getElementById(v).innerHTML = "Follow";
	</script>
	<?php } else{ ?>
		<script>
			var v = <?php echo $userid; ?>;
			document.getElementById(v).innerHTML = "Unfollow";
		</script>
	<?php	} ?>		
	<?php
			if(isset($_POST['del_comment'])){
				$cmnt_id = $_POST['del_comment'];
				$sql = "delete from user_comments where comment_id = '$cmnt_id'";
				mysql_select_db('blog_user');
				$ret = mysql_query($sql);
			}
			$sql = "select post_id,post_date,post_time,post from user_post where user_id = '$userid' order by post_date desc ,post_time desc";
			mysql_select_db('blog_user');
			$retval = mysql_query($sql);
		?>
			<?php 
				while( $row = mysql_fetch_array($retval)){
					$comm =  $row['post_id'];
					$date = date('F j Y', strtotime($row['post_date']));
					$time = date('h:i a', strtotime($row['post_time']));	
					$sql = "select comment_id,post,user_id,comment_date,comment_time from user_comments where post_id = '$comm'";
					mysql_select_db('blog_user');
					$ret = mysql_query($sql);
			?>
					<table  style="margin-top:5px"id="<?php echo $comm;?>" class="table-bordered"> <tr> <td style="background-color:white"> <h4> <?php echo $username ?> <br> 
					 <small><?php echo $date . " at " . $time . "<br>"; ?> </small>  </h4>
					 <p style="font-size:14px;margin-left:5px"><?php echo htmlspecialchars($row['post']);?> </p> </td> </tr>
				
					<tr> <td><textarea style="color:#bdbdbd" onblur="call_blur(this)" onfocus="call_focus(this)" rows= "2" cols="60" id="cmnt" name="<?php echo $comm; ?>" onkeydown="pressed(event,this)" onkeyup="auto_grow(this)" > write a comment...</textarea></td> </tr>	
					<?php while ($num = mysql_fetch_array($ret)) {
							$uid = $num['user_id'];
							$sql =  "select user_name from user_info where user_id = '$uid'";
							mysql_select_db('blog_user');
							$add = mysql_query($sql);
							$commenter = mysql_fetch_array($add);
							$date = date('F j Y', strtotime($num['comment_date']));
							$time = date('h:i a', strtotime($num['comment_time']));	
					?>
					<tr> <td> <h5> <?php echo $commenter['user_name']; ?> 
					<?php if($uid == $user) {?>
						<span onclick="del_comment(this)" id="<?php echo $num['comment_id']; ?>" class="glyphicon glyphicon-remove"> </span>
					<?php } ?>
					<br>
					<small><?php echo $date . " at " . $time ; ?></small> </h5> 
					<p style="font-size:13px;margin-left:5px"><?php echo htmlspecialchars($num['post']);?> </p> </td> </tr>
					<?php }?>
				</table>
				<?php  }?>	
		</div>	
		</div>
  </body>
</html>