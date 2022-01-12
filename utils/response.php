<?php

function send_error_response($status_code = 400) {

    echo json_encode(["status" => $status_code, "message" => "Check Error Log file for more information"]);
    http_response_code($status_code);
    die;
}