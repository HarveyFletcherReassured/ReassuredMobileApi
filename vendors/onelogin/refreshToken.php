<?php

    //Serve locale is en/gb
    date_default_timezone_set('Europe/London');

    //Include the api keys file
    include '../../ApiFiles/keys.php';

    //Include the api class so we can make post requests
    include '../../ApiFiles/api.php';

    //Include the database class so we can store the updated token in the database
    include '../../ApiFiles/database.php';

    //Create a new api object
    $api = new api();

    //This is the URL for the auth token generation page.
    $url = 'https://api.us.onelogin.com/auth/oauth2/v2/token/';

    //This is the authorization string
    $auth = "Authorization: client_id:". $apiKeys["oneLogin"]["client_id"] .", client_secret:" . $apiKeys["oneLogin"]["client_secret"];

    //This is the postfields that are needed by the onelogin api to generate a token
    $postFields = array(
            "grant_type" => "client_credentials"
        );

    //Make the post request to obtain the token and refresh token
    $result = $api->postRequest( $url, $postFields, $auth );

    //Store the tokens as variables
    $access_token  = $result["access_token"];
    $refresh_token = $result["refresh_token"];

    //Regenerate the postfields for the auth token refresh page
    $postFields = array(
            "grant_type"    => "refresh_token",
            "access_token"  => $access_token,
            "refresh_token" => $refresh_token,
        );

    //Make a new post request to the token page using the new post fields to refresh the token
    $result = $api->postRequest( $url, $postFields, $auth );

    //This is the current time
    $nowTime = date('Y-m-d H:i:s');

    //Now we need to store that token in the database;
    $statement = $db->prepare("UPDATE service_tokens SET token=:token, updated=:now WHERE id=1");
    $statement->bindParam(":token", $result["access_token"]);
    $statement->bindParam(":now", $nowTime );
    $statement->execute();
