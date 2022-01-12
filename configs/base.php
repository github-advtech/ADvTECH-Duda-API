<?php
header("Access-Control-Allow-Origin: *");
header("Content-type: application/json");

$username = '9349f4ef03';
$password = 'Y6giX3';
$siteId = "a1456bfc";
$storeId = "52235119";
$store_auth_token = "secret_nPHqUAbMmW1hSRpEaWjXMGe2YuifKJ9z";

$req = file_get_contents('php://input');
$req = json_decode($req);
$status = $req->data->data->newPaymentStatus;
$event_type = $req->event_type;
$orderId = $req->data->data->orderId;

if ($event_type = 'STORE_ORDER_UPDATED' && $status === 'PAID' && !empty($orderId)) {
    
    //$token_object = fetch("https://api.duda.co/api/store/{$siteId}/accessData");

    $order = fetch("https://app.ecwid.com/api/v3/{$storeId}/orders/{$orderId}?token={$store_auth_token}", [], '', false);
    
    if ($order != null) {
        
        $customer = [
            'email' => "lannon@epicdev.co.za",
            'firstName' => $order->billingPerson->firstName,
            'lastName' => $order->billingPerson->lastName,
            'businessUnitId' => 142
        ];

        $ink_token_object = fetch('https://lobster-access.com/sts/connect/token', 
        [
            'client_id' => 'capsicum-userprovisioning-prod', 
            'client_secret' => 'c1cbe61c-7bd4-d3e2-a027-85fdff9449e0', 
            'grant_type' => 'client_credentials', 
            'scope' => 'user_provisioning'
        ], '', true, false, null, 'Content-Type: application/x-www-form-urlencoded');

        if ($ink_token_object != null && !empty($ink_token_object->access_token)) {

            $user_invite_object = fetch('https://hospitalityfutures.lobster-access.com/userprovisioning/api/invite', 
            $customer, $ink_token_object->access_token, true, false, null, 'Content-Type: application/json');

            if ($user_invite_object != null && !empty($user_invite_object->requestId)) {
                // SUCCESS
            } else {
                // ERROR
            }
        }
    
        file_put_contents(str_replace("/", "-", $_SERVER['REQUEST_URI']) . time() . ".txt", json_encode($customer)."\n".json_encode($ink_token_object)."\n".json_encode($user_invite_object));
    }
    
}




function fetch($url = "", $data = [], $token = '', $is_post = true, $is_auth_basic = false, $auth_basic_data = null, $content_type = 'Content-Type: application/json')
{
    if ($content_type == 'Content-Type: application/x-www-form-urlencoded') {
        $post_data = '';
        $index = 0;
        foreach($data as $key => $val) {
            $post_data .= ($index > 0) ? '&'.$key.'='.$val : $key.'='.$val;
            $index++; 
        }
    } else {
        $post_data = json_encode($data);
    }
    file_put_contents("token.txt", $post_data."\n". $token);
    // Prepare new cURL resource
    $crl = curl_init($url);
    curl_setopt($crl, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($crl, CURLINFO_HEADER_OUT, true);
    curl_setopt($crl, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($crl, CURLOPT_SSL_VERIFYPEER, false);

    if ($is_post) {
        curl_setopt($crl, CURLOPT_POST, true);
        curl_setopt($crl, CURLOPT_POSTFIELDS, $post_data);
    }
    
    if ($is_auth_basic && $auth_basic_data != null) {
        curl_setopt($crl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($crl, CURLOPT_USERPWD, "{$auth_basic_data['username']}:{$auth_basic_data['password']}");
    }

    $headers = [
        $content_type
    ];

    if (!empty($token)) {
        $headers[] = 'Authorization: Bearer '.$token;
    }

    // Set HTTP Hcurl_setopt($crl, CURLOPT_POST, true);eader for POST request
    curl_setopt($crl, CURLOPT_HTTPHEADER, $headers);

    // Submit the POST request
    $result = curl_exec($crl);
    curl_close($crl);
    // handle curl error
    if ($result === false) {
        // throw new Exception('Curl error: ' . curl_error($crl));
        print_r('Curl error: ' . curl_error($crl));
        echo "Err";
        die;
    } else {
        $result = json_decode($result);
        return $result;
    }
}

die;
