<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Blog</title>
    <!-- Bootstrap -->
    <link href="css/bootstrap.min.css" rel="stylesheet">
  </head>
  <body>	
	<div style="margin-top:50px"></div>
	<?php
		if(!isset($_COOKIE['userid'])){
			header("Location:Blog.php");
		}
		include('nav.php');
		$conn = mysql_connect("localhost","root","");
		$user = $_COOKIE['userid'];
		$sql = "select user_name from user_info where user_id = '$user'";
		mysql_select_db('blog_user');
		$retval = mysql_query($sql);
		$row = mysql_fetch_array($retval);
		$username = $row['user_name'];?>
		<script>
			document.getElementById("profile").innerHTML = "<?php echo $username;?>";
		</script>
	<div style="margin-top:200px">
	</div>
	<table style="margin-left:225px" class="table-bordered">
	<?php
		$userid = $_GET['user_id'];
		$sql = "select photo_id from user_photo where user_id  = '$userid'";
		mysql_select_db('blog_user');
		$ret = mysql_query($sql);
		$counter = 0;
		while($row = mysql_fetch_array($ret)){ 		
			echo "<tr><td><a href='showuserpic.php?photoid=".$row['photo_id']."'><img style='height:220px;width:220px'src='upload/".$row['photo_id']."' /></a></td>";
			if($row = mysql_fetch_array($ret)){
				echo "<td><a href='showuserpic.php?photoid=".$row['photo_id']."'><img style='height:220px;width:220px'src='upload/".$row['photo_id']."' /></a></td>";
			}
			if($row = mysql_fetch_array($ret)){
				echo "<td><a href='showuserpic.php?photoid=".$row['photo_id']."'><img style='height:220px;width:220px'src='upload/".$row['photo_id']."' /></a></td>";
			}
			if($row = mysql_fetch_array($ret)){
				echo "<td><a href='showuserpic.php?photoid=".$row['photo_id']."'><img style='height:220px;width:220px'src='upload/".$row['photo_id']."' /></a></td></tr>";
			}	
		}
	?>
	</table>
  </body>
</html>
