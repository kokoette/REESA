<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Reesa">
    <meta name="author" content="Reesa">
    <link rel="icon" type="image/png" sizes="16x16" href="images/favicon.png">
    <script src="https://js.paystack.co/v1/inline.js"></script>
    <title><?php if($page_title != '') {echo $page_title;} else {echo "Reesa.com My Dashboard";} ?></title>
    
    <link href="css/lib/bootstrap/bootstrap.min.css" rel="stylesheet">
    <?php if(isset($custom_css_library)) {echo $custom_css_library;} ?>

    <link href="css/lib/toastr/toastr.min.css" rel="stylesheet">
    <link href="css/lib/calendar2/semantic.ui.min.css" rel="stylesheet">
    <link href="css/helper.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <link href="css/main.css" rel="stylesheet">

    <?php 

    $unrd_msg_cnt = 0;
    $inbx_countish = Message::get_person_msg('receiver');
    if($inbx_countish) {
        foreach ($inbx_countish as $inbx_count) {
            if($inbx_count->receiver_view == 0) {
                $unrd_msg_cnt++;
            }
        }
    }

    ?>

</head>

<body class="fix-header fix-sidebar">
    <!-- Preloader - style you can find in spinners.css -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>
    <!-- Main wrapper  -->
    <div id="main-wrapper">
        <div class="header">
            <nav class="navbar top-navbar navbar-expand-md navbar-light">
                <div class="navbar-header">
                    <a class="navbar-brand" href="index.php">
                        <b><img src="images/logo.png" alt="homepage" class="dark-logo" /></b>
                    </a>
                </div>
                <div class="navbar-collapse">
                    <ul class="navbar-nav mr-auto mt-md-0">
                        <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted  " href="javascript:void(0)"><i class="mdi mdi-menu"></i></a> </li>
                        <li class="nav-item m-l-10"> <a class="nav-link sidebartoggler hidden-sm-down text-muted SdbrbugMen " href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                    </ul>
                    <ul class="navbar-nav my-lg-0">
                        <li class="nav-item dropdown nvNotLst">
                            <a class="nav-link dropdown-toggle text-muted text-muted nvNotLink " href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-bell"></i>

                        <?php
                            $sql = "SELECT * FROM notifications WHERE sys_user_id=".$_SESSION["sys_user_id"];
                            $result = $database->query($sql);
                            if(TransactionHistory::get_unread_noti_no()) {
                        ?>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                        <?php
                            }
                        ?>
                                
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn">
                                <ul>
                                    <li>
                                        <div class="drop-title">Notifications</div>
                                    </li>
                                    <li>
                                        <div class="message-center">
                                            <!-- Message -->

                                            <?php

                                                if($result) {
                                                    while ($row = $result->fetch_assoc()) {
                                            ?>

                                                        <a href="<?php echo $row['page'] ?>.php">
                                                            <div class="btn btn-danger btn-circle m-r-10"><i class="fa fa-link"></i></div>
                                                            <div class="mail-contnet">
                                                                <h5><?php echo $row['title'] ?></h5> <span class="mail-desc"><?php echo $row['message'] ?></span> <span class="time"><?php echo $row['date_time'] ?></span>
                                                            </div>
                                                        </a>

                                            <?php
                                                    }
                                                }
                                                if(!$result->num_rows) {
                                                    echo 'You do not have any Notifications';
                                                }
                                            ?>

                                            
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="javascript:void(0);"> <strong>Check all notifications</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- End Comment -->
                        <!-- Messages -->
                        <li class="nav-item dropdown <?php echo ($_SESSION['profile'] != '') ? 'spcFrPflPc':'';?>">
                            <a class="nav-link dropdown-toggle text-muted  " href="#" id="2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="fa fa-envelope"></i>
                        <?php

                            if($unrd_msg_cnt > 0) { 
                        ?>
                                <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
                        <?php
                            }
                        ?>    
                            </a>
                            <div class="dropdown-menu dropdown-menu-right mailbox animated zoomIn" aria-labelledby="2">
                                <ul>
                        <?php
                            $msg_suffix = 's';
                            $get_my_unread_msgs = Message::get_my_unread_msg();
                            $hdr_urd_ms_cnt = 'no';
                            if($get_my_unread_msgs != false) {
                                $hdr_urd_ms_cnt = count($get_my_unread_msgs);
                                $msg_suffix = (count($get_my_unread_msgs) > 1) ? 's' : '' ;
                            }
                        ?>
                                    <li>
                                        <div class="drop-title">You have <?php echo $hdr_urd_ms_cnt; ?> new message<?php echo $msg_suffix; ?></div>
                                    </li>
                                    <li>
                                        <div class="message-center">

                                            <!-- Message -->
                        <?php
                            if($get_my_unread_msgs == false) {
                                //echo 'No msg';
                            }else {
                                foreach ($get_my_unread_msgs as $get_my_unread_msg) {
                                    //pr($get_my_unread_msg);
                                    $prsn_dts_unrd = SystemUsers::find_by_id($get_my_unread_msg->sender_id);
                        ?>
                                            <a href="read_message.php?sprech=<?php echo $get_my_unread_msg->id; ?>&eup=rsano3/listing/gs_l=16d&bots=12_4tqy">
                                                <div class="user-img"> 

                                                    <?php if($prsn_dts_unrd->profile != '') {echo '<img src="../backend/images/profile/'. $prsn_dts_unrd->profile .'" class="img-circle">'; } else {echo '<i class="fa fa-user-circle-o f-s-40" style="vertical-align: middle;"></i>';} ?>

                                                    <span class="profile-status busy pull-right"></span> </div>
                                                <div class="mail-contnet">
                                                    <h5><?php echo $prsn_dts_unrd->full_name; ?></h5> <span class="mail-desc"><?php echo $get_my_unread_msg->subject; ?></span> <span class="time"><?php echo $get_my_unread_msg->date_time; ?></span>
                                                </div>
                                            </a>
                        <?php
                                }
                            }
                        ?>
                                            
                                        </div>
                                    </li>
                                    <li>
                                        <a class="nav-link text-center" href="message_inbox.php"> <strong>View all Messages</strong> <i class="fa fa-angle-right"></i> </a>
                                    </li>
                                </ul>
                            </div>
                        </li>
                        <!-- End Messages -->
                        <!-- Profile -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle text-muted <?php echo ($_SESSION['profile'] != '') ? 'pflPcNav':'';?>" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> 

                                <?php if($_SESSION['profile'] != '') { echo '<img src="../backend/images/profile/'.$_SESSION['profile'].'"  class="profile-pic prflPcImg"'; } else {echo '<i class="fa fa-user-circle-o prfl_pc_fa"></i>';} ?>

                             
                         </a>
                            <div class="dropdown-menu dropdown-menu-right animated zoomIn">
                                <ul class="dropdown-user">
                                    <li><a href="system_user_profile.php"><i class="ti-user"></i> Profile</a></li>
                                    <li><a href="#"><i class="ti-wallet"></i> Balance</a></li>
                                    <li><a href="message_inbox.php"><i class="ti-email"></i> Inbox</a></li>
                                    <li><a href="change_system_user_password.php"><i class="ti-settings"></i> Setting</a></li>
                                    <li><a href="logout.php"><i class="fa fa-power-off"></i> Logout</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="nav-item dropdown">
                            <p class="nav-link"><?php echo "Welcome ".$_SESSION['full_name'] ;?></p>
                        </li>
                    </ul>
                </div>
            </nav>
        </div>

<?php //echo display_session_message(); ?>