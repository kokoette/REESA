<?php 

if(isset($_POST['inbxCount'])) {
	require_once('../../private/initialize.php');

    $unrd_msg_cnt = 0;
    $inbx_countish = Message::get_person_msg('receiver');
    if($inbx_countish) {
        foreach ($inbx_countish as $inbx_count) {
            if($inbx_count->receiver_view == 0) {
                $unrd_msg_cnt++;
            }
        }
    }

	echo $unrd_msg_cnt;
}
?>