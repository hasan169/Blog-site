<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Blog</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/blog.css" rel="stylesheet">
  </head>
  <body>
	<?php
		 if(isset($_COOKIE['userid'])){
		 	header("Location:newsfeed.php");
		 }
		 mysql_connect("localhost","root","");
	?>
	<nav class="navbar navbar-inverse">
		<div class="container-fluid">
		<!-- Brand and toggle get grouped for better mobile display -->
		<div class="navbar-header">
		  <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
		    <span class="sr-only">Toggle navigation</span>
		    <span class="icon-bar"></span>
		    <span class="icon-bar"></span>
		    <span class="icon-bar"></span>
		  </button>
		  <a class="navbar-brand" href="Blog.php">Shagor Blog</a>
		</div>
		<!-- Collect the nav links, forms, and other content for toggling -->
		<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
		  <ul class="nav navbar-nav navbar-right">
		    <li><a href="Reg.php">Register</a></li>
		  </ul>
		</div>
		</div>
	</nav>
	<?php
		date_default_timezone_set("Asia/Dhaka");
		$date = date('F d Y');
	?>
	<div id="login" class="container">
		<div class="row" style="margin-top: 75px">
			<div class="col-md-3">
				<form class="form-signin" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
			        <h2 class="form-signin-heading">Log In</h2>
			        <label for="inputEmail" class="sr-only">Email address</label>
			        <input type="email" id="inputEmail" name="usermail" class="form-control" placeholder="Email address" required autofocus>
			        <label for="inputPassword" class="sr-only">Password</label>
			        <input type="password" id="inputPassword" name="pass" class="form-control" placeholder="Password" required>
			        <button class="btn btn-lg btn-primary btn-block" name="login" type="submit">Sign in</button>
		      </form>
			</div>
			<div class="col-md-9">
				<div class="jumbotron">
				  <h1>Hello, world!</h1>
				  <p>This is shagor hasan. Welcome to my blog</p>
				</div>
			</div>
		</div>
	</div>
	<div class="navbar navbar-inverse navbar-fixed-bottom">
		<div class="container">
			<div class="navbar-text pull-left">
				<p>Shagor's Blog <span><?php echo  $date;?></span> </p> 
			</div>
		</div>
	</div>
	<?php
		if(isset($_POST['login'])){
			$em = $_POST['usermail'];
			$ps = $_POST['pass'];
			$ps = htmlspecialchars($ps);
			$sql = "select user_password from user_info where user_email = '$em'"; 
			mysql_select_db('blog_user');
			$retval = mysql_query($sql);	
			$row = mysql_fetch_array($retval);
			if($row['user_password'] == $ps ){
				$sql = "select user_id from user_info where user_email = '$em'"; 
				mysql_select_db('blog_user');
				$retval = mysql_query($sql);
				$row = mysql_fetch_array($retval);
				setcookie("userid",$row['user_id'],time()+60*60*24*30);
				header("Location:newsfeed.php");
			}
			else{
				echo "<h4 style='margin-left:120px'>Invalid email or password</h4>";
			}
		}
	?>
	</body>
</html>