<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
     <title>Blog</title>
    <!-- Bootstrap -->
	<link type="text/css" href="css/newsfeed.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet"> 
   <script src="js/jquery.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
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
		function del_status(ob){
			$.ajax({
				type: "POST",
				url: 'newsfeed.php',
				data: 'del_status='+ob.id
			});
			var tbl = document.getElementById(ob.id);
			tbl.parentNode.removeChild(tbl);
		};
		function call_blur(ob){
			ob.style = "color:#bdbdbd";
			if(ob.value==""){
				ob.value=" write a comment...";
			}
		};
		function call_focus(ob){
			ob.style = "color:black";
			if(ob.value==" write a comment..."){
				ob.value=""; 
			}
		};
		function del_comment(ob){
			var row = ob.parentNode.parentNode;
			row.parentNode.removeChild(row);
			$.ajax({
				type: "POST",
				url: 'newsfeed.php',
				data: 'del_comment='+ob.id		
			});
		};
		function auto_grow(element) {
			element.style.height = "5px";
			element.style.height = (element.scrollHeight)+"px";	
		};
		function convert_str(str) {
			str = str.replace(/&/g, "&amp;"); 
			str = str.replace(/"/g, "&quot;");
			str = str.replace(/'/g, "&#039;");
			str = str.replace(/</g, "&lt;");
			str = str.replace(/>/g, "&gt;");
			return str;
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
		function post_status(){
			<?php
				date_default_timezone_set("Asia/Dhaka");
			?>
			var status = document.getElementById("status").value;
			var a = status;
			status = convert_str(status);
			var heading = document.getElementById("heading").value;
			var b = heading;
			heading = convert_str(heading);
			$.ajax({
				type: "POST",
				url: 'insertstatus.php',
				data: 'status='+a+'&heading='+b,
				success: function(result) {
					var getdiv = document.getElementById("ldv");
					var username = document.getElementById("profile").innerHTML;
					var table = document.createElement("TABLE");
					table.setAttribute("id", result);
					table.setAttribute("class", "table-bordered");
					$(getdiv).prepend(table);
					var row = table.insertRow(0);
					var cell = row.insertCell(0);
					cell.style.fontFamily="verdana";
					cell.style.backgroundColor='white';
					cell.style.fontSize="14px";
					cell.innerHTML = '<h4>' + username + '<span onclick="del_status(this)" id="'+ result +'"class="glyphicon glyphicon-remove"> </span><br><small><?php echo date("F j Y") . " at " . date("h:i a") ; ?></small></h4>' + '<p style="font-size:13px;margin-left:5px">' + status + '</p>';
					var row = table.insertRow(-1);
					var cell = row.insertCell(0);
					cell.innerHTML = '<textarea style="color:#bdbdbd" id="cmnt" onblur="call_blur(this)" onfocus="call_focus(this)" rows="2" cols="60" name="'+ result +'" onkeydown="pressed(event,this)" onkeyup="auto_grow(this)" > write a comment...</textarea>';
					document.getElementById("status").value = "";
					document.getElementById("heading").value = "";
				}
			});
		};
    </script>
	<?php
		include('nav.php');
	?>
	<div  style="margin-top:40px">
	</div>	
		<input class="hd_bar" type ="text" placeholder="  Title.... "  id = "heading" autocomplete="off" /> 
		<textarea id="status" class="stat_bar" onkeyup="auto_grow(this)" autocomplete="off" ></textarea> 
		<div class="pbar"><button onclick="post_status()" id="pbtn" class="btn btn-primary btn-sm"> POST </button></div>
	<div class="divide">
	<div id="ldv" class="left-div">
	<?php	
		$conn = mysql_connect("localhost","root","");
		date_default_timezone_set("Asia/Dhaka");
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
		$sql = "select post_id,user_id,post_date,post_time,post from user_post where user_id = '$user' or user_id in (select following_id from follower where user_id = '$user' ) order by post_date desc,post_time desc";
		mysql_select_db('blog_user');
		$retval = mysql_query($sql);
		if(isset($_POST['del_comment'])){
			echo $cmnt_id;
			$cmnt_id = $_POST['del_comment'];
			$sql = "delete from user_comments where comment_id = '$cmnt_id'";
			mysql_select_db('blog_user');
			$ret = mysql_query($sql);
		} 
		if(isset($_POST['del_status'])){
			$postid = $_POST['del_status'];
			$sql = "delete from user_comments where post_id = '$postid'";
			mysql_select_db('blog_user');
			$ret = mysql_query($sql);
			$sql = "delete from user_post where post_id = '$postid'";
			mysql_select_db('blog_user');
			$ret = mysql_query($sql);
		}
	?>
	<?php 
		while( $row = mysql_fetch_array($retval)){
			$comm =  $row['post_id'];
			$id = $row['user_id'];
			$sql = "select user_name from user_info where user_id = '$id'";
			mysql_select_db('blog_user');
			$ret = mysql_query($sql);
			$temp = mysql_fetch_array($ret);
			$name = $temp['user_name'];
			$date = date('F j Y', strtotime($row['post_date']));
			$time = date('h:i a', strtotime($row['post_time']));	
			$sql = "select comment_id,post,user_id,comment_date,comment_time from user_comments where post_id = '$comm'";
			mysql_select_db('blog_user');
			$ret = mysql_query($sql);
	?>
			<table id="<?php echo $comm;?>" class="table-bordered"> <tr> <td style="background-color:white"> <h4><a style="color:black;text-decoration:none" href="showprof.php?user_id=<?php echo $id;?>"><?php echo $name; ?> </a>
			<?php if( $id == $user){?>
				<span onclick="del_status(this)" id="<?php echo  $comm; ?>" class="glyphicon glyphicon-remove"> </span>
			<?php }?>
			<br> <small><?php echo $date . " at " . $time . "<br>"; ?> </small>  </h4>
			<p style="font-size:14px;margin-left:5px"><?php echo htmlspecialchars($row['post']);?> </p> </td> </tr>
			<tr> <td> <textarea style="color:#bdbdbd" onfocus="call_focus(this)" onblur="call_blur(this)" rows="2" cols="60" id="cmnt" name="<?php echo $comm; ?>" onkeydown="pressed(event,this)" onkeyup="auto_grow(this)" > write a comment...</textarea> </td> </tr>	
			<?php 
				while ($num = mysql_fetch_array($ret)) {
					$uid = $num['user_id'];
					$sql =  "select user_name from user_info where user_id = '$uid'";
					mysql_select_db('blog_user');
					$add = mysql_query($sql);
					$commenter = mysql_fetch_array($add);
					$date = date('F j Y', strtotime($num['comment_date']));
					$time = date('h:i a', strtotime($num['comment_time']));	
			?>
				<tr> <td> <h5> <?php echo $commenter['user_name']; ?>
				<?php if(($id == $user) || ($uid == $user)) {?>	
					<span onclick="del_comment(this)" id="<?php echo $num['comment_id']; ?>" class="glyphicon glyphicon-remove"> </span>
				<?php } ?>	
				<br> <small><?php echo $date . " at " . $time ; ?></small> </h5> 
				<p style="font-size:13px;margin-left:5px"><?php echo htmlspecialchars($num['post']);?> </p> </td> </tr>
			<?php } ?>
	</table>
	<?php } ?>	
		<div style="height:250px"> </div>
		</div>
			<div class="right-div">
				<?php 
					$sql = "select post_id,heading from user_post where user_id != '$user' and user_id not in (select following_id from follower where user_id = '$user') order by post_date desc,post_time desc";
					mysql_select_db('blog_user');
					$ret = mysql_query($sql);
					$counter = 0;
					while($row = mysql_fetch_array($ret)){
						if( $counter == 20 ){
							break;
						}
						$counter++;
					?>
					<a id="rd"style="text-decoration:none" href="showpost.php?postid=<?php echo $row['post_id']; ?>"> <h4> <?php echo $row['heading']; ?> </h4></a>
				<?php } ?>	
			</div>
		</div>
	</body>
</html>