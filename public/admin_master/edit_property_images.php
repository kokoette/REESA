<?php require_once('../../private/initialize.php'); ?>
<?php

  if(isset($_GET['psy'])) {
    if(isset($_POST['new_prop'])){
      $get_id = $_POST['edt_prop_id'];
    } else {
      $get_id = $_GET['psy'];
    }
    if(!Property::is_my_property($get_id)) {
      redirect_to('index.php'); 
    }

    $property = Property::find_by_id($get_id);
    if($property == false) {
      redirect_to('index.php');
    }

    $property_images = PropertyImages::get_property_images($get_id);

    if(isset($_POST['new_prop'])){
        $property->files = $_FILES['files'] ?? NULL;
        $prop_valid = $property->prop_up_valid();
        if($prop_valid !== true) {
          foreach ($prop_valid as $new_errors) {
            $property->errors[] = $new_errors;
          }
        }
        if(empty($property->errors)) {

          $property->up_new_prop = false;
          $result = $property->property_upload();
          if($result === true) {
            $session->message('Property Uploaded Successfully');
            header('Location: '.$_SERVER['HTTP_REFERER']);
            exit(); 
          }

        }
    }

    if(isset($_GET['streichen'])) {
      $dlt_image= escape($_GET['streichen']);
      $verste = PropertyImages::find_by_id($dlt_image);
      if($verste) {


        $img_deleted = $verste->delete();
        if($img_deleted) {

          $verste->remove_image();

          $imgPlsExt = $verste->id.'.'.$verste->ext;
          if($property->display == $imgPlsExt) {
            $property->unset_profile();
          }
          header('Location: '.$_SERVER['HTTP_REFERER']);
          exit(); 

        }else {
          $session->message('Error: Could not delete image');
          header('Location: '.$_SERVER['HTTP_REFERER']);
          exit();          
        }

      } else {
        $session->message('Error: Could not delete image');
        redirect_to('index.php');
      }
    }

    if(isset($_GET['ft'])) {
      $set_as_ft = $_GET['ft'];
      $rslt_prop_img = PropertyImages::find_by_id($set_as_ft);
      $ftWtExt = $rslt_prop_img->id.'.'.$rslt_prop_img->ext;
      $rsltStFt = Property::set_display($rslt_prop_img->property_id, $ftWtExt);
      if($rsltStFt) {
            $session->message('Successfully set as Display Image');
            header('Location: '.$_SERVER['HTTP_REFERER']);
            exit();         
      }else {
            $session->message('Error: Something went wrong please try again');
            header('Location: '.$_SERVER['HTTP_REFERER']);
            exit();
      }
    }

  }else {
    redirect_to('index.php');
  }

  if(is_post_request()) {
      //pr($_POST);
  }

$page_title = "Reesa.com - Edit Property Image";
$custom_css_library = '
    <link href="css/lib/toastr/toastr.min.css" rel="stylesheet">
    <link href="css/lib/calendar2/semantic.ui.min.css" rel="stylesheet">
    <link rel="stylesheet" href="global/bootstrap.min.css">
    <link rel="stylesheet" href="global/bootstrap-extend.min.css">
    <link rel="stylesheet" href="global/site.min.css">
    <link rel="stylesheet" href="global/masonry.css">
    <style>
    body {
      padding-top: 0;
    }
    </style>
';
?>
<?php include("includes/header.php"); ?>
<!-- End header header -->

        <!-- Left Sidebar  -->
        <?php include("includes/sidebar.php"); ?>
        <!-- End Left Sidebar  -->


        <!-- Page wrapper  -->

        <div class="page-wrapper">
            <!-- Bread crumb -->
            <div class="row page-titles m-b-10">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary"><a class="m-r-10 bckEdtImgs" href="edit_property.php?psy=<?php echo $property->id ;?>&eup=rsano3/listing/gs_l=16d"><i class="fa fa-reply"></i><a>Edit Property Image</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item"><a href="my_listings.php">My Listings</a></li>
                        <li class="breadcrumb-item"><a href="edit_property.php?psy=<?php echo $property->id ;?>&eup=rsano3/listing/gs_l=16d">Edit Property</a></li>
                        <li class="breadcrumb-item active">Edit Property Image</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->

            <!-- Container fluid  -->
            <div class="container-fluid">
                <!-- Start Page Content -->

                <div class="row bg-white box-shadow m-b-20">
                      <div class="col-lg-12">
                          <div class="card p-l-0 p-t-0 p-b-0">
                            <div class="card-title">
                                  
                                  <small><i>Images for</i></small>
                                  <h4><?php echo $property->address.', '.$property->state; ?></h4>
                              </div>
                              </div>
                          </div>
                          <div class="card-body">
                            <!-- <img style="width: 100%;" src="../images/sandbox/23.gif"> -->
                          </div> 
                </div>

                <?php echo display_errors($property->errors); ?>
                <div class="row m-b-10">
                  <div class="col-md-7">
                    <form action="" method="post" enctype="multipart/form-data">
                      <input type="file" class="dropzone p-t-3 p-b-4"" name="files[]" multiple="">
                      <input type="hidden" value="<?php echo $property->id; ?>" name="edt_prop_id">
                      <button type="submit" name="new_prop" style="margin-top:-2px;" class="btn btn-primary btn-md p-t-4 p-b-4">Upload</button>
                    </form>
                  </div>
                </div>


                <div>
                  <div class="edtPrpImg">
                    <ul class="blocks blocks-lg-4" data-plugin="masonry">
                      <?php
                      if($property_images !== false) {
                        foreach ($property_images as $prpty_img) {
                      ?>
                        <li class="masonry-item">
                          <?php
                            $img_ext = $prpty_img->id.'.'.$prpty_img->ext;
                            if($property->display == $img_ext) {
                              echo '<div class="edSetFt" href="#">Display Image</div>';
                            }else {
                              echo '<div class="showSetFtd"><a class="shwStFLnk" href="edit_property_images.php?psy='.$property->id.'&ft='.$prpty_img->id.'&eup=rsano3/listing/gs_l=16d">Set as Display</a></div>';
                            }
                          ?>
                          <a class="delEdPImg" href="?psy=<?php echo $prpty_img->property_id; ?>&streichen=<?php echo $prpty_img->id; ; ?>&eup=rsano3/listing/gs_l=16d"><i class="fa fa-close"></i></a>
                              <img style="width: 100%;" src="../backend/images/lister/<?php echo $prpty_img->property_id.'/'.$prpty_img->id.'.'.$prpty_img->ext;?>">
                        </li>
                      <?php
                        }
                      }else {
                        echo "<li>There are no images for this Property</li>";
                      }
                      ?>
                    </ul>
                  </div>
                </div>
            </div>
        </div>

<?php
  $footer_cust_lib = '
    <script src="global/babel-external-helpers/babel-external-helpers.js"></script>
    <script src="global/masonry/masonry.pkgd.js"></script>
    <script src="global/Component.js"></script>
    <script src="global/Plugin.js"></script>
    <script src="global/Base.js"></script>
    <script src="global/Site.js"></script>
    <script src="global/masonry.js"></script>
    <script>
      (function(document, window, $){
        \'use strict\';
    
        var Site = window.Site;
        $(document).ready(function(){
          Site.run();
        });
      })(document, window, jQuery);
    </script>
  ';
?>

<?php include("includes/footer.php"); ?>
