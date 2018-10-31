<?php
    require '../../private/paystack/src/autoload.php';

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
        print_r("succeffully chhargeddd");
        echo "successfull transaction";
    }
?>