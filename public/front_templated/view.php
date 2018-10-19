<?php 
    require_once('../../private/initialize.php');

    if(!isset($_GET['liebe'])) {
        redirect_to('../design_system/index.php');
    }
    $prp_vw_id = $_GET['liebe'];
    $vw_prp = Property::use_find_id($prp_vw_id);
    $propty_imgs = PropertyImages::get_property_images($vw_prp->id);

    if($vw_prp === false || ($vw_prp->status != '' && $vw_prp->lister_id != $_SESSION['sys_user_id']) ) {
        redirect_to('../design_system/index.php');
    }

    $lstr_info = SystemUsers::find_by_id($vw_prp->lister_id);


    if(isset($_SESSION['recent_view']) && !is_array($_SESSION['recent_view'])) {
        $_SESSION['recent_view'] = [];

    } elseif(!isset($_SESSION['recent_view'])) {
        $_SESSION['recent_view'] = [];

    }

    $rcnt_vw_ses = $_SESSION['recent_view'];
    $rcnt_vw_ses = array_shift($rcnt_vw_ses);
    if($rcnt_vw_ses != $prp_vw_id) {
        array_unshift($_SESSION['recent_view'], $_GET['liebe']);
    }


    if(count($_SESSION['recent_view']) > 3) {
        array_pop($_SESSION['recent_view']);
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <title>Reesa - View Property</title>
    <link rel="icon" type="image/png" sizes="16x16" href="../admin_master/images/favicon.png">

        <link rel="stylesheet" href="css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/main.css" />        
        <link rel="stylesheet" href="css/style.css">
        <link type="text/css" rel="stylesheet" href="css/lightslider.css" />                  

        <!-- Custom CSS -->
        <link href="../admin_master/css/helper.css" rel="stylesheet">
        <link href="../admin_master/css/style.css" rel="stylesheet">        

        <!-- MiMain -->
        <link rel="stylesheet" href="css/main.css">
        <link rel="stylesheet" href="../design_system/css/main.css">
        <link rel="stylesheet" href="../admin_master/css/main.css" >

        <script src="../admin_master/js/lib/jquery/jquery.min.js"></script>
        <script src="js/lightslider.js"></script>
        <script type="text/javascript">
            $(document).ready(function() {
            $('#imageGallery').lightSlider({
                gallery:true,
                item:1,
                loop:false,
                thumbItem:9,
                slideMargin:0,
                enableDrag: true,
                currentPagerPosition:'left',
                onSliderLoad: function(el) {
                    el.lightGallery({
                        selector: '#imageGallery .lslide'
                    });
                }   
            });  
          });
        </script>

        <!-- <link href="../admin_master/css/style.css" rel="stylesheet"> -->
    <style>
        html, p, h1, h2, h3, h4, h5, h6, ul, li, a {
            font-family: "Segoe UI";
        }
        .card.wlcmWrp {
            right: 76%;
        }
        .wlcmTp p {
            margin-bottom: 0;
        }
        .wlCBNxt a {
            padding: 10px 23px;
            margin-right: 30px;
            border: none;
        }
        .vwImGWrp {

        }
    </style>
</head>

<body>


    <?php 
    $home_link = '../design_system/index.php';
    $login_link = '../design_system/login.php';
    $sign_up_link = '../design_system/register.php';
    include("../admin_master/includes/front_header.php"); ?>
    


    <div class="container">
        <div class="row view_row_wrp">
            <div class="col-md-8">
                <h1 class="view_titl">
                    <?php 
                        echo $vw_prp->address;
                        if(isset($_SESSION['sys_user_id'])) {
                            echo ($vw_prp->lister_id == $_SESSION['sys_user_id']) ? '<a href="../admin_master/edit_property.php?psy='. $vw_prp->id .'&eup=rsano3/listing/gs_l=16d"><i class="fa fa-edit" data-toggle="tooltip" data-placement="right" title="Edit"></i></a>':''; 
                        } 
                    ?>  
                </h1>
                <div class="row a m-b-15 m-t-7">
                    <div class="col-lg-4 vw_mn_prc">
                        <h2 class="f-s-32">N<?php echo number_format($vw_prp->price, 2, '.', ','); ?></h2>
                    </div>
                    <div class="col-lg-8 vw_mn_prpt">
                        <div class="row">
                            <?php $bd_sufx = ($vw_prp->bed == 1) ? '' : 's' ; ?>
                            <div><i class="fa fa-bed"></i><?php echo $vw_prp->bed. ' Bedroom'.$bd_sufx; ?></div>
                            <?php $suffix = ($vw_prp->bath == 1) ? '' : 's' ; ?>
                            <div><i class="fa fa-bath"></i><?php echo $vw_prp->bath.' Bathroom'.$suffix; ?></div>
                            <div><i class="fa fa-cog"></i>3 Receptions</div>
                            <div><i class="fa fa-tag"></i><?php echo $vw_prp->state; ?></div>
                        </div>
                        
                    </div>
                </div>
                <div class="row vwImGry">
                    <div class="col-md-12">
                        <div class="card p-0 m-t-0 m-b-0">
                            <div class="card-body p-b-0">
                                <!-- Nav tabs -->
                                <ul class="nav nav-tabs customtab" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active" data-toggle="tab" href="#home2" role="tab"><span class="hidden-sm-up"><i class="ti-home"></i></span> 
                                        <span class="hidden-xs-down">Overview</span></a> 
                                    </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#profile2" role="tab"><span class="hidden-sm-up"><i class="ti-user"></i></span> 
                                        <span class="hidden-xs-down"><i class="fa fa-map-marker"></i> Map</span></a> 
                                    </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#messages2" role="tab"><span class="hidden-sm-up"><i class="ti-email"></i></span> 
                                        <span class="hidden-xs-down">Floorplan</span></a> 
                                    </li>
                                </ul>
                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="home2" role="tabpanel">
                                        <div class="p-t-20">

                                            <div class="col-md-12 p-l-0 p-r-0">

                                                <div class="vwImGWrp">
                                                    <ul id="imageGallery">

                                                      <li data-thumb="../backend/images/lister/<?php if($vw_prp->display != ''){echo $vw_prp->id.'/'.$vw_prp->display;}else{echo 'placeholder.png';}?>" data-src="../backend/images/lister/<?php if($vw_prp->display != ''){echo $vw_prp->id.'/'.$vw_prp->display;}else{echo 'placeholder.png';}?>">
                                                        <img src="../backend/images/lister/<?php if($vw_prp->display != ''){echo $vw_prp->id.'/'.$vw_prp->display;}else{echo 'placeholder.png';}?>" />
                                                      </li>

                                                <?php
                                                if($propty_imgs) {
                                                    foreach($propty_imgs as $propty_img) {
                                                        $img_ext = $propty_img->id.'.'.$propty_img->ext;
                                                        if($vw_prp->display == $img_ext) {
                                                            continue;
                                                        }
                                                    ?>
                                                      <li data-thumb="../backend/images/lister/<?php echo $propty_img->property_id.'/'.$propty_img->id.'.'.$propty_img->ext;?>" data-src="../backend/images/lister/<?php echo $propty_img->property_id.'/'.$propty_img->id.'.'.$propty_img->ext;?>">
                                                        <img src="../backend/images/lister/<?php echo $propty_img->property_id.'/'.$propty_img->id.'.'.$propty_img->ext;?>" />
                                                      </li>
                                                    <?php
                                                    }
                                                }
                                                ?>
                                                    </ul>
                                                </div>


                                            </div>


                                        </div>
                                    </div>
                                    <div class="tab-pane  p-20" id="profile2" role="tabpanel">No Google Map</div>
                                    <div class="tab-pane p-20" id="messages2" role="tabpanel">No Floor plan</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>



                <div class="row vw_ft_sm">
                    <div class="col-md-6">
                        <ul class="vFS_ul">
                            <li><i class="fa fa-circle"></i> Property type: Apartment</li>
                            <li><i class="fa fa-circle"></i><?php echo $vw_prp->bed.' Bedroom'.$bd_sufx;?></li>
                            <li><i class="fa fa-circle"></i><?php echo number_format($vw_prp->area);?> Sq. Ft</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <ul class="vFS_ul">
                            <li><i class="fa fa-circle"></i>Property Size</li>
                            <li><i class="fa fa-circle"></i></i>Ref No. SUP172391</li>
                        </ul>
                    </div>
                </div>
                <div class="row vw_dscrp m-t-20">
                    <div class="col-md-12">
                        <h3>Property Description</h3>
                        <p><?php echo $vw_prp->description; ?></p>
                    </div>
                </div>
                <div class="row vw_amnts">
                    <div class="col-md-6">
                        <h3>Amenities</h3>
                        <ul>
                        <?php
                        $vw_amenities = explode(', ', $vw_prp->amenities);
                            foreach ($vw_amenities as $amenity) {
                                echo '<li>'.$amenity.'</li>';
                            }
                        ?>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h3>Info</h3>
                        <ul>
                            <li>Updated 11 min ago</li>
                            <li>No cats allowed</li>
                            <li>Rules</li>
                        </ul>
                    </div>                  
                </div>
            </div>
            <div class="col-md-4 view_rght_col">
                <div class="container vw_rgt_cl_cnt" style="background-color: #efeff7; padding: 0">

                    <?php
                        if($session->is_logged_in()) {
                            $sLnkId = '';
                            $sale_link = 'href="../../private/send_request.php?psy='.$vw_prp->id.'?real+soluop=thisell/p350d34&&lo_wer"';
                        }else {
                            $sLnkId = 'ntLgBuy';
                            $sale_link = '';
                    ?>

                    <div id="fstWlcm2" class="card wlcmWrp">
                        <div class="row wlcmTp">
                            <div class="col-md-12">
                                <i id="clWlcm" class="fa fa-close"></i>
                                <h4 class="m-t-0"><i class="fa fa-exclamation-triangle"></i> Login Required</h4>
                                <p>You have to be logged In to purchase this property</p>
                            </div>
                        </div>
                        <hr>
                        <div class="row wlcmBtm">
                            <div class="col-md-12 wlCBNxt">
                                <a class="btn btn-info" id="vwNotiLg" href="../design_system/login.php">Log In</a>
                            </div>
                        </div>
                    </div>
                    
                    <?php
                        }
                    ?>
                    <div class="row view_dtl_row justify-content-center">
                            <div class="card col-sm-8 view_for_sale">
                        		<?php 
			                        if($vw_prp->no_years > 0) {
			                            $monthly_price = $vw_prp->price / ($vw_prp->no_years * 12) ;
			                        }else {
			                            $monthly_price = 0;
			                        }

                            		$suffix2 = ($vw_prp->bath == 1) ? '' : 's' ; 
                            	?>
                                <h4><i class="fa fa-circle"></i> FOR SALE</h4>
                                <h3>N<?php echo number_format($monthly_price, 2, '.', ','); ?>/<span>mo</span> </h3>
                                <small>(Agent fee Inc.)</small>
                        		
                                <p class="view_years">for <?php echo $vw_prp->no_years.' year'.$suffix2; ?></p>
                                <?php 
                                if($vw_prp->status == '{"ongoing": 1}') {
                                    echo '<a class="view_buy">Ongoing</a>';
                                }else if($vw_prp->status == '{"completed": 1}') {
                                    echo '<a class="view_buy">Completed</a>';
                                }else {
                                    echo '<a class="view_buy" ' . $sale_link . ' id="' . $sLnkId . '"> Buy Now</a>';
                                }
                                ?>
                                <!-- <a class="view_buy"<?php //echo $sale_link; ?> id="<?php //echo $sLnkId; ?>"> Buy Now</a> -->
                            </div>                       
                    </div> 
                    <hr />
                    <div class="row justify-content-center">
                        <div class="col-md-10">
                            <h4>Landlord Details</h4>               
                            <blockquote>
                                    <h4><?php echo $lstr_info->full_name; ?></h4>
                                    <p>T: +234 <?php echo $lstr_info->phone; ?></p>

                                    <?php
                                        if($session->is_logged_in()) {
                                    ?>
                                        <a href="../admin_master/message_compose.php?psy=<?php echo $vw_prp->id; ?>&verste=<?php echo $lstr_info->id; ?>&erit2206/&=fbisale_undvohi/sol=ti&ibi!=ne"><i class="fa fa-comments-o"></i> Message</a>

                                    <?php
                                        }else {
                                            echo '<a tabindex="0" data-toggle="popover" data-trigger="focus" title="Login required" data-content="You need to be logged in to send messages"><i class="fa fa-comments-o"></i> Message</a>';
                                        }
                                    ?>


                                    

                            </blockquote>
                        </div>
                    </div>
                </div>


                <div class="container vw_sim_cont">
                    <div class="m-t-20">
                        <div class="col-md-12 p-t-1 p-l-0 p-r-0">
                            <h3 class="simlr_hd">Similar homes you may Like</h3>
                                <a href="#">
                                <div class="vwSmEchWp">
                                    <div class="vwSmPrc">N12,000,000</div>
                                    <div class="vwSmStat">For Sale</div>
                                    <img width="100%" src="../backend/images/lister/107/119.jpg">
                                    <div class="card sim_cnt_crd1">
                                        <div>
                                            <h3>Brand</h3>
                                            <p>Herbert Macaulay Way off Zambiza Cresent</p>
                                            <hr/>
                                            <div class="row sim_crd1_row">
                                                <div class="col-md-4"><i class="fa fa-bed"></i>1 Bed</div>
                                                <div class="col-md-4 bth"><i class="fa fa-bath"></i>1 Bath</div>
                                                <div class="col-md-4 fts"><i class="fa fa-crop"></i>500 Sq Ft</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                            <a href="#">
                                <div class="vwSmEchWp">
                                    <div class="vwSmPrc">N12,000,000</div>
                                    <div class="vwSmStat">Rent</div>
                                    <img width="100%" src="../backend/images/lister/109/125.jpg">
                                    <div class="card sim_cnt_crd1">
                                        <div>
                                            <h3>Brand</h3>
                                            <p>Herbert Macaulay Way off Zambiza Cresent</p>
                                            <hr/>
                                            <div class="row sim_crd1_row">
                                                <div class="col-md-4"><i class="fa fa-bed"></i>1 Bed</div>
                                                <div class="col-md-4 bth"><i class="fa fa-bath"></i>1 Bath</div>
                                                <div class="col-md-4 fts"><i class="fa fa-crop"></i>500 Sq Ft</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <section class="container view_recnt_cnt">
        <div class="row view_recnt_rw">

            <div class="col-md-12">
                <h2 class="rcntVwHd">Recently Viewed</h2>
            </div>

            <?php
                if(isset($_SESSION['recent_view'])) {
                    $uniq_recnt_id = array_unique($_SESSION['recent_view']);
                    //echo count($_SESSION['recent_view']);
                    foreach ($uniq_recnt_id as $recent_id) {
                        $recent_id = escape($recent_id);
                        $rcnt_prp_obj = Property::find_by_id($recent_id);
                        if($rcnt_prp_obj !== false) {
            ?>
                            <div class="col-md-4">
                                <div class="card p-0" style="border-radius: 6px; border: none;">    
                                    <img style="border-top-left-radius: 6px;border-top-right-radius: 6px; width: 100%;" src='../backend/images/lister/<?php if($rcnt_prp_obj->display != ''){echo $rcnt_prp_obj->id.'/'.$rcnt_prp_obj->display;}else{echo 'placeholder.png';}?>'>
                                    <div style="position: relative;top: -25px;background-color: #fff;width: 93%;margin: 0 auto;padding: 13px;border-radius: 5px;padding-bottom: 5px;">
                                        <h3 style="margin-bottom: 10px;">N<?php echo number_format($rcnt_prp_obj->price, 2, '.', ','); ?></h3>
                                        <div style="padding: 0" class="container">
                                            <div style="margin-left: 0; font-size: 95%;" class="row">
                                                <div style="padding-left: 0;max-width: 20%;" class="col-md-3"><i class="fa fa-bed"></i> <?php echo $rcnt_prp_obj->bed; ?>bd</div>
                                                <div style="padding-left: 0;max-width: 19%;" class="col-md-3"><i style="margin-right: 4px;" class="fa fa-bath"></i><?php echo $rcnt_prp_obj->bath; ?>ba</div>
                                                <div style="padding-left: 1px;max-width: 26%;" class="col-md-4"><i style="margin-right: 4px;" class="fa fa-crop"></i><?php echo $rcnt_prp_obj->area; ?></div>
                                                <div style="padding-left: 5px;" class="col-md-4"><i style="margin-right: 4px;" class="fa fa-tag"></i>For Sale</div>
                                            </div>
                                        </div>
                                        <p><?php echo $rcnt_prp_obj->address; ?></p>
                                        <a style="padding: 10px 15px;border-radius: 4px;" href="?liebe=<?php echo $rcnt_prp_obj->id; ?>&eup=rsano3/listing/gs_l=16_erwidern_dreal+soluop=thisell/p350" class="btn btn-primary">Read more</a>
                                    </div>
                                </div>
                            </div>
                        
            <?php
                            //pr($rcnt_prp_obj);
                        }
                    }
                }
            ?>            


        </div>
    </section>


    <?php include("../admin_master/includes/front_footer.php"); ?>

    <!-- <script src="../design_system/assets/js/jquery.min.js"></script> -->

    <script src="../admin_master/js/lib/bootstrap/js/popper.min.js"></script>
    <script src="../admin_master/js/lib/bootstrap/js/bootstrap.min.js"></script>
    <script src="../admin_master/js/jquery.slimscroll.js"></script>
    <script src="../admin_master/js/sidebarmenu.js"></script>
    <script src="../admin_master/js/lib/sticky-kit-master/dist/sticky-kit.min.js"></script>
    <script src="../admin_master/js/custom.min.js"></script>



<script type="text/javascript">
$(document).ready(function() {
    // $('#fstWlcm2').fadeIn(2500);

    $('#ntLgBuy').click(function() {
        $('#fstWlcm2').show();
        //$('#fstWlcm2').hide();
    });

    $('#clWlcm').click(function() {
        $('#fstWlcm2').hide();
    });
    
    $('.pflPcNav').click(function() {
        window.location = '../admin_master/index.php';
    });

    $(function () {
      $('[data-toggle="tooltip"]').tooltip()
    });

    $(function () {
      $('[data-toggle="popover"]').popover()
    });

});
</script>  

</body>
</html>
