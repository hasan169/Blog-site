<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Blog</title>

    <!-- Bootstrap -->
	   <script src="js/jquery.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
	 <link href="css/srch.css" rel="stylesheet">
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <script>
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
</script>
  <?php
		if(!isset($_COOKIE['userid'])){
			header("Location:Blog.php");
		}
	?>
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
  <body class="jumbotron">	
	<?php
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
		mysql_connect("localhost","root","");
		$follower = array();
		$user = $_COOKIE['userid'];
		$sql = "select following_id from follower where user_id = '$user'";
		mysql_select_db('blog_user');
		$ret = mysql_query($sql);
		while( $row = mysql_fetch_array($ret)){
			array_push($follower,$row['following_id']);							
		}
	?>
	<table class="table-bordered" style="background-color:white">
			<?php
				session_start();
				$search_name = $_SESSION['srch_name'];
				$sql = "select user_name,user_id from user_info where user_name like '$search_name%' and user_id != $user";
				mysql_select_db('blog_user');
				$ret = mysql_query($sql);
				$found = true;
				while( $row = mysql_fetch_array($ret)){ 
					$temp  = $row['user_id'];
					$found = false;
					$sql = "select photo_id from profile where user_id = '$temp'";
					mysql_select_db('blog_user');
					$retval = mysql_query($sql);
					if($add = mysql_fetch_array($retval)){
						$pid = $add['photo_id'];
						echo '<tr><td><img style="width:80px;height:80px"src="upload/'.$pid.'"/>';
					}
					else{
						echo "<tr><td><img style='width:80px;height:80px' src='upload/0.jpg'/>";
					}
					?>
					<a style="text-decoration:none" href="showprof.php?user_id=<?php echo $row['user_id'];?>"> <strong style="margin-left:140px;font-size:20px;"><?php echo  $row['user_name']; ?></strong> </a> 
					<button style="float:right;margin-top:20px;margin-right:20px"id="<?php echo $row['user_id']; ?>" class="btn btn-primary btn-sm" onclick="clicked(this)"></button></td></tr>
					<?php 
						$flag = true;
						$len = sizeof($follower);
						for( $i = 0; $i < $len; $i++ ){
							if($follower[$i] == $temp ){
								$flag = false;
								break;
							}
						}
						if($flag){
							?>
							<script>
								var v = <?php echo $temp; ?>;
								document.getElementById(v).innerHTML = "Follow";
							</script>
						<?php } else{ ?>
							<script>
								var v = <?php echo $temp; ?>;
								document.getElementById(v).innerHTML = "Unfollow";
							</script>
					<?php	}
				 }			
				?>
	</table>
	<?php
		if( $found ){
			 echo "<h4 style='margin-left:42%'> No search found!!</h4>";
		}

	?>
  </body>
</html>