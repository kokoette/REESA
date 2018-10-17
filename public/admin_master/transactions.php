<?php require_once('../../private/initialize.php'); 

require_login();

$stat = '';
if(SystemUsers::is_lister()) {
    $transactions = TransactionHistory::get_trans_history('lister', '');
} elseif (SystemUsers::is_user()) {
    $stat = 'user';
    $transactions = TransactionHistory::get_trans_history('user', '');
} else {
    redirect_to('index.php');
}

if(!SystemUsers::is_reesa()); {
    TransactionHistory::set_trans_to_read();
}

$page_title = "Reesa.com My Dashboard";
$custom_css_library = '
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
            <div class="row page-titles">
                <div class="col-md-5 align-self-center">
                    <h3 class="text-primary">Transactions</h3> </div>
                <div class="col-md-7 align-self-center">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="javascript:void(0)">Home</a></li>
                        <li class="breadcrumb-item active">Transactions</li>
                    </ol>
                </div>
            </div>
            <!-- End Bread crumb -->

                <!-- Start Page Content -->




                <div class="container-fluid">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="card">
                                <div class="card-title">
                                    <h4>Transaction History</h4>
                                </div>
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table id="myTable" class="table table-bordered table-hover table-striped">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th><?php echo ($stat == 'user') ? 'Payer <small>(Paid to)' : 'Payee <small>(Payment from)'; ?></small></th>
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
                                                            <td><span>N <?php echo number_format($transaction->amount_charged, 2, '.', ','); ?></span></td>
                                                            <td><span><?php echo $transaction->date_time; ?></span></td>
                                                        </tr>

                                                <?php
                                                    }      
                                                }
                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- End Page Content -->

        </div>

        <!-- End Page wrapper  -->


<?php include("includes/footer.php"); ?>