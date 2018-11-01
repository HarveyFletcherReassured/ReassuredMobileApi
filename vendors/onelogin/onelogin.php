<?php

    /**
    * This class will contain all the api calls related to the onelogin
    * api. It can be accessed like this:
    *
    *    $auth = new auth();
    *    $auth->login( $username, $password );
    *
    *
    * The function will do the rest.
    *
    **/

    class auth{
        function login( $username, $password ){
            global $db;
            global $api;
            global $apiKeys;

            //We need to get the service_token for this service
            $stmt    = $db->prepare("SELECT * FROM service_tokens WHERE id = 1");
            $stmt->execute();
            $service = $stmt->fetchAll( PDO::FETCH_ASSOC )[0];

            //Build the postfields array
            $postFields = array(
                    "username_or_email" => $username,
                    "password"          => $password,
                    "subdomain"         => $apiKeys["oneLogin"]["subdomain"],
                );

            //Using those fields, make a post request to the login endpoint
            $loginResult = $api->postRequest( $apiKeys["oneLogin"]["stub"] . "login/auth", $postFields, "Authorization: ". $service["type"] ." " . $service["token"] );

            //Did the login fail?
            if( $loginResult["status"]["code"] != 200 ){
                $api->stdOut( $loginResult["status"]["code"], $loginResult["status"]);
            } else {
                return $loginResult["data"][0];
            }
        }
    }
