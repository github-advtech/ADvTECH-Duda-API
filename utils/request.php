<?php

function get_request() {

    $req = file_get_contents('php://input');
    $req = json_decode($req);

    if (isset($req) && isset($req->data)) {

        $status = $req->data->data->newPaymentStatus;
        $event_type = $req->event_type;
        $orderId = $req->data->data->orderId;
    
        return [$status, $event_type, $orderId];
    }

    return [null, null, null];
}