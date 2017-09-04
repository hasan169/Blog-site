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
  <body class="jumbotron">
	
	<div style="margin-top:70px"> </div>
	<form style="margin-left:68%"ENCTYPE="multipart/form-data" ACTION="photo.php" METHOD=POST>
		<INPUT NAME="file_up"  TYPE="file">
		<INPUT style="margin-top:1px" TYPE="submit" VALUE="Upload picture" name="save">
	</form>	
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
		<?php
		if(isset($_POST['save'])){
			if($_FILES['file_up']['size'] > 250000){
			}
			else{
				if(!($_FILES['file_up']['type'] == "image/jpeg" || $_FILES['file_up']['type'] == "image/png")){
				}
				else{
					$id = 1;
					$sql = "select max(photo_id) as id from user_photo";
					mysql_select_db('blog_user');
					$ret = mysql_query($sql);
					if($row = mysql_fetch_array($ret)){
						$id  = $row['id'];
						$id = $id + 1;
					}
					$sql = "insert into user_photo (user_id,photo_id,photo_date,photo_time) values($user,$id,CURDATE(),CURTIME())";
					mysql_select_db('blog_user');
					$ret = mysql_query($sql);
					move_uploaded_file($_FILES["file_up"]["tmp_name"], "upload/" . $id);
				}
			}
		}
	?>
	<table style="margin-left:225px" class="table-bordered">
	<?php
		$conn = mysql_connect("localhost","root","");
		$sql = "select photo_id from user_photo where user_id  = '$user'";
		mysql_select_db('blog_user');
		$ret = mysql_query($sql);
		$counter = 0;
		while($row = mysql_fetch_array($ret)){ 		
			echo "<tr><td><a href='showpic.php?photoid=".$row['photo_id']."'><img class='img-thumbnail' style='height:220px;width:220px'src='upload/".$row['photo_id']."' /></a></td>";
			if($row = mysql_fetch_array($ret)){
				echo "<td><a href='showpic.php?photoid=".$row['photo_id']."'><img class='img-thumbnail'style='height:220px;width:220px'src='upload/".$row['photo_id']."' /></a></td>";
			}
			if($row = mysql_fetch_array($ret)){
				echo "<td><a href='showpic.php?photoid=".$row['photo_id']."'><img class='img-thumbnail' style='height:220px;width:220px'src='upload/".$row['photo_id']."' /></a></td>";
			}
			if($row = mysql_fetch_array($ret)){
				echo "<td><a href='showpic.php?photoid=".$row['photo_id']."'><img class='img-thumbnail' style='height:220px;width:220px'src='upload/".$row['photo_id']."' /></a></td></tr>";
			}
			
		}
	?>
	</table>
  </body>
</html>
