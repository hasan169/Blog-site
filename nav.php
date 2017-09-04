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
   <script src="blog/js/jquery.min.js"></script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
  </head>
  <body>
	<nav class="navbar navbar-default navbar-fixed-top" style="background-color:#3B5999">
	<div class="container" >
		<div class="col-md-6">
			<form class="navbar-form" role="search" method="POST">
				<div class="input-group">
					<input type="text" class="form-control" placeholder="Search" name="search_bar">
					<div class="input-group-btn">
						<button class="btn btn-default" type="submit" name ="search_btn"><i class="glyphicon glyphicon-search"></i></button>
					</div>
				</div>
			</form>
		</div>
		<ul class="nav navbar-nav navbar-right">
			<li class="active">  <a style="background-color:#3B5999;color:white"href="newsfeed.php"> newsfeed</a></li>
			<li class="active">  <a style="background-color:#3B5999;color:white"id="profile" href="profile.php"> my profile </a></li>
			<li class="active">  <a style="background-color:#3B5999;color:white" href="logout.php"> Logout </a> </li>
		</ul>
	</div>
	</nav>
  </body>
</html>