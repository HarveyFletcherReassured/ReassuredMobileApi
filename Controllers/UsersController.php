<?php

    class Users{
        function Login(){
            global $api;
            global $db;

            //Include the onelogin api classfile
            include_once('../vendors/onelogin/onelogin.php');
            $auth = new auth();

            // Make a new call to the onelogin function. The code will not progress
            // beyond this point if the login is unssuccessful. That is handled
            // within the auth->login function.
            $user = $auth->login( $api->read()->username, $api->read()->password );

            //Do we have a user in the table with the onelogin id of that user?
            $query = $db->prepare("SELECT * FROM users WHERE onelogin_id=:id");
            $query->bindParam( ":id", $user["user"]["id"] );
            $storedUserDetails = $query->execute();

            if( $query->rowCount() != 1){
                //The user has not signed on before. Tell the client to present the user
                //account creation form.
                $output = array(
                        "first_login" => 1,
                        "user" => array(
                                "email"       => $api->read()->username,
                                "onelogin_id" => $user["id"],
                            )
                    );

                //Send the output back to the user
                $api->stdOut(200, $output);
            } else {
                //The user has signed on before, send back their details from the database
                $storedUserDetails = $storedUserDetails->fetchAll( PDO::FETCH_ASSOC )[0];

                //Set up the output array
                $output = array(
                        "first_login" => 0,
                        "user" => $storedUserDetails
                    );

                //Output to client
                $api->stdOut(200, $output);
            }
        }
    }
