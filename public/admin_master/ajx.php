<?php

if(isset($_POST['page'])) {
	$page = $_POST['page'];
	$page = explode('?', $page);
	if(in_array('sent_mail=true', $page)) {
		$sent_mail = $_GET['sent_mail'] = 'true';
	}
}
if(isset($_POST['msgKiste']) && !empty($_POST['msgKiste'])) {
	require_once('../../private/initialize.php');
	$msg_id_ary = $_POST['msgKiste'];
	if(count($msg_id_ary) ==1) {
		$msg_sufx = '';
	}else {
		$msg_sufx = 's';
	}

	if(isset($sent_mail)) {
    	$person = 'sender_delete';	
    	$person_id = 'sender_id';
    	$prsn_deltd = 'receiver_delete';
	}else {
		$person = 'receiver_delete';
    	$person_id = 'receiver_id';
    	$prsn_deltd = 'sender_delete';
	}
	foreach ($msg_id_ary as $msg_id) {
		$msg_to_delt = Message::find_by_id($msg_id);
		if(!$msg_to_delt->$prsn_deltd == 0) {
			if($msg_to_delt->$person_id == $_SESSION['sys_user_id']) {
				$msg_to_delt->delete();
			}
		}else {
			if($msg_to_delt->$person_id == $_SESSION['sys_user_id']) {
				$msg_to_delt->set_delete($person);
			}
		}
	}

	$session->message("Message$msg_sufx deleted");

	if(isset($sent_mail)) {
    	$recieved_msgs = Message::get_person_msg('sender');
	}else {
		$recieved_msgs = Message::get_person_msg('receiver');
	}

}elseif(isset($_POST['msgMrkUnrd']) && !empty($_POST['msgMrkUnrd'])) {
	require_once('../../private/initialize.php');
	$msg_id_ary = $_POST['msgMrkUnrd'];

	if(isset($sent_mail)) {
    	$recieved_msgs = Message::get_person_msg('sender');		
	}else {
		foreach ($msg_id_ary as $msg_id) {
			$sql = "UPDATE message SET receiver_view = '0' WHERE id = '". $msg_id ."'";
			$result = $database->query($sql);
		}
		$recieved_msgs = Message::get_person_msg('receiver');
	}	
}







if($recieved_msgs) {
    foreach ($recieved_msgs as $recieved_msg) {
        if(isset($_GET['sent_mail'])) {
            $read_stat = '&read_sent='.$recieved_msg->receiver_id;
        } else {
            $read_stat = NULL;
        }
        // pr($recieved_msg);
        if(!isset($_GET['sent_mail'])) {
            $person_dts = SystemUsers::find_by_id($recieved_msg->sender_id);
        }else {
            $person_dts = SystemUsers::find_by_id($recieved_msg->receiver_id);
        }
    ?>

    <li <?php if(!isset($sent_mail)) {echo ($recieved_msg->receiver_view == 0) ? 'class="unread"' : '';} ?>>
        <a href="read_message.php?sprech=<?php echo $recieved_msg->id; ?><?php echo $read_stat; ?>&eup=rsano3/listing/gs_l=16d&bots=12_4tqy">
            <div class="col-mail col-mail-1">
                <div class="checkbox-wrapper-mail">
                    <input type="checkbox" name="msgKiste[]" class="msgChkbx" value="<?php echo $recieved_msg->id; ?>" id="chk_<?php echo $recieved_msg->id; ?>">
                    <label class="toggle kst_lbl" for="chk_<?php echo $recieved_msg->id; ?>"></label>
                </div>
                <p class="title">
                    <?php
                    echo (isset($_GET['sent_mail']))  ? '<small>To:</small> ' : '';
                    echo $person_dts->full_name;
                    ?>
                </p><span class="star-toggle fa fa-star-o"></span>
            </div>
            <div class="col-mail col-mail-2">
                <div class="subject"><?php echo $recieved_msg->subject; ?> &nbsp;&ndash;&nbsp;
                    <span class="teaser"><?php echo $recieved_msg->message; ?></span>
                </div>
                <div class="date">5:01 am</div>
            </div>
        </a>
    </li>

    <?php
    }  
} else {
    echo '<li>You have no messages</li>';
}

echo display_session_message();


?>