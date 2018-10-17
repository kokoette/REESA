<?php require_once('../../private/initialize.php'); ?>
<?php

    if(!isset($_GET['stichwort'])) {
        redirect_to('../design_system/index.php');
    }

    $keywords   = '';
    $amety_ary  = [];

    $errors     = [];
    if(isset($_GET['stichwort'])) {
        $keywords = escape(trim($_GET['stichwort']));
        $suffix = '';


        if(empty($keywords)) {
            $errors[] = 'Please enter a search term';
        } elseif(strlen($keywords) < 3) {
            $errors[] = 'Your search term must be three or more characters';
        }

        if(empty($errors)) {
            //echo 'cool';
            $srch_obj = Property::search_propty($keywords);
            if($srch_obj !== false) {

                    $vals = '';
                    if(isset($_GET['stichwort'])) {
                        $vals = $_GET;

                        $sale_rent = $_GET['sale_rent'] ?? NULL;
                        $sale_rent = ($sale_rent != '') ? $sale_rent : NULL; 
                        
                        $state = $_GET['state'] ?? NULL;
                        $state = ($state != '') ? $state : NULL; 
                        
                        $amenities = $_GET['amenities'] ?? NULL;
                        $amenities = ($amenities != '') ? $amenities : NULL; 

                        foreach ($vals as $key => $value) {
                            if($value == '') {
                                unset($vals[$key]);
                            }
                        }
                                //pr($vals);

                        $alwd_stwrt = ['sale_rent'=>'sale_rent', 'state'=>'state', 'amenities'=>'amenities'];

                        $filtrd_vals = [];
                        foreach ($vals as $key => $value) {
                            if(in_array($key, $alwd_stwrt)) {
                                $filtrd_vals[$key] = $value; 
                            }
                        }

                        $amety_ary = explode(',', $amenities);

                        $search_array = [];
                        foreach ($srch_obj as $obj_keys => $in_src_status) {
                            $indicator = [];
                            foreach ($filtrd_vals as $key => $value) {
                                if(isset($in_src_status->$key)) {
                                    if($in_src_status->$key != $value) {
                                        $indicator[] = $in_src_status;
                                        unset($srch_obj[$obj_keys]);
                                    }                     
                                }
                            }
                        }
                    }    


            } 
        }
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Reesa - Search Listing</title>

    <link rel="stylesheet" href="../front_templated/css/bootstrap.min.css">
    <link rel="stylesheet" href="../front_templated/assets/css/main.css" />        
    <link rel="stylesheet" href="../front_templated/css/style.css">
    <link rel="stylesheet" href="../front_templated/css/main.css">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">
    <style>
        html, p, h1, h2, h3, h4, h5, h6, ul, li, a {
            font-family: "Segoe UI";
        }
        input[type="text"], input[type="password"], input[type="email"], input[type="tel"], input[type="search"], input[type="url"], select, textarea {
            color: #616161;
            background-color: #fff;
            border-radius: 4px;
            border: 0;
            border-bottom: 1px solid #bbb;
            -webkit-transition: 0.2s ease-in;
            -o-transition: 0.2s ease-in;
            transition: 0.3s ease-in;
        }

        input[type="checkbox"]:focus + label:before, input[type="radio"]:focus + label:before {
            border: 1px solid #bbb;
                box-shadow: 0 0 0 1px #bbb;
        }
        input[type="checkbox"] + label:before, input[type="radio"] + label:before {
            top: 2px;
            background-color: #fff;
            border: 0;
            box-shadow: 0 1px 2px rgba(50, 50, 93, .15), 0 1px 0 rgba(0, 0, 0, .02);
            line-height: 1.29875rem;           
        }
        input[type="checkbox"]:checked + label:before, input[type="radio"]:checked + label:before {
            background-color: #028ee1;
            border-color: #fff;
            color: #ffffff;
        }
        form {
            margin-bottom: 0;
        }
        select {
            cursor: pointer;
            height: 40px;
        }
        .srhTxtRw {
            /*-webkit-box-pack: center!important;
            -ms-flex-pack: center!important;
            justify-content: center!important;*/
        }
        @media (min-width: 992px) { 
            .clmnLft{
                max-width: 20% !important;
                flex: 0 0 20%;
            }
            .colmnRght {
                max-width: 80% !important;
                flex: 0 0 80%;
            }
        }
        .srhTxtRw .prfInpWrp {
            float: none;
        }
        .srhTxtRw .prfInpWrp input[type="text"] {
            height: 51px;
            margin-bottom: -3px;
            margin-left: 0;
        }
        .srhTxtRw .prfInpWrp button {
            background: transparent;
            position: absolute;
            top: 0;
            right: 11px;            
        }
        .srhTxtRw hr {
            border-bottom-color: rgba(0, 0, 0, 0.07);
            margin-top: 10px;
        }
        .srLstRit:before {
            border-left: solid 1px rgba(0, 0, 0, 0.16);
            content: '';
            display: block;
            height: 100%;
            left: -2px;
            position: absolute;
            top: 0rem;
            z-index: 999999;               
        }
        .srchSpn span {
            margin-right: 5px;
        }
    </style>

</head>

<body style="background-color: #eff1f5">



    <nav class="navbar navbar-expand-lg navbar-dark bg-dark probootstrap-navabr-dark">
        <div class="container" style="max-width: 1265px;">
          <a class="navbar-brand" href="../design_system/index.php">Reesa</a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#probootstrap-nav" aria-controls="probootstrap-nav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>

          <div class="collapse navbar-collapse" id="probootstrap-nav">

            <ul class="navbar-nav ml-auto">
              <li class="nav-item"><a href="index.html" class="nav-link">Home</a></li>
              <li class="nav-item"><a href="about.html" class="nav-link">About</a></li>
              <li class="nav-item"><a href="services.html" class="nav-link">Services</a></li>
              <li class="nav-item"><a href="contact.html" class="nav-link">Contact</a></li>
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
    
    <div class="container-fluid" style="margin-top: 20px; position: relative;">
        <?php echo display_errors($errors); ?>
        <div class="row srhTxtRw">
            <div class="col-md-12">
                <div class="col-md-6 prfInpWrp dataTables_filter">
                    <form action="" method="get">
                        <p>
                            <input id="name" type="text" value="<?php echo $keywords; ?>" name="stichwort">
                            <button type="submit" value="Search" id="name_submit">
                                <i class="fa fa-search" aria-hidden="true"></i>
                            </button>
                        </p>
                    </form>
                </div>
                <div class="col-md-12 srchSpn">
                    <?php
                        if(isset($filtrd_vals) && !empty($filtrd_vals)) {
                            foreach ($filtrd_vals as $key=>$fild_val) {
                                if($key == 'amenities') {
                                    foreach ($amety_ary as $amety) {
                                        echo '<span class="badge badge-info">'. $amety .'</span>';
                                    }
                                }
                                if($key == 'amenities') {
                                    continue;
                                }
                                echo '<span class="badge badge-info">'. $fild_val .'</span>';
                            }
                        }
                    ?>
                    <span>&nbsp;</span>
                </div>
                <hr>
            </div>
        </div>
        <div class="row srhBxWrp">
            <div class="col-md-5 srchBox">
                <p>
                    <?php
                    if(!empty($srch_obj)) {
                        $result_num = count($srch_obj);
                        $suffix = ($result_num !=1) ? 's' : '';
                        if(isset($result_num)) {
                            if($result_num>0){
                                echo 'Your search for <b>'. $keywords .'</b> returned '.$result_num.' result'.$suffix;
                            }
                        }
                    } 
                    ?>           
                </p>
            </div>
            <div class="col-md-7" style="text-align: right;">
                Sort by
                <select style="display: inline; width: 40%; margin-left: 10px;">
                    <option>Default</option>
                </select>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-3 clmnLft">
                <div class="col-md-12 srLtCrta" style="margin-top: 20px;">
                    <div class="form-group">
                        <input type="radio" id="sale" value="sale" class="sale_rent" name="sale_rent[]"
                        <?php if(isset($_GET['sale_rent'])){if($_GET['sale_rent'] == 'sale') {echo 'checked';}}?>
                        > 
                        <label for="sale">Sale</label>

                        <input type="radio" id="rent" value="rent" class="sale_rent" name="sale_rent[]"
                        <?php if(isset($_GET['sale_rent'])){if($_GET['sale_rent'] == 'rent') {echo 'checked';}}?>
                        > 
                        <label for="rent">Rent</label>
                    </div>
                    <div class="form-group">
                        <select name="state" class="state">
                            <option value="">Select state</option>
                            <option value="anambra"
                            <?php if(isset($_GET['state'])) {if($_GET['state'] == 'anambra') {echo 'selected';}}?>
                            >Anambra</option>

                            <option value="oka_spelt_wrong"
                            <?php if(isset($_GET['state'])) {if($_GET['state'] == 'oka') {echo 'selected';}}?>
                            >oka_spelt_wrong</option>

                            <option value="lagos"
                            <?php if(isset($_GET['state'])) {if($_GET['state'] == 'lagos') {echo 'selected';}}?>
                            >lagos</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="elec" value="electricity" class="amenity" name="amenities[]" <?php if(in_array('electricity', $amety_ary)) { echo 'checked';} ?>> 
                        <label for="elec">Electricity</label>
                        
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="wota" value="water" class="amenity" name="amenities[]" <?php if(in_array('water', $amety_ary)) { echo 'checked';} ?>> 
                        <label for="wota">Running Water</label>
                        
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="furnished" value="furnished" class="amenity" name="amenities[]" <?php if(in_array('furnished', $amety_ary)) { echo 'checked';} ?>> 
                        <label for="furnished">Furnished</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="garage" value="garage" class="amenity" name="amenities[]" <?php if(in_array('garage', $amety_ary)) { echo 'checked';} ?>> 
                        <label for="garage">Garage</label>
                    </div>
                    <div class="form-group">
                        <input type="checkbox" id="deck" value="balcony" class="amenity" name="amenities[]" <?php if(in_array('balcony', $amety_ary)) { echo 'checked';} ?>> 
                        <label for="deck">Balcony/Deck</label>
                    </div>
                </div>
            </div>
            <div class="col-lg-9 colmnRght srLstRit">

                <?php 
                if(!empty($srch_obj)) {

                    foreach ($srch_obj as $search_result) {
                ?>

                    <div class="row srRltWrp">
                            <div class="col-md-3 srLtImg" style="padding: 0">
                                <img style="" src='../backend/images/lister/<?php if($search_result->display != ''){echo $search_result->id.'/'.$search_result->display;}else{echo 'placeholder.png';}?>'>  
                            </div>
                        	<div class="col-md-5 g sLQlt">
                        		<div> <a href="../front_templated/view.php?liebe=<?php echo $search_result->id; ?>&eup=rsano3/listing/gs_l=16_erwidern_dreal+soluop=thisell/p350"><h4><?php echo $search_result->address; ?></h4></a> </div>
                        		<div><p><i class="fa fa-map-marker"></i> <?php echo $search_result->state; ?></p> </div>
                        		<div class="row sLFts">
                        			<div class="col-sm-5 ">
                        				<div class="b srArea">
                	        				<div><i class="fa fa-crop e"></i></div>
                	        				<div class="f">Area <br/> <?php echo $search_result->area; ?> <small>SQ FT</small></div>        					
                        				</div>
                        				<div class="b">
                	        				<div><i class="fa fa-bed e"></i></div>
                	        				<div class="f">Beds <br/> <?php echo $search_result->bed; ?></div>        					
                        				</div>
                        				<div class="b">
                	        				<div><i class="fa fa-bath e"></i></div>
                	        				<div class="f">Bathroom <br/> <?php echo $search_result->bath; ?> </div>        					
                        				</div>
                        			</div>
                        			
                        			<div class="col-sm-5">
                        				<div class="b">
                	        				<div><i class="fa fa-crop e"></i></div>
                	        				<div class="f">Area <br/> <?php echo $search_result->area; ?></div>        					
                        				</div>
                        				<div class="b">
                	        				<div><i class="fa fa-tag e"></i></div>
                	        				<div class="f">For <br/><?php echo $search_result->sale_rent; ?></div>        					
                        				</div>
                        			</div>
                        		</div>
                        	</div>
                        	<div class="col-md-4 slDesWp">
                        		<h3>Description</h3>
                        		<p style=""><?php echo $search_result->description; ?> ...</p>
                        		<h4>PRICE</h4>
                        		<h1 style="">N<?php echo number_format($search_result->price, 2, '.', ','); ?></h1>
                                <a class="slRdMr btn btn-info m-b-10 m-l-5 btn-block" href="../front_templated/view.php?liebe=<?php echo $search_result->id; ?>&eup=rsano3/listing/gs_l=16_erwidern_dreal+soluop=thisell/p350">READ MORE &nbsp; <i class="fa fa-terminal"></i></a>
                            </div>
                    </div>

                <?php
                    }
                } else {
                    echo 'Your search for <b><i>'. $keywords .'</i></b> returned no results';
                }
                ?>

            </div>
        </div>
    </div>

    <?php include("../admin_master/includes/front_footer.php"); ?>


<script src="js/lib/jquery/jquery.min.js"></script>
<script src="js/custom_script.js"></script>
<script src="js/lib/bootstrap/js/bootstrap.min.js"></script>
<script src="js/lib/bootstrap/js/popper.min.js"></script>

</body>
</html>
