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
    }
