        <div class="left-sidebar">
            <!-- Sidebar scroll-->
            <div class="scroll-sidebar">
                <!-- Sidebar navigation-->
                <nav class="sidebar-nav">
                    <ul id="sidebarnav">
                        <?php
                            $pnd_noti_cnt = TransactionHistory::my_unread_pending('propty_request');
                            
                        ?>  

                        <li class="nav-devider"></li>
                        <li class="nav-label">Home</li>
                        <li> <a class=" " href="index.php" aria-expanded="false"><i class="fa fa-tachometer"></i>
                            <span class="hide-menu">Dashboard</span></a> </li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-wpforms"></i>
                            <span class="hide-menu">Listings
                                <?php echo (!empty($pnd_noti_cnt)) ? '<span class="label label-rouded label-warning pull-right">'. count($pnd_noti_cnt) .'</span>' : '' ; ?>
                            </span></a>

                            <ul aria-expanded="false" class="collapse">
                                <li><a href="upload_property.php">Create</a></li>
                                <li><a href="my_listings.php">My Listings</a></li>
                                <li><a href="all_listings.php">All Listings</a></li>
                                <li><a href="ongoing.php">Ongoing</a></li>
                                <li><a href="pending_offers.php">
                                    <?php 
                                    if(SystemUsers::is_lister()) {
                                        echo 'Received offers';
                                    }else{
                                        echo 'Sent offers';
                                    } 
                                    ?>

                                        <?php echo (!empty($pnd_noti_cnt)) ? '<span class="label label-rounded label-warning">'. count($pnd_noti_cnt) .'</span>' : '' ; ?>
                                    </a></li>
                                <li><a href="completed_purchase.php">Completed Purchase</a></li>
                            </ul>
                        </li>
                        <li> <a class=" " href="all_users.php" aria-expanded="false"><i class="fa fa-user-circle"></i><span class="hide-menu">Users</span></a>
                        </li>
                        <li> <a class=" " href="transactions.php" aria-expanded="false"><i class="fa fa-bar-chart"></i><span class="hide-menu">Transactions</span></a>
                        </li>
                        <li> <a class=" " href="boost_wallet.php" aria-expanded="false"><i class="fa fa-suitcase"></i><span class="hide-menu">Boost Wallet</span></a> </li>
						<li> <a class=" " href="banks_cards.php" aria-expanded="false"><i class="fa fa-credit-card"></i><span class="hide-menu">Banks & Cards</span></a>
                        </li>
                        <li> <a class=" " href="simulate_deductions.php" aria-expanded="false"><i class="fa fa-usd"></i><span class="hide-menu">Simulate deductions[sandbox]</span></a>
                        </li>
                        <li> <a class=" " href="#" aria-expanded="false"><i class="fa fa-wpforms"></i><span class="hide-menu">Upgrade</span></a>
                        </li>
                        <li> <a class="has-arrow " href="#" aria-expanded="false"><i class="fa fa-comments-o"></i><span class="hide-menu">Chat</span> 
                            <?php 
                            if($unrd_msg_cnt > 0) {   
                                echo '<span class="label label-rouded label-success pull-right">'.$unrd_msg_cnt.'</span>';
                            }
                            ?>
                             
                        
                        </a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="message_compose.php">Compose</a></li>
                                <li><a href="message_inbox.php">All 
                                    <?php if($unrd_msg_cnt > 0) {   ?>
                                        <span class="label label-rounded label-success"><?php echo $unrd_msg_cnt; ?></span>
                                    <?php } ?>
                                </a></li>
                            </ul>                            
                        </li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-cog"></i><span class="hide-menu">Settings</span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="system_user_profile.php">Profile</a></li>
                                <li><a href="change_system_user_password.php">Change password</a></li>
                            </ul>
                        </li>
                        <li class="nav-label">EXTRA</li>
                        <li> <a class="has-arrow  " href="#" aria-expanded="false"><i class="fa fa-book"></i><span class="hide-menu">Pages </span></a>
                            <ul aria-expanded="false" class="collapse">
                                <li><a href="#">Agreement</a></li>
                                <li><a href="#">others</a></li>
                            </ul>
                        </li>
                        <li> <a class=" " href="#" aria-expanded="false"><i class="fa fa-external-link"></i><span class="hide-menu">Talk to Reesa</span></a>
                        </li>
                    </ul>
                </nav>
                <!-- End Sidebar navigation -->
            </div>
            <!-- End Sidebar scroll-->
        </div>