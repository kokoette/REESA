<?php
  if(!isset($login_link, $sign_up_link)) {
    $login_link = 'login.php';
    $sign_up_link = 'register.php';
  }
?>
    <form class="frmSrc" action="../admin_master/search_list.php" method="get">
      <nav class="navbar navbar-expand-lg navbar-dark bg-dark probootstrap-navabr-dark">
          <div class="container" style="max-width: 1265px;">
            <a class="navbar-brand" href="<?php echo $home_link;?>">Reesa</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#probootstrap-nav" aria-controls="probootstrap-nav" aria-expanded="false" aria-label="Toggle navigation">
              <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="probootstrap-nav">
              
              <div class="hmSrcWrp">
              <input type="text" class="hmSrcTxt" style="background-color: #fff;border: 0;height: 2.7rem;" placeholder="STATE, CITY, ADDRESS"  name="stichwort">
                <button type="submit" class="hmSrcBtn" class="input-search-btn">
                  <i class="fa fa-search"></i>
                </button>
              </div>
              
              <ul class="navbar-nav ml-auto">
                <li class="nav-item"><a href="index.php" class="nav-link">Home</a></li>
                <!-- <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
                <li class="nav-item"><a href="services.html" class="nav-link">Services</a></li> -->
                <li class="nav-item"><a href="faq.php" class="nav-link">FAQs</a></li>
                
            <?php
            if($session->is_logged_in()) {
              echo '
              <li class="nav-item frnt_profl"><a class="pflPcNav" href="../admin_master/index.php" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">';

              if($_SESSION['profile'] != '') { echo '<img class="profile-pic prflPcImg" src="../backend/images/profile/'.$_SESSION['profile'].'">'; } else {echo '<i class="fa fa-user-circle-o"></i>';}

              echo '</a></li><li class="nav-item frnPrli"><a href="../admin_master/index.php" class="nav-link">Welcome '. $_SESSION['full_name'].'</a></li>';
            } else {
            ?>
                <li class="nav-item probootstrap-cta probootstrap-seperator"><a href="<?php echo $sign_up_link; ?>" class="nav-link">Sign up</a></li>
                <li class="nav-item probootstrap-cta"><a href="<?php echo $login_link; ?>" class="nav-link">Log In</a></li>
            <?php
            }

            ?>

              </ul>
             
            </div>
          </div>
      </nav>
    </form>