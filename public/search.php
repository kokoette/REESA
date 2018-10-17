<?php require_once('../../private/initialize.php'); 

pr($_SESSION);
//all no trans_details, no status, no draft
?>

<!DOCTYPE html>
<html>
<head>
	<title>Test</title>
	<link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
	<style> body{font-family: verdana; font-size: smaller;} .wrap{clear: both;}
		.a{float: left;} .b{float: left; width: 240px; padding-left: 30px;} .c{float: left; background-color: #10bbe8; width: 235px; height: 312px; padding-left: 30px; margin-left: 20px;}
		.d{color: #0783c2;} .e{color: #fff;} .f{font-weight: 400; margin-top: 70px;margin-bottom: 0; color: #ffffffa6;} .g{margin-top: 6px; color: #fff;} .h{color: #f7f7f7d9; font-size: 12px; display: block; background-color: #079cd7; padding: 10px; width: 100px; text-decoration: none;} .j{margin: 0 auto;width: 900px;}

			input {
			    background-color: transparent;
			    background-image: linear-gradient(#1976d2, #1976d2), linear-gradient(#b1b8bb, #b1b8bb);
			    background-position: center bottom, center calc(99%);
			    background-repeat: no-repeat;
			    background-size: 0 2px, 100% 1px;
			    border: 0 none;
			    border-radius: 0;
			    box-shadow: none;
			    float: none;
			    margin-left: 10px;
			    transition: background 0s ease-out 0s;
			}
			input:focus {
			    background-image: linear-gradient(#1976d2, #1976d2), linear-gradient(#b1b8bb, #b1b8bb);
			    background-size: 100% 2px, 100% 1px;
			    box-shadow: none;
			    outline: medium none;
			    transition-duration: 0.3s;
			}
	</style>
</head>
<body>

	<div class="j">


<input type="text" name="">
<br>
<br>

		<?php 

			$properties = Property::find_all();


			foreach ($properties as $property) {
				//------here
		?>

		<div class="wrap">
			<div class="a">
				<img src="../backend/lister/images/homesamp2.gif">
			</div>
			<div class="b">
				<h3><?php echo $property->address; ?></h3>
				<div>
					<div style="float: left;">
						<p>
							Area:<br />
							<?php echo $property->area; ?> sqFt
						</p>
						<p>
							Bathrooms: <br />
							<?php echo $property->bath; ?>
						</p>
					</div>
					<div style="padding-left: 50px; float: left;">
						<p>
							Bedrooms: <br />
							<?php echo $property->bed; ?>
						</p>
						<p>
							Status: <br />
							For Sale
						</p>
					</div>
				</div>
			</div>
			<div class="c">
				<h3 class="d">Description</h3>
				<p class="e"><?php echo $property->description; ?></p>
				<h3 class="f">PRICE</h3>
				<h2 class="g">$<?php echo $property->price; ?></h2>
				<a class="h" href="../../private/send_request.php?psy=<?php echo $property->id; ?>">Buy Now ></a>
			</div>
			<div style="clear: both;"></div>
		</div>


		<?php
			}

		?>
	</div>

    <script src="js/lib/jquery/jquery.min.js"></script>
    <!-- Bootstrap tether Core JavaScript -->
    <script src="js/lib/bootstrap/js/popper.min.js"></script>
    <script src="js/lib/bootstrap/js/bootstrap.min.js"></script>

</body>
</html>
<?php
$database->close();
?>