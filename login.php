<?php
	function keyInDatabase($username, $password) {
		$userQuery = sprintf("SELECT username, password FROM users 
			WHERE username='%s' AND password='%s' LIMIT 1;",
			$username,
			$password);
		$result = mysql_query($userQuery);
		if (!$result) {
			$message  = 'Invalid query: ' . mysql_error() . "\n";
			$message .= 'Whole query: ' . $query;
			die($message);
		}
		$null = 0;
		while ($row = mysql_fetch_assoc($result)) {
			$null++;
		}
		if ($null == 0) {
			return FALSE;
		} else {
			return TRUE;
		}
		mysql_free_result($result);
	}
?>

<?php
	session_start();
	if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'])
		header('Location: admin.php');
?>

<?php
	include_once "connect.php";
	$status = "loggingIn";

	if(isset($_POST['username']) && isset($_POST['password'])) {
		$_SESSION['loggedIn'] = FALSE;
		$_SESSION['username'] = $_POST['username'];

		$username = mysql_real_escape_string($_POST['username']);
		$password = md5($_POST['password']);

		if (keyInDatabase($username, $password)) {
			$status = "success";
			$_SESSION['loggedIn'] = TRUE;
			echo "hello";
			header('Location: admin.php');
		} else {
			$status = "failure";
		}
	}
	mysql_close($con);
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Login Page</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<link href="../css/bootstrap.css" rel="stylesheet">
		<style type="text/css">
			body {
				padding-top: 40px;
				padding-bottom: 40px;
				background-color: #f5f5f5;
			}

			.form-signin {
				max-width: 300px;
				padding: 19px 29px 29px;
				margin: 0 auto 20px;
				background-color: #fff;
				border: 1px solid #e5e5e5;
				-webkit-border-radius: 5px;
					 -moz-border-radius: 5px;
								border-radius: 5px;
				-webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
					 -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
								box-shadow: 0 1px 2px rgba(0,0,0,.05);
			}
			.form-signin .form-signin-heading,
			.form-signin .checkbox {
				margin-bottom: 10px;
			}
			.form-signin input[type="text"],
			.form-signin input[type="password"] {
				font-size: 16px;
				height: auto;
				margin-bottom: 15px;
				padding: 7px 9px;
			}

		</style>
		<link href="../css/bootstrap-responsive.css" rel="stylesheet">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="../assets/js/html5shiv.js"></script>
		<![endif]-->

		<!-- Fav and touch icons -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../assets/ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
			<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
										<link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
																	 <link rel="shortcut icon" href="../assets/ico/favicon.png">
	</head>

	<body>

		<div class="container">

			<form action="login.php" class="form-signin" method="post">
				<h2 class="form-signin-heading">Please sign in</h2>
				<input type="text" name="username" class="input-block-level" placeholder="Username">
				<input type="password" name="password" class="input-block-level" placeholder="Password">
				<button class="btn btn-large btn-primary" type="submit">Sign in</button>
			</form>

		</div> <!-- /container -->

		<!-- Le javascript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="../js/jquery.js"></script>
		<script src="../js/bootstrap.js"></script>

	</body>
</html>