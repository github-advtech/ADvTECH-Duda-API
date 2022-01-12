<?php

require "configs/bootstrap.php";

$store_auth_token = "";

list($status, $event_type, $orderId) = get_request();

Logger::log("New Request Init");

if ($event_type = OrderEventType::STORE_ORDER_UPDATED && $status === OrderStatus::PAID && !empty($orderId)) {

    Logger::log("Getting Duda Store Token");

    $token_object = fetch(DUDA_STORE_TOKEN_URL, [], '', false, true, ["username" => USERNAME, "password" => PASSWORD], ContentType::JSON);

    if ($token_object === null || empty($token_object->oauth_token_v3)) {
        Logger::error("Could not get Duda Store token ". json_encode($token_object));
        send_error_response();
    };

    $store_auth_token = $token_object->oauth_token_v3;

    Logger::log("Got Duda Store Token". $store_auth_token);

    $order = fetch(ECWID_URL.STOREID."/orders/{$orderId}?token={$store_auth_token}", [], '', false);

    Logger::log("Got Order");

    if ($order === null || isset($order->billingPerson)) {
        Logger::error("Order not found from Duda Orders". json_encode($order));
        send_error_response(404);
    };
        
    $customer = [
        'email' => "lannon@epicdev.co.za",
        'firstName' => $order->billingPerson->firstName,
        'lastName' => $order->billingPerson->lastName,
        'businessUnitId' => 142
    ];

    Logger::log("Init Customer". json_encode($customer));

    $ink_token_object = fetch(LOBSTER_TOKEN_URL, 
    [
        'client_id' => LOBSTER_TOKEN_CLIENT_ID,
        'client_secret' => LOBSTER_TOKEN_CLIENT_SECRET,
        'grant_type' => 'client_credentials',
        'scope' => 'user_provisioning'
    ], '', true, false, null, ContentType::X_WWW_FORM_URLENCODED);

    if ($ink_token_object === null || empty($ink_token_object->access_token)) {
        Logger::error("Could Not Get Lobster Ink Access Token". json_encode($order));
        send_error_response(400);
    };

    Logger::log("Got Ink Token". $ink_token_object->access_token);

    $user_invite_object = fetch(LOBSTER_USER_INVITE_URL, 
    $customer, $ink_token_object->access_token, true, false, null, ContentType::JSON);

    if ($user_invite_object === null || empty($user_invite_object->requestId)) {
        Logger::error("User Invite Failed. ". json_encode($user_invite_object)." did not containt the RequestID");
        send_error_response(400);
    };

    Logger::log("Success Operation for orderId: {$orderId} ". json_encode($user_invite_object));
    echo json_encode(["status" => 201, "message" => "Success Operation for orderId: {$orderId} "]);
    http_response_code(200);
    die;
}

http_response_code(200);
die;