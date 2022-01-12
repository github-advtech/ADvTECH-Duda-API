<?php

function fetch($url = "", $data = [], $token = '', $is_post = true, $is_auth_basic = false, $auth_basic_data = null, $content_type = ContentType::JSON)
{
    if ($content_type == ContentType::X_WWW_FORM_URLENCODED) {
        
        $post_data = '';
        $index = 0;
        foreach($data as $key => $val) {
            $post_data .= ($index > 0) ? '&'.$key.'='.$val : $key.'='.$val;
            $index++; 
        }

    } else {
        $post_data = json_encode($data);
    }
    
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
    
        Logger::error("Results: ". curl_error($crl));
        die;
    } else {
        $result = json_decode($result);
        return $result;
    }
}