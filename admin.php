<?php
	session_start();
	if(!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
		header('Location: login.php');
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<title>Admin Page</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="">

		<!-- Le styles -->
		<link href="../css/bootstrap.css" rel="stylesheet">
		<link href="../css/bootstrap-fileupload.css" rel="stylesheet" media="screen">
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
							<li class="active"><a href="admin.php">Admin</a></li>
						</ul>
					</div><!--/.nav-collapse -->
				</div>
			</div>
		</div>

		<div class="container">

			<h1>Administrivia</h1>

			<form action="add.php" method="get">
			<legend>Add new acronym with description!</legend>
			<div class="row">
				<?php
					if (isset($_SESSION['acronym_added']) && $_SESSION['acronym_added'] == 1) {
						echo "
						<div class='span8 bgcolor'>
							<div class='alert alert-success'>
							<a href='#' class='close' data-dismiss='alert'>×</a>
								The 2-tuple was added to the database.
							</div>
						</div>
						";
					} elseif (isset($_SESSION['acronym_added']) && $_SESSION['acronym_added'] == 0) {
						echo "
						<div class='span8 bgcolor'>
							<div class='alert alert-error'>
							<a href='#' class='close' data-dismiss='alert'>×</a>
								This 2-tuple is already in the database.
							</div>
						</div>
						";
					}
					$_SESSION['acronym_added'] = 2;
				?>
				<div class="span8">
					<div class="row">
						<div class="span2 lightblue">
							<input type="text" name="inEncoding" class="span2" placeholder="Abbreviation..">
						</div><!--/span-->
						<div class="span2 lightblue">
							<input type="text" name="inDescription" class="span2" placeholder="Description..">
						</div><!--/span-->
					</div>
				</div><!--/span-->
			</div><!--/row-->
			<button type="submit" class="btn btn-primary">Add!</button>
			</form>

			<form action="download.php" method="get">
			<legend>Download latest acronym database as CSV!</legend>
			<div class="row">
				<div class="span8">
					<div class="row">
						<div class="span2 lightblue">
							<label>Acronyms CSV</label>
							<input type="submit" value="Download!" class="btn btn-primary">
						</div><!--/span-->
					</div>
				</div><!--/span-->
			</div><!--/row-->
			</form>

			<form action="populate.php" method="post" enctype="multipart/form-data">
			<legend>Add list of acronyms with corresponding descriptions as CSV!</legend>
			<div class="row">
				<?php
					if (isset($_SESSION['acronyms_added']) && $_SESSION['acronyms_added'] == 2) {
						echo "
						<div class='span8 bgcolor'>
							<div class='alert alert-success'>
							<a href='#' class='close' data-dismiss='alert'>×</a>
								The 2-tuples from your csv file were added to the database.
							</div>
						</div>
						";
					} elseif (isset($_SESSION['acronyms_added']) && $_SESSION['acronyms_added'] == 1) {
						echo "
						<div class='span8 bgcolor'>
							<div class='alert alert'>
							<a href='#' class='close' data-dismiss='alert'>×</a>
								There was an error while uploading your file.
							</div>
						</div>
						";
					} elseif (isset($_SESSION['acronyms_added']) && $_SESSION['acronyms_added'] == 0) {
						echo "
						<div class='span8 bgcolor'>
							<div class='alert alert-error'>
							<a href='#' class='close' data-dismiss='alert'>×</a>
								You have provided a file of invalid type.
							</div>
						</div>
						";
					}
					$_SESSION['acronyms_added'] = 3;
				?>
				<div class="span8">
					<div class="row">
						<div class="span2 lightblue">
							<label>Upload File</label>
							<div class="fileupload fileupload-new" data-provides="fileupload">
								<div class="input-append">
									<div class="uneditable-input span2"><i class="icon-file fileupload-exists"></i> <span class="fileupload-preview"></span></div><span class="btn btn-file"><span class="fileupload-new">Select file</span><span class="fileupload-exists">Change</span><input type="file" name="file" id="file" /></span><a href="#" class="btn fileupload-exists" data-dismiss="fileupload">Remove</a>
								</div>
							</div>
						</div><!--/span-->
					</div>
				</div><!--/span-->
			</div><!--/row-->
			<button type="submit" class="btn btn-primary">Upload!</button>
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
		<script src="../js/bootstrap-fileupload.js"></script>

	</body>
</html>