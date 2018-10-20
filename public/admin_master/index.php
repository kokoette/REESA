<?php require_once('../../private/initialize.php'); ?>
<?php require_login();?>
<?php

$page_title = "Reesa.com My Dashboard";
$custom_css_library = '
    <link href="css/lib/calendar2/semantic.ui.min.css" rel="stylesheet">
    <link href="css/lib/calendar2/pignose.calendar.min.css" rel="stylesheet">
    <link href="css/lib/owl.carousel.min.css" rel="stylesheet" />
    <link href="css/lib/owl.theme.default.min.css" rel="stylesheet" />
    <style>
        .bg-dark {
            background: #444c67 !important;
            color: #ffffff;
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
        <?php 
            if(SystemUsers::is_user()){
                include("includes/user_content.php");
            }else {
                include("includes/lister_content.php");
            }
        ?>
        <!-- End Page wrapper  -->

<?php
    $footer_cust_lib = '
    <script src="js/lib/morris-chart/raphael-min.js"></script>
    <script src="js/lib/morris-chart/morris.js"></script>
    <script src="js/lib/morris-chart/dashboard1-init.js"></script>

    <script src="js/lib/calendar-2/moment.latest.min.js"></script>
    <!-- scripit init-->
    <script src="js/lib/calendar-2/semantic.ui.min.js"></script>
    <!-- scripit init-->
    <script src="js/lib/calendar-2/prism.min.js"></script>
    <!-- scripit init-->
    <script src="js/lib/calendar-2/pignose.calendar.min.js"></script>
    <!-- scripit init-->
    <script src="js/lib/calendar-2/pignose.init.js"></script>

    <script src="js/lib/owl-carousel/owl.carousel.min.js"></script>
    <script src="js/lib/owl-carousel/owl.carousel-init.js"></script>
    <!-- <script src="js/scripts.js"></script> -->
    <!-- scripit init-->

    <script src="js/lib/datatables/datatables.min.js"></script>
    <script src="js/lib/datatables/datatables-init.js"></script>

    <script src="js/lib/toastr/toastr.min.js"></script>
    <!-- scripit init-->
    <script src="js/lib/toastr/toastr.init.js"></script>
    
    <script type="text/javascript">

        $("#fstWlcm").fadeIn(2500);
        $("#clWlcm").click(function() {
            $("#fstWlcm").hide();
        });

    </script>
    ';
?>


<?php include("includes/footer.php"); ?>
