<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Blog</title>
    <!-- Bootstrap -->
	<link href="css/showpic.css" rel="stylesheet">
    <link href="css/bootstrap.min.css" rel="stylesheet">
	   <script src="js/jquery.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body class ="jumbotron">
	<?php
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
	  <script>
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
		function convert_str(str) {
			str = str.replace(/&/g, "&amp;"); 
			str = str.replace(/"/g, "&quot;");
			str = str.replace(/'/g, "&#039;");
			str = str.replace(/</g, "&lt;");
			str = str.replace(/>/g, "&gt;");
			return str;
		};
  		function auto_grow(element) {
			element.style.height = "5px";
			element.style.height = (element.scrollHeight)+"px";	
		};
		function del_comment(ob){
			var row = ob.parentNode.parentNode;
			row.parentNode.removeChild(row);
			$.ajax({
				type: "POST",
				url: 'showpic.php',
				data: 'del_comment='+ob.id		
			});
		};
		function del_photo(ob){
			$.ajax({
				type: "POST",
				url: 'showpic.php',
				data: 'del='+ob.name,
				success: function() {
					window.location.href = 'photo.php';
				}
			});
		};
		function profile_photo(ob){
			$.ajax({
				type: "POST",
				url: 'showpic.php',
				data: 'proid='+ob.name
			});
		};
		function pressed(e,ob) {
			if ( e.keyCode == 13) { 
				<?php
					date_default_timezone_set("Asia/Dhaka");
				?>
				$.ajax({
					type: "POST",
					url: 'photocomment.php',
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
    </script>
	<?php
		if(!isset($_COOKIE['userid'])){
			header("Location:Blog.php");
		}
		include('nav.php');
		$user = $_COOKIE['userid'];
		$conn = mysql_connect("localhost","root","");
		$photoid = $_GET['photoid'];
		if(isset($_POST['del'])){
			$id = $_POST['del'];
			$sql = "delete from photo_comments where photo_id = '$id'";
			mysql_select_db('blog_user');
			$ret = mysql_query($sql);
			$sql = "select photo_id from profile where user_id = '$user'";
			mysql_select_db('blog_user');
			$ret = mysql_query($sql);
			if($row = mysql_fetch_array($ret)){
				$pic = $row['photo_id'];
				if( $pic == $id ){
					$sql = "delete from profile where user_id = '$user'";
					mysql_select_db('blog_user');
					$ret = mysql_query($sql);
				}
			}
			$sql = "delete from user_photo where photo_id = '$id'";
			mysql_select_db('blog_user');
			$ret = mysql_query($sql);
			$path = "upload/" . $id;
			unlink($path);
		}
		if(isset($_POST['proid'])){
			$id = $_POST['proid'];
			$sql = "insert into profile values($user,$id)";
			mysql_select_db('blog_user');
			$ret = mysql_query($sql);
			$sql = "update profile set photo_id = '$id' where user_id = '$user'";
			mysql_select_db('blog_user');
			$ret = mysql_query($sql);
		}
		if(isset($_POST['del_comment'])){
			$cmnt_id = $_POST['del_comment'];
			$sql = "delete from photo_comments where comment_id = '$cmnt_id'";
			mysql_select_db('blog_user');
			$ret = mysql_query($sql);
		} 
	?>
	<div style="margin-top:50px"></div>
	<div class="divide">
	<div class="left-div">
	<?php
		
		$sql = "select user_name from user_info where user_id = '$user'";
		mysql_select_db('blog_user');
		$retval = mysql_query($sql);
		$row = mysql_fetch_array($retval);
		$username = $row['user_name'];?>
		<script>
			document.getElementById("profile").innerHTML = "<?php echo $username;?>";
		</script>
	<?php		
		$sql = "select photo_date,photo_time from user_photo where photo_id = '$photoid'";
		mysql_select_db('blog_user');
		$ret = mysql_query($sql);
		$row =  mysql_fetch_array($ret);
		$date = date('F j Y', strtotime($row['photo_date']));
		$time = date('h:i a', strtotime($row['photo_time']));	
		$sql = "select comment_id,post,user_id,comment_date,comment_time from photo_comments where photo_id = '$photoid'";
		mysql_select_db('blog_user');
		$ret = mysql_query($sql);
		$path = "upload/" . $photoid;
	?>
	<img class = "img-thumbnail" style="margin-left:100px;height:520px;width:720px" src="<?php echo $path;?>" />	
	</div>
	<div class="right-div">
		<h4 style="display:inline;margin-left:20px"> <?php echo $username;?> </h4>
		 <button name="<?php echo $photoid;?>" onclick="del_photo(this)" style="display:inline;float:right;margin-right:20px"> Delete </button>
		<button name="<?php echo $photoid;?>" onclick="profile_photo(this)" style="display:inline;float:right;margin-right:5px"> profile picture </button>
		<h4 style="margin-left:20px;margin-top:-5px"><small><?php echo $date . " at " . $time . "<br>"; ?> </small>  </h4>
		<table  id="<?php echo $photoid;?>" class="table-bordered">
			<tr> <td> <textarea id="cmnt" onfocus="call_focus(this)" onblur="call_blur(this)" rows="1" cols="60" name="<?php echo $photoid; ?>" onkeydown="pressed(event,this)" onkeyup="auto_grow(this)"> write a comment...</textarea> </td> </tr>	
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
			<span onclick="del_comment(this)" id="<?php echo $num['comment_id']; ?>" class="glyphicon glyphicon-remove"> </span>
			<br>
			<small><?php echo $date . " at " . $time ; ?></small> </h5> 
			<p style="font-size:13px;margin-left:5px"><?php echo htmlspecialchars($num['post']);?> </p> </td> </tr>
			<?php } ?>
		</table>
	</div>
	</div>
  </body>
</html>