<?php
require_once('../../private/initialize.php'); 

if($session->is_logged_in()) {
  redirect_to('../admin_master/index.php');
}

if(is_post_request()) {
  $args = [];
  $args['full_name'] = $_POST['val-username'] ?? NULL;
  $args['email'] = strtolower($_POST['val-email']) ?? NULL;
  $args['phone'] = $_POST['val-phone'] ?? NULL;
  $args['address'] = $_POST['val-address'] ?? NULL;
  $args['password'] = $_POST['val-password'] ?? NULL;
  $args['confirm_password'] = $_POST['val-confirm-password'] ?? NULL;
  $args['role_id'] = $_POST['val-role'] ?? NULL;

  $system_user = new SystemUsers($args);
  $result = $system_user->create();
  if($result === true) {
    $session->message('Registered successfully check email for validation link');
    
    // $session->login($system_user->id);    
    $_SESSION['wlcm_msg'] = $system_user->id;
    
    redirect_to('login.php');
  }


} else {
  $system_user = new SystemUsers;
}

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="Reesa">
  <meta name="author" content="Reesa">
  <title>Register</title>
  <link href="images/favicon.png" rel="icon" type="image/png">
  
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet">
  <link href="assets/vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet">
  
  <link type="text/css" href="css/bootstrap.min.css" rel="stylesheet">
  <link type="text/css" href="css/main_light.css" rel="stylesheet">
  <link href="css/validate.css" rel="stylesheet">

  <link type="text/css" href="assets/css/argon.css?v=1.0.1" rel="stylesheet">
  <link type="text/css" href="assets/css/docs.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/main.css">
  <style>
    html, p, h1, h2, h3, h4, h5, h6, ul, li, a {
      font-family: "Segoe UI";
    }    
  </style>  
</head>

<body>

  <form class="frmSrc" action="../admin_master/search_list.php" method="post" style="margin :0">
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark probootstrap-navabr-dark"  style="background: #462b94 !important;">
        <div class="container" style="max-width: 1265px;">
          <a class="navbar-brand" href="../design_system/index.php">Reesa</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#probootstrap-nav" aria-controls="probootstrap-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="probootstrap-nav">

               <div class="hmSrcWrp">
                <input type="text" class="hmSrcTxt search_nav" style="background-color: #fff;border: 0;height: 2.7rem;" placeholder="STATE, CITY, ADDRESS"  name="stichwort">
                  <button type="submit" class="hmSrcBtn" class="input-search-btn">
                    <i style="margin-top: 1px;" class="fa fa-search"></i>
                  </button>
                </div>

            <ul class="navbar-nav ml-auto">
              <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
              <!-- <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
              <li class="nav-item"><a href="services.html" class="nav-link">Services</a></li>
              <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li> -->
              <li class="nav-item"><a href="faq.php" class="nav-link">FAQs</a></li>
              <li class="nav-item probootstrap-cta probootstrap-seperator"><a href="register.php" class="nav-link">Sign up</a></li>
              <li class="nav-item probootstrap-cta"><a href="login.php" class="nav-link">Log In</a></li>
            </ul>
           
          </div>
        </div>
    </nav>
  </form>

  <main>
    <section class="section section-shaped pt-5">
      <div class="shape shape-style-1 bg-gradient-default">
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
        <span></span>
      </div>
      <div class="container">
        <div class="row justify-content-center">
          
          <div class="col-lg-6">
            <div class="card bg-secondary shadow border-0">
              <form class="form-valide" action="" method="post" role="form">

                <div class="card-header bg-white pb-3">
                  <div class="text-muted text-center mb-3">
                    <h3 class="display-3"><small>Sign up with credentials</small></h3>
                  </div>
                  <div class="form-group text-center">
                    <div class="col-md-12">

                      <select name="val-role" class="btn btn-neutral btn-icon reSlctRl">
                          <option value="">Select role</option>
                          <option value="2" <?php echo ($system_user->role_id == 2) ? 'selected':'' ; ?>>Lister (Property Owner)</option>
                          <option value="3" <?php echo ($system_user->role_id == 3) ? 'selected':'' ; ?>>Buyer (Searching)</option>
                      </select>
                    
                    </div>
                  </div>
                </div>
                <div class="card-body px-lg-5 py-lg-4">
                  
                  <?php echo display_errors($system_user->errors); ?>

                    <div class="form-group">
                      <div class="col-md-12">
                        <input type="text" name="val-username" class="form-control form-control-alternative" value="<?php echo escape($system_user->full_name); ?>" placeholder="Full name *">
                        </div>
                    </div>

                    <div class="form-group">
                      <div class="col-md-12">
                        <input type="email" name="val-email" class="form-control form-control-alternative" value="<?php echo escape($system_user->email); ?>" placeholder="Email *">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <input type="text" name="val-phone" class="form-control form-control-alternative" value="<?php echo escape($system_user->phone); ?>" placeholder="Phone *">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <input type="text" name="val-address" class="form-control form-control-alternative" value="<?php echo escape($system_user->address); ?>" placeholder="Address *">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <input type="password" name="val-password"  id="val-password" class="form-control form-control-alternative" placeholder="Password *">
                      </div>
                    </div>
                    <div class="form-group">
                      <div class="col-md-12">
                        <input type="password" name="val-confirm-password" class="form-control form-control-alternative" placeholder="Password again *">
                      </div>
                    </div>                  

                    <div class="form-group row my-4">
                      <div class="col-12">
                        <div class="custom-control custom-control-alternative custom-checkbox">
                          <input class="custom-control-input" name="val-terms" id="customCheckRegister" type="checkbox">
                          <label class="custom-control-label" for="customCheckRegister">
                            <span>I agree with the
                              <a href="#">Service Terms</a>
                            </span>
                          </label>
                        </div>
                      </div>
                    </div>
                    <div class="text-center">
                      <button type="submit" class="btn btn-primary mt-4">Create account</button>
                    </div>                  
                </div>

              </form>  
            </div>
          </div>

        </div>
      </div>
    </section>
  </main>

  <footer id="footer">
    <div class="inner">
        <div class="content">
            <section>
                <h3>About Reesa</h3>
                <p>© Reesa - a product of Masterpiece Capital Limited is registered with the Special Control Unit on Money Laundering (SCUML), an arm of the Economic and Financial Crimes Commission (EFCC). © Reesa is domiciled in Zenith Bank Plc – a financial institution insured by the Nigeria Deposit Insurance Corporation (NDIC) - an independent financial agency of the Federal Government of Nigeria.</p>
            </section>
            <section>
                <h4>Contact</h4>
                <ul class="alt">
                  <li><i class="icon fa-envelope">&nbsp;</i>info@reesa.com</li>
                  <li><i class="icon fa-phone">&nbsp;</i>+234 (0) 705 595 0801</li>
                  <li><i class="icon fa-map-marker">&nbsp;</i>29, Mambilla Street, Aso Drive, Maitama, Abuja</li>
                  <!-- <li><a href="#">Dolor pulvinar magna etiam.</a></li> -->
                </ul>
            </section>
            <section>
                <h4>Social Media</h4>
                <ul class="plain">
                    <li><a href="https://www.twitter.com/reesanigeria"><i class="icon fa-twitter">&nbsp;</i>Twitter</a></li>
                    <li><a href="https://www.facebook.com/reesanigeria"><i class="icon fa-facebook">&nbsp;</i>Facebook</a></li>
                    <li><a href="https://www.instagram.com/reesanigeria"><i class="icon fa-instagram">&nbsp;</i>Instagram</a></li>
                    <!-- <li><a href="#"><i class="icon fa-github">&nbsp;</i>Github</a></li> -->
                </ul>
            </section>
        </div>
        <div class="copyright">
            &copy; Reesa. All rights reserved. <a href="privacy.php">Privacy Policy</a> | <a href="#">Terms & Condition</a>
        </div>
    </div>
  </footer>
  
  <!-- Core -->
  <script src="assets/vendor/jquery/jquery.min.js"></script>
  <script src="assets/vendor/popper/popper.min.js"></script>
  <script src="assets/vendor/bootstrap/bootstrap.min.js"></script>
  <script src="assets/vendor/headroom/headroom.min.js"></script>
  <!-- Argon JS -->
  <script src="assets/js/argon.js?v=1.0.1"></script>

  <script src="js/validate/jquery.validate.min.js"></script>
  <script src="js/validate/jquery.validate-init.js"></script>
</body>

</html>