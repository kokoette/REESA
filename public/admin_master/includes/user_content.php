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
                <!-- Start Page Content -->
                <div class="row mb-5">
                    <div class="col-lg-3 dshSmr1 p-r-0 p-l-10">
                        <div class="">
                            <div class="dSOneHdr">
                                <p>Deposits</p>
                            </div>
                            <div class="dSOneBd">
                                <div class="">
                                    <h2 class="color-white">N15,000.00</h2>
                                    <p class="color-white">Next Deposit</p>
                                </div>
                            </div>
                            <div class="dSOneftr">
                                <p>N30,000 Last Deposit</p> 
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
                                    <h2 class="color-white">N50,681.00</h2>
                                    <p class="color-white">Amount Left</p>
                                </div>
                            </div>
                            <div class="dSOneftr">
                                <p>N12,000,000 Total Cost</p> 
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
                                    <p class="m-b-0">Payment is <b>50,000</b> per month <br/> It will take <b>3</b> years <b>6</b> months <br/> to pay for all listing </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-7">
                        <div class="card p-t-0 p-b-25">
                                        <h5 class="m-t-28">Property 1<span class="pull-right">85% of N10,000,000</span></h5>
                                        <div class="progress">
                                            <div class="progress-bar bg-primary wow animated progress-animated" style="width: 85%; height:6px;" role="progressbar"> <span class="sr-only">60% Complete</span> </div>
                                        </div>
                                        <h5 class="m-t-30">Property 2<span class="pull-right">45% of N5,700,000</span></h5>
                                        <div class="progress">
                                            <div class="progress-bar bg-warning wow animated progress-animated" style="width: 45%; height:6px;" role="progressbar"> <span class="sr-only">60% Complete</span> </div>
                                        </div>
                                        <h5 class="m-t-30">Property 3<span class="pull-right">25% of N20,000,000</span></h5>
                                        <div class="progress">
                                            <div class="progress-bar bg-inverse wow animated progress-animated" style="width: 25%; height:6px;" role="progressbar"> <span class="sr-only">60% Complete</span> </div>
                                        </div>
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
                                <a href="#"><h5>Manage Cards &nbsp; <i class="fa fa-location-arrow"></i></h5></a>
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
