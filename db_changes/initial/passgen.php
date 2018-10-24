<?php

    $pass = "*HArGB@@1982";
    $username = "harvey.fletcher@reassured.co.uk";

    $passlen = strlen($pass);
    $userlen = strlen($pass);

    if($passlen >= $userlen){
        $short = $passlen;
    } else {
        $short = $userlen;
    }

    $pass = substr($pass, 0, $short);
    $username = substr($username, 0, $short);

    $token = "";

    for($i=0; $i<$short; $i++){
        $token .= $pass[$i] . $username[$i];
    }

    $token = password_hash($token, PASSWORD_DEFAULT);

    echo $token . PHP_EOL;
