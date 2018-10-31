<?php
    require '../../private/paystack/src/autoload.php';
    require '../../private/initialize.php';

    // echo $_REQUEST['ref'];
    $ref = isset($_POST['ref']) ? $_POST['ref'] : "";

    if(!$ref){
        header("location: ./index.php");
    }
    

    $paystack = new Yabacon\Paystack('sk_test_aa1fd1d990fe45a927c258c2c24e59c61ac3633c');

    try{
        $responseObj = $paystack->transaction->verify(["reference"=> $ref ]);
    }catch(Exception $e) {
        print_r($e->getMessage());
    }

    if ('success' === $responseObj->data->status) {
        echo "Successfull transaction";
        print_r ($responseObj);
    }
     
    $card_type = $responseObj->data->authorization->card_type;
    $authorization_code = $responseObj->data->authorization->authorization_code;
    $bank = $responseObj->data->authorization->bank;
    $country_code = $responseObj->data->authorization->country_code;
    $last4 = $responseObj->data->authorization->last4;
    $brand = $responseObj->data->authorization->brand;
    $exp_month = $responseObj->data->authorization->exp_month;
    $exp_year = $responseObj->data->authorization->exp_year;
    $user_id = $_SESSION['sys_user_id'];

    $sql = "INSERT INTO `user_card` (user_id, authorization_code, card_type, bank, country_code, last4, brand, exp_month, exp_year) VALUES ('{$user_id}', '{$authorization_code}', '{$card_type}', '{$bank}', '{ $country_code}', '{ $last4}', '{$brand}', '{$exp_month}', '{$exp_year}')";
    $result = self::$database->query($sql);
    if(!$result) {
        echo ' error saving card';
    }
?>
