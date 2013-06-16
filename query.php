<?php
	include_once "connect.php";
	$queryTerm = strtolower($_GET["acronym"]);

	$query = sprintf("SELECT encoding, description FROM acronyms 
		WHERE encoding='%s';",
		mysql_real_escape_string($queryTerm));
	$result = mysql_query($query);

	if (!$result) {
		$message  = 'Invalid query: ' . mysql_error() . "\n";
		$message .= 'Whole query: ' . $query;
		die($message);
	}
?>

<?php
	session_start();
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Search Results</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<link href="../css/bootstrap.css" rel="stylesheet">
		<style>
			body {
				padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
			}
		</style>
		<link href="../css/bootstrap-responsive.css" rel="stylesheet">

		<!-- Fav and touch icons -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="../ico/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="../ico/apple-touch-icon-114-precomposed.png">
			<link rel="apple-touch-icon-precomposed" sizes="72x72" href="../ico/apple-touch-icon-72-precomposed.png">
										<link rel="apple-touch-icon-precomposed" href="../ico/apple-touch-icon-57-precomposed.png">
																	 <link rel="shortcut icon" href="../ico/favicon.png">
	</head>

	<body>

		<div class="navbar navbar-inverse navbar-fixed-top">
			<div class="navbar-inner">
				<div class="container">
					<button type="button" class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
						<span class="icon-bar"></span>
					</button>
					<a class="brand" href="index.php">Acronym Solutions</a>
					<div class="nav-collapse collapse">
						<?php
							if(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
								echo "
								<p class='navbar-text pull-right'>
									Logged in as <a href='admin.php' class='navbar-link'>" . $_SESSION['username'] . "</a>
								</p>
								";
							} else {
								echo "
								<p class='navbar-text pull-right'>
									<a href='login.php' class='navbar-link'>Login</a>
								</p>
								";
							}
						?>
						<ul class="nav">
							<li><a href="index.php">Home</a></li>
							<li><a href="about.php">About</a></li>
							<li><a href="contact.php">Contact</a></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>

		<div class="container">

			<form action="index.php" method="get">
			<legend>Search Results for "<?php echo $queryTerm ?>"</legend>
			<div class="row">
				<div class="span8">
					<div class="row">
						<?php
							$null = 0;
							while ($row = mysql_fetch_assoc($result)) {
								echo "<div class='span4 lightblue'>".
								$row['description'].
								"<p><a class='btn' href='#''>View details &raquo;</a></p>
								</div>";
								$null++;
							}
							if ($null == 0) {
								echo "Sorry, no results found";
							}

							mysql_free_result($result);
							mysql_close($con);
						?>
					</div>
				</div><!--/span-->
			</div><!--/row-->
			<button type="submit" class="btn btn-primary">Search Again!</button>
			</form>

			<hr>
			
			<!-- FOOTER -->
			<footer>
				<p class="pull-right"><a href="#">Back to top</a></p>
				<p>&copy; 2013 <a href="http://www.awardsolutions.com/">Award Solutions, Inc.</a></p>
			</footer>

		</div> <!-- /container -->

		<!-- Le javascript
		================================================== -->
		<!-- Placed at the end of the document so the pages load faster -->
		<script src="../js/jquery.js"></script>
		<script src="../js/bootstrap.js"></script>

	</body>
</html>