<?php require_once('../../private/initialize.php'); 

$ft_propties = Property::find_featured();


?>
<!DOCTYPE HTML>
<html>
	<head>
		<title>Reesa</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
		<meta name="description" content="" />
		<meta name="keywords" content="" />
	    <meta name="Reesa" content="" />
    	<link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">

	    <link rel="stylesheet" href="css/bootstrap.min.css">
		<link rel="stylesheet" href="assets/css/main.css" />		
	    <link rel="stylesheet" href="css/open-iconic-bootstrap.min.css">
	    <link rel="stylesheet" href="css/icomoon.css">
	    <link rel="stylesheet" href="css/style.css">

	    <!-- Custom -->
	    <link rel="stylesheet" href="css/main.css">
	</head>

	<body class="is-preload">


   	<?php 
   	$home_link = 'index.php';
   	include("../admin_master/includes/front_header.php"); ?>


     
    <section class="probootstrap-cover">
      <div class="container">
        <div class="row probootstrap-vh-85 align-items-center text-center">
          <div class="col-sm">
            <div class="probootstrap-text">
              <h1 class="probootstrap-heading text-white mb-4">Reesa 4 for everyone.</h1>
              <div class="probootstrap-subheading mb-5">
                <p class="h4 font-weight-normal">Buy Now pay later</p>
              </div>
              <p><a href="register.php" class="btn btn-primary mr-2 mb-2">Start Saving</a>
              	<a href="register.php" class="btn btn-primary btn-outline-white mb-2">Start Listing</a>
              </p>
            </div>
          </div>
        </div>
      </div>
    </section>




		<!-- Highlights -->
			<section class="probootstrap-section" style="padding: 4em 0">
				<header class="special" style="margin-bottom: 0">
					<h2>Featured Listings</h2>
				</header>
				<div class="container">

					<div class="row" style="background: #f7fdfa;padding: 3rem;padding-left: 0;margin-left: 0; padding-top: 0;">

						<?php
						foreach ($ft_propties as $ft_property) {
						?>

						<div class="col-md-4" style="margin-top: 3rem;">
							<div class="card" style="border-radius: 6px; border: none;">	
								<img style="border-top-left-radius: 6px;border-top-right-radius: 6px;" class="img-fluid" src='../backend/images/lister/<?php if($ft_property->display != ''){echo $ft_property->id.'/'.$ft_property->display;}else{echo 'placeholder.png';}?>'>
								<div style="position: relative;top: -25px;background-color: #fff;width: 93%;margin: 0 auto;padding: 13px;border-radius: 5px;padding-bottom: 5px;">
									<h3 style="margin-bottom: 10px;">N<?php echo $ft_property->price; ?></h3>
									<div style="padding: 0" class="container">
										<div style="margin-left: 0; font-size: 95%;" class="row">
											<div style="padding-left: 0;max-width: 20%;" class="col-md-3"><i class="fa fa-bed"></i> <?php echo $ft_property->bed; ?>bd</div>
											<div style="padding-left: 0;max-width: 19%;" class="col-md-3"><i style="margin-right: 4px;" class="fa fa-bath"></i><?php echo $ft_property->bath; ?>ba</div>
											<div style="padding-left: 1px;max-width: 26%;" class="col-md-4"><i style="margin-right: 4px;" class="fa fa-crop"></i><?php echo $ft_property->area; ?></div>
											<div style="padding-left: 5px;" class="col-md-4"><i style="margin-right: 4px;" class="fa fa-tag"></i>For Sale</div>
										</div>
									</div>
									<p><?php echo $ft_property->address; ?></p>
									<a style='padding: 10px 15px;border-radius: 4px;font-family:"Segoe UI"; letter-spacing: 3px; font-weight: 500; ' href="../front_templated/view.php?liebe=<?php echo $ft_property->id; ?>&eup=rsano3/listing/gs_l=16_erwidern_dreal+soluop=thisell/p350" class="btn btn-primary">Read more</a>
								</div>
							</div>
						</div>

						<?php
						}
						?>

					</div>
				</div>
			</section>


			<section class="probootstrap-section" style="margin-bottom: 14px;padding: 4em 0; background: #fff;">
				
				<div class="container">
					<header class="special" style="margin-bottom: 0">
						<h2>HOW TO LIST</h2>
					</header>
					<div class="row" style="text-align: center;">
						<div class="col-md-4">
							<span class="icon-users display-4" style="color: #28CC9E;"></span>
							<h5 class="mt-0">For The Community</h5>
							<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
						</div>
						<div class="col-md-4">
							<span class="icon-fingerprint display-4" style="color: #28CC9E;"></span>
							<h5 class="mt-0">For The Community</h5>
							<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
						</div>

						<div class="col-md-4">
							<span class="icon-chat display-4" style="color: #28CC9E;"></span>
							<h5 class="mt-0">For The Community</h5>
							<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
						</div>
					</div>
				</div>
			</section>
			<section class="probootstrap-section" style="padding: 4em 0; background: #fff;">
				
				<div class="container">
					<header class="special" style="margin-bottom: 0">
						<h2>HOW TO BUY</h2>
					</header>
					<div class="row" style="text-align: center;">
						<div class="col-md-4">
							<span class="icon-users display-4" style="color: #28CC9E;"></span>
							<h5 class="mt-0">For The Community</h5>
							<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
						</div>
						<div class="col-md-4">
							<span class="icon-fingerprint display-4" style="color: #28CC9E;"></span>
							<h5 class="mt-0">For The Community</h5>
							<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
						</div>
						<div class="col-md-4">
							<span class="icon-chat display-4" style="color: #28CC9E;"></span>
							<h5 class="mt-0">For The Community</h5>
							<p>Far far away, behind the word mountains, far from the countries Vokalia and Consonantia, there live the blind texts.</p>
						</div>
					</div>
				</div>
			</section>


		<!-- CTA -->
			<section id="cta" class="wrapper">
				<div class="inner">
					<h2>AT REESA ACHIEVE DREAM ... MONEY SAVED, MONEY SAFE ...</h2>
				</div>
			</section>

		<!-- Testimonials -->
			<section class="wrapper">
				<div class="inner">
					<header class="special">
						<h2>WHAT THEY SAY... TESTIMONIAL</h2>
					</header>
					<div class="testimonials">
						<section>
							<div class="content">
								<blockquote>
									<p>I am already saving to renew my next year’s rent without stress. This is such a brilliant solution. Thanks Reesa.</p>
								</blockquote>
								<div class="author">
									<div class="image">
										<!-- <img src="images/pic01.jpg" alt="" /> -->
									</div>
									<p class="credit">- <strong>Ezinne Anyanuwu</strong></p>
								</div>
							</div>
						</section>
						<section>
							<div class="content">
								<blockquote>
									<p>Amazing app! I am saving towards building my personal house and the build-for-me option just works for me.</p>
								</blockquote>
								<div class="author">
									<div class="image">
										<!-- <img src="images/pic03.jpg" alt="" /> -->
									</div>
									<p class="credit">- <strong>Edward Amana</strong></p>
								</div>
							</div>
						</section>
						<section>
							<div class="content">
								<blockquote>
									<p>I listed my current development and I have had a surge in the number of enquiries and site visits in just one week. This is the next big thing for us developers.</p>
								</blockquote>
								<div class="author">
									<div class="image">
										<!-- <img src="images/pic02.jpg" alt="" /> -->
									</div>
									<p class="credit">- <strong>Kennedy Okoli</strong></p>
								</div>
							</div>
						</section>
					</div>
				</div>
			</section>

		<!-- Footer -->
   		<?php include("../admin_master/includes/front_footer.php"); ?>
        <!-- Scripts -->
            <script src="assets/js/jquery.min.js"></script>
            <script src="assets/js/browser.min.js"></script>
            <script src="assets/js/breakpoints.min.js"></script>
            <script src="assets/js/util.js"></script>
            <script src="assets/js/main.js"></script>

            <script src="js/jquery-3.2.1.slim.min.js"></script>
            <script src="js/popper.min.js"></script>
            <script src="js/bootstrap.min.js"></script>
            <script src="js/main.js"></script>          
            <script type="text/javascript">
                $('.pflPcNav').click(function() {
                    window.location = '../admin_master/index.php';
                });
            </script>
	</body>
</html>