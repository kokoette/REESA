<?php

require_login();

$stat = '';
if(SystemUsers::is_lister()) {
    $transactions = TransactionHistory::get_trans_history('lister', 'LIMIT 5');
} elseif (SystemUsers::is_user()) {
    $stat = 'user';
    $transactions = TransactionHistory::get_trans_history('user', 'LIMIT 5');
} else {
    redirect_to('index.php');
}

if(SystemUsers::is_reesa()) {
    $role = 'reesa';
}else if(SystemUsers::is_lister()) {
    $role = 'lister';
    $person = 'lister_id';
}else if(SystemUsers::is_user()) {
    $pnd_link = 'sort';
    $role = 'user';
    $person = 'user_id';
}

if(isset($_GET['ysp'])) {
    $propt_id = $_GET['ysp'];
    $property_obj = Property::find_by_id($propt_id);
    if($property_obj === false) { redirect_to('index.php'); }
    //is_user, is listers property
    //cannot pay/recieve offer twice on the same listing and user
}
$total_paid = 0;
$balance = 0;
$monthly_deduct = 0;
$start_price = 0;
$duration = 0;
$price = 0;
$months_left = 0;
$property_address = "No Property";
$progress_notification = "No Property Transaction Ongoing";
if(!isset($propt_id)) {
                        
    $prpt_ongoin_objs = PropertyTransDetails::ongoin_offers($person);
    //   !== null ? PropertyTransDetails::ongoin_offers($person) : ;
    foreach ($prpt_ongoin_objs as $prpt_ongoin_obj) {
        $ongoin_offers = Property::find_all_by_id($prpt_ongoin_obj->property_id, 0, '');
        foreach($ongoin_offers as $offers) {
            $total_paid += $prpt_ongoin_obj->total_paid_amount;
            $balance += $prpt_ongoin_obj->property_balance;
            $monthly_deduct += $prpt_ongoin_obj->deduct_monthly;
            $start_price += $prpt_ongoin_obj->start_property_price;
            $months_left += $prpt_ongoin_obj->months_left;            
            $duration = $offers->no_years;
            $price = $offers->price;
            $property_address = $offers->address;
            $progress_notification = "Property Transaction Progress";
        }
    }

}
?>


        <div class="page-wrapper dshWrp">
            <!-- Bread crumb -->
            <div class="row page-titles m-b-20">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Dashboard</h3> 
                </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Dashboard</li>
                    </ol>
                </div>

                
                <?php echo Session::frst_wlm_msg(); ?>
            </div>
            <!-- End Bread crumb -->
            <!-- Container fluid  -->
            
            <div class="container-fluid">

                <!-- <div class="col-lg-12 dsChtWrp">
                    <div class="bg-white dsCht">
                            <h4 style="visibility: hidden;" class="card-title">Extra Area Chart</h4>
                            <div id="extra-area-chart"></div>
                    </div>
                </div> -->

                <!-- Start Page Content -->
                <div class="row mb-5">
                    <div class="col-lg-3 dshSmr1 p-r-0 p-l-10">
                        <div class="">
                            <div class="dSOneHdr">
                                <p>Deposits</p>
                            </div>
                            <div class="dSOneBd">
                                <?php 
                                    if($duration > 0) {
                                        $monthly_price = $price / ($duration * 12) ;
                                    }else {
                                        $monthly_price = 0;
                                    }
                                ?>
                                <div class="">
                                    <h2 class="color-white">N<?php echo number_format($monthly_deduct, 2, '.', ',');?></h2>
                                    <p class="color-white">Next Deposit</p>
                                </div>
                            </div>
                            <div class="dSOneftr">
                                <p>N<?php echo number_format($balance, 2, '.', ',');?> balance </p> 
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-3 dshSmr1 p-r-0 p-l-10">
                        <div class="">
                            <div class="dSOneHdr">
                                <p>Properties</p>
                            </div>
                            <div class="dSOneBd dsTwoBd">
                                <div class="">
                                    <h2 class="color-white">N<?php echo number_format($total_paid, 2, '.', ',');?></h2>
                                    <p class="color-white">Amount Paid</p>
                                </div>
                            </div>
                            <div class="dSOneftr">
                                <p>N<?php echo number_format($start_price, 2, '.', ',');?> Total Cost</p> 
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-6 dsChtWrp">
                        <div class="bg-white dsCht">
                            <h4 style="visibility: hidden;" class="card-title">Extra Area Chart</h4>
                            <div id="extra-area-chart"></div>
                        </div>
                    </div>
                </div>

                <div class="row mb-5">
                    <div class="col-md-5 dsPySmr">
                        <div class="card dSmry p-10 p-t-10">
                            <div class=" dsPySInr">
                                <h4 class="color-white f-s-14">My Summary</h4>
                                <hr style="border:none;border-bottom:1px solid #fff;" class="p-0" />
                            </div>
                            <div class="media widget-ten">

                                <div class="dPSmrDtls">
                                    <!-- <h2 class="color-white">568120</h2> -->
                                    <p class="m-b-0">
                                        Payment is <b>N<?php echo number_format($monthly_deduct, 2, '.', ',');?></b> per month <br/> It will take <b><?php echo $months_left;?></b> months <br/> to pay for all properties 
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card p-t-0 p-b-25">
                        <h5 class="m-t-28 text-primary"><?php echo $progress_notification; ?></h5>
                        <?php
                        if(!isset($propt_id)) {
                        $prpt_ongoin_objs = PropertyTransDetails::ongoin_offers($person);
                        //   !== null ? PropertyTransDetails::ongoin_offers($person) : ;
                        foreach ($prpt_ongoin_objs as $prpt_ongoin_obj) {
                            $ongoin_offers = Property::find_all_by_id($prpt_ongoin_obj->property_id, 0, '');
                            foreach($ongoin_offers as $offers) {

                        ?>
                            <?php 
                            if($total_paid == 0){
                                $payment_percentage = 0;
                            }else{
                                $payment_percentage = ($total_paid / $start_price) * 100;
                            }
                            ?>
                            <h5 class="m-t-28"><?php echo $offers->address; ?><span class="pull-right"><?php echo $payment_percentage;?>% of <?php echo number_format($offers->price, 2, '.', ',');?></span></h5>
                            <div class="progress">
                                <div class="progress-bar bg-primary wow animated progress-animated" style="<?php echo  'width:'. $payment_percentage.'%';?>" role="progressbar"> <span class="sr-only">60% Complete</span> </div>
                            </div>
                            <!-- <h5 class="m-t-30">Property 2<span class="pull-right">45% of N5,700,000</span></h5>
                            <div class="progress">
                                <div class="progress-bar bg-warning wow animated progress-animated" style="width: 45%; height:6px;" role="progressbar"> <span class="sr-only">60% Complete</span> </div>
                            </div>
                            <h5 class="m-t-30">Property 3<span class="pull-right">25% of N20,000,000</span></h5>
                            <div class="progress">
                                <div class="progress-bar bg-inverse wow animated progress-animated" style="width: 25%; height:6px;" role="progressbar"> <span class="sr-only">60% Complete</span> </div>
                            </div> -->
                        <?php }
                            }
                        }
                        ?>
                        </div>
                    </div>
                </div>


                <div class="row">
                <!-- Hiding News Carousel -->
					<!-- <div class="col-lg-3">
                        <div class="card bg-dark">
                            <div class="testimonial-widget-one p-17">
                                <div class="testimonial-widget-one owl-carousel owl-theme">
                                    <div class="item">
                                        <div class="testimonial-content">
                                            <img class="testimonial-author-img" src="images/avatar/2.jpg" alt="" />
                                            <div class="testimonial-author">News From Reesa</div>
                                            <div class="testimonial-author-position">Sub heading</div>

                                            <div class="testimonial-text">
                                                <i class="fa fa-quote-left"></i>  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation .
                                                <i class="fa fa-quote-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="item">
                                        <div class="testimonial-content">
                                            <img class="testimonial-author-img" src="images/avatar/3.jpg" alt="" />
                                            <div class="testimonial-author">News From Reesa</div>
                                            <div class="testimonial-author-position">Sub heading</div>

                                            <div class="testimonial-text">
                                                <i class="fa fa-quote-left"></i>  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation .
                                                <i class="fa fa-quote-right"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> -->
                    <div class="col-lg-4">
                        <div class="card dsMgCrd">
                            <div class="card-title dsCrdInr">
                                <h5 class="m-b-0">Active Card</h5>
                                <hr class="m-0" />
                            </div>
                            <div class="card-body dsCrdDtls">
                                <p>VISACARD-XXXX</p>
                                <a href="banks_cards.php"><h5>Manage Cards &nbsp; <i class="fa fa-location-arrow"></i></h5></a>
                            </div>
                        </div>
                        <!-- /# card -->
                    </div>
                    <div class="col-lg-8">
                        <div class="card">
                            <div class="card-title">
                                <h4>Recent Transactions</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                        <table class="table">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th><?php echo ($stat == 'user') ? 'Payee <small>(Paid to)' : 'Payer <small>(Payment from)'; ?></small></th>
                                                    <th>Property Address</th>
                                                    <th>Amount</th>
                                                    <th>Date</th>
                                                </tr>
                                            </thead>
                                            <tbody>

                                                <?php
                                                if($transactions !== false) {

                                                
                                                    foreach($transactions as $transaction) {
                                                ?>

                                                        <tr>
                                                            <td>
                                                                <div class="rect-img">
                                                                    <a href="#"><img src="../backend/images/lister/<?php if($transaction->display != ''){echo $transaction->property_id.'/'.$transaction->display;}else{echo 'placeholder.png';}?>" alt=""></a>
                                                                </div>
                                                            </td>
                                                            <td><?php echo $transaction->full_name; ?></td>
                                                            <td><span><?php echo $transaction->address; ?></span></td>
                                                            <td><span>N <?php echo number_format($transaction->amount_charged); ?></span></td>
                                                            <td><span><?php echo $transaction->date_time; ?></span></td>
                                                        </tr>

                                                <?php
                                                    }        
                                                } else {
                                                    echo '<tr class="odd"><td valign="top" colspan="5" class="dataTables_empty">You have not made any transaction</td></tr>';
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- <div class="row">
					<div class="col-lg-8">
						<div class="row">
						<div class="col-lg-6">
							<div class="card dsMgCrd">
								<div class="card-title dsCrdInr">
									<h5 class="m-b-0">Active Card</h5>
                                    <hr class="m-0" />
								</div>
								<div class="card-body dsCrdDtls">
									<p>VISACARD-XXXX</p>
                                    <a href="#"><h5>Manage Cards &nbsp; <i class="fa fa-location-arrow"></i></h5></a>
								</div>
							</div>
							 /# card -->
						<!-- </div> -->
						<!-- /# column -->
						<!-- <div class="col-lg-6">
							<div class="card">
								<div class="card-body">
									<p>Advertise/Promote property</p>
								</div>
							</div>
						</div>


						</div>
					</div>
                </div> -->


                <!-- End PAge Content -->
            </div>
            <!-- End Container fluid  -->
            <!-- footer -->
            <footer class="footer" style="padding:20px 15px;"> © 2018 All rights reserved.</footer>
            <!-- End footer -->
        </div>
