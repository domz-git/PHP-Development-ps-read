<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
  }
  
  $username = "";
  $password = "";
  $errors = array(); 
  $db = mysqli_connect('localhost', 'root', '', 'psread');


  if (isset($_POST['user_login'])) {
	$username = mysqli_real_escape_string($db, $_POST['username']);
	$password = mysqli_real_escape_string($db, $_POST['password']);
  
	if (empty($username)) {
		array_push($errors, "Korisničko ime obavezno!");
	}
	if (empty($password)) {
		array_push($errors, "Lozinka obavezna!");
	}
  
	if (count($errors) == 0) {
	   
		$query = "SELECT * FROM user WHERE username='$username' AND password='$password'";
		$results = mysqli_query($db, $query);
		$user = mysqli_fetch_assoc($results);
		if (mysqli_num_rows($results) == 1) {
		  $_SESSION['username'] = $username;
		
			header('location: admin.php');
	
		}else {
			array_push($errors, "Pogrešno korisničko ime ili lozinka!");
		}
		
	}
  }
	
  ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Login V2</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->	
	<link rel="icon" type="image/png" href="images/icons/favicon.ico"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="fonts/iconic/css/material-design-iconic-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
<!--===============================================================================================-->	
	<link rel="stylesheet" type="text/css" href="vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="css/util.css">
	<link rel="stylesheet" type="text/css" href="css/main.css">
<!--===============================================================================================-->
</head>
<body>
	
	<div class="limiter">
		<div class="container-login100">
			<div class="wrap-login100">
				<form class="login100-form validate-form" onsubmit="return validateFormLogin()" method="post" action="login.php">
				<?php include('errors.php'); ?>
					<span class="login100-form-title p-b-26">
						Dobrodošla
					</span>
					<span class="login100-form-title p-b-48">
						<i class="zmdi zmdi-font"></i>
					</span>

					<div class="wrap-input100" >
						<input class="input100" type="text" name="username">
						<span class="focus-input100" data-placeholder="Login"></span>
					</div>

					<div class="wrap-input100" data-validate="Enter password">
						<span class="btn-show-pass">
							<i class="zmdi zmdi-eye"></i>
						</span>
						<input class="input100" type="password" name="password">
						<span class="focus-input100" data-placeholder="Lozinka"></span>
					</div>

					<div class="container-login100-form-btn">
						<div class="wrap-login100-form-btn">
							<div class="login100-form-bgbtn"></div>
							<button type="submit" name="user_login" class="login100-form-btn">
								Login
							</button>
							
						</div>
						<img src="images/image.png" alt="" style="height:auto; width: 200px;margin-left:30px;">
					</div>

					<div class="text-center p-t-115">
						<span class="txt1">
							Vrati se na naslovnu stranicu:
						</span>

						<a class="txt2" href="index.php">
							Ovdje!
						</a>
					</div>
				</form>
			</div>
		</div>
	</div>
	

	<div id="dropDownSelect1"></div>
	
<!--===============================================================================================-->
	<script src="vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/bootstrap/js/popper.js"></script>
	<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script src="vendor/daterangepicker/moment.min.js"></script>
	<script src="vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script src="vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script src="js/main.js"></script>
<!-- </body> -->
</body>
</html>