<?php

    class api{
        function stdOut( $status, $data ){
            //Set the HTTP response code
            http_response_code( $status );

            //Build the response array
            $responseArray = array(
                    "status" => $status,
                    "data"   => $data,
                );

            //Encode the response as JSON
            $responseArray = json_encode( $responseArray );

            //Return the output to the user
            echo $responseArray;

            //Quit the program.
            exit;
        }

        function listAvailableControllers(){
            //Get all the files in the controllers directory, but not . and ..
            $Controllers = preg_grep('/^([^.])/', scandir( '../Controllers/' ) );;

            //Replace all occurences of the word "Controller"
            $Controllers = str_replace('Controller.php', '', $Controllers);

            //Return the sanitised list of controllers
            return $Controllers;
        }

        function read(){
            //Get the json from the php input
            $parameters = file_get_contents( "php://input" );

            //Decode the json to be a php object
            $parameters = json_decode($parameters);

            //Return the decoded object
            return $parameters;
        }

        function postRequest( $url, $postFields, $auth ){
            $curl = curl_init();

            curl_setopt_array($curl, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_ENCODING => "",
                    CURLOPT_MAXREDIRS => 10,
                    CURLOPT_TIMEOUT => 30,
                    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                    CURLOPT_CUSTOMREQUEST => "POST",
                    CURLOPT_POSTFIELDS => json_encode( $postFields ),
                    CURLOPT_HTTPHEADER => array(
                            "Content-Type: application/json",
                            "cache-control: no-cache",
                            $auth
                        ),
                )
            );

            return json_decode( curl_exec( $curl ), true );
        }
    }
