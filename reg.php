<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title>Blog</title>
	<style>
		#success{
			visibility:hidden;
			margin-top:5px;
		}
	</style>
    <!-- Bootstrap -->
	   <script src="js/jquery.min.js"></script>
    <link href="css/bootstrap.min.css" rel="stylesheet">
	<link href="css/blog.css" rel="stylesheet">
	<script>
		function wfunc( str ){
			document.getElementById("wpass").innerHTML = str;
			 document.getElementById("wpass").style.visibility = "visible";
		};
		function mfunc(){
		
			 document.getElementById("mpass").style.visibility = "visible";
		};
		function dfunc(){
		
			 document.getElementById("dob").style.visibility = "visible";
		};
		function ufunc(str){
			 document.getElementById("user").innerHTML = str;
			 document.getElementById("user").style.visibility = "visible";		
		};
		function emfunc(){
			 document.getElementById("mailinfo").style.visibility = "visible";
		};
		function func(){
			document.getElementById("success").style.visibility = "hidden";
			document.getElementById("mailinfo").style.visibility = "hidden";
			document.getElementById("user").style.visibility = "hidden";
			document.getElementById("dob").style.visibility = "hidden";
			document.getElementById("mpass").style.visibility = "hidden";
			document.getElementById("wpass").style.visibility = "hidden";
			var username = document.getElementById("username").value;
			username = username.trim();
			if( username.length < 4 ){
				ufunc("username should be at least 4 characters in length");
			}
			else{
				var flag = true;
				for(  var  i = 0; i < username.length; i++){
					if ( !((username[i] >= 'a' && username[i] <= 'z') || (username[i] >= 'A' && username[i] <= 'Z') || username[i] ==' ')){
						flag = false;
						break;
					}
				}
				if( !flag){
					ufunc("only 'a'.. 'z', 'A'... 'Z'  and space are allowed");
				}
				else{
					var user_mail = document.getElementById("usermail").value;
					$.ajax({
						type: "POST",
						url: 'passmail.php',
						data: 'em='+user_mail,
						success: function(result) {
							if( result === "true"){
								emfunc();	
							}
							else{
								var pass = document.getElementById("password").value;
								var flag = false;
								for( var  i = 0 ; i < pass.length; i++){
									if(!((pass[i] >= 'a' && pass[i] <= 'z') || (pass[i] >= 'A' && pass[i] <= 'Z') || (pass[i] >= '0' && pass[i] <= '9') || pass[i] == '_' || pass[i] == ' ' || pass[i] == '.' || pass[i] == ',')){
										flag = true;
										break;
									}
								}
								if( flag ){
									wfunc(" only 'a'... 'z' , 'A'...'Z' , '0' ... '9' ,  underscore '_' ,  comma  ',' and  dot '.' are allowed");
								}
								else if(pass.length < 6 ){
									wfunc(" password should be at least 6 characters in length ");
								}
								else{
									var repass = document.getElementById("repass").value;
									if( pass != repass ){
										mfunc();
									}
									else{
										var dob = document.getElementById("db").value;
										if(dob == ""){
											dfunc();
										}
										else{
											var gender  =  document.getElementById("sex").value;
											$.ajax({
												type: "POST",
												url: 'signin.php',
												data: 'username='+username+'&usermail='+user_mail+'&password='+pass+'&dob='+dob+'&gender='+gender,
												success: function(result) {
													document.getElementById("username").value = "";
													document.getElementById("usermail").value ="";
													document.getElementById("password").value ="";
													document.getElementById("repass").value = "";
													document.getElementById("db").value = "";
													document.getElementById("success").style.visibility = "visible";
												}
											});
										}
									}
								}
							}
						}
					
					});
				
				}			
			}
		};
	</script>
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>
    <?php
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
		</div><!-- /.navbar-collapse -->
		</div><!-- /.container-fluid -->
	</nav>
	<div style="margin-top:2%;margin-left:30%">
			
				<strong> User name: </strong><input class="bt-lg" autocomplete="off" style="margin-left:62px" type="text" id="username" />  <strong id="user"></strong> 
				<br>
				<br>
				<strong> Email address:</strong> <input class="bt-lg" autocomplete="off" style="margin-left:38px" type="text" id="usermail" />  <strong id="mailinfo"> Invalid Email </strong> 
				<br>
				<br>
				<strong> Password:</strong><input class="bt-lg" autocomplete="off" style="margin-left:71px" type="text" id="password" /> <strong id="wpass"></strong> 
				<br>
				<br>
				<strong> Re-enter Password: </strong> <input class="bt-lg" autocomplete="off" style="margin-left:5px"type="text" id="repass" /> <strong id="mpass"> Password don't match </strong> 
				<br>
				<br>
				<strong> Gender: </strong> <span style="margin-left:85px"></span> <input id="sex" type="radio" name="gender" value="male" checked="checked"> Male <input id="sex" type="radio" name="gender" value="female"> Female
				<br>
				<br>
				<strong> Date of Birth:</strong> <input class="bt-lg" style="margin-left:45px"  type="date" id="db" /> <strong id="dob">  Pick a Date of Birth </strong>
				<br>
				<br>
				<button style="margin-left:30%"class="btn btn-primary btn-md" onclick="func()" name="save"> Sign up </button>
			
	</div>	
	<div id="success" class="alert alert-success">
		<strong>Regestration completed!!</strong>
	</div>
	<?php
		mysql_connect('localhost','root','');
		date_default_timezone_set("Asia/Dhaka");
		$date = date('F d Y');
	?>
	<div class="navbar navbar-inverse navbar-fixed-bottom">
		<div class="container">
			<div class="navbar-text pull-left">
				<p>Shagor's Blog <span><?php echo  $date;?></span> </p> 
			</div>
		</div>
	</div>
  </body>
</html>