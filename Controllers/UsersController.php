<?php

    class Users{
        function Login(){
            global $api;
            global $db;

            //Include the onelogin api classfile
            include_once('../vendors/onelogin/onelogin.php');
            $auth = new auth();

            //These fields are required for this function, check they are present
            $api->checkRequiredFields( array( 'username', 'password' ) );

            // Make a new call to the onelogin function. The code will not progress
            // beyond this point if the login is unssuccessful. That is handled
            // within the auth->login function.
            $user = $auth->login( $api->read()->username, $api->read()->password );

            //Do we have a user in the table with the onelogin id of that user?
            $query = $db->prepare("SELECT * FROM users WHERE onelogin_id=:id");
            $query->bindParam( ":id", $user["user"]["id"] );
            $query->execute();

            if( $query->rowCount() != 1){
                //The user has not signed on before. Tell the client to present the user
                //account creation form.
                $output = array(
                        "first_login" => 1,
                        "user" => array(
                                "email"       => $api->read()->username,
                                "onelogin_id" => $user["user"]["id"],
                                "token"       => $user["user"]["session_token"],
                            )
                    );

                //Send the output back to the user
                $api->stdOut(200, $output);
            } else {
                //The user has signed on before, send back their details from the database
                $storedUserDetails = $query->fetchAll( PDO::FETCH_ASSOC )[0];

                //now, we need to update the user record in the database with the new session token
                $update = $db->prepare("UPDATE users SET token=:session_token WHERE id=:id");
                $update->bindParam(":session_token", $user["session_token"]);
                $update->bindParam(":id", $storedUserDetails["id"]);
                $update->execute();

                //Now, re-get the user details
                $query->execute();

                //The user has signed on before, send back their details from the database
                $storedUserDetails = $query->fetchAll( PDO::FETCH_ASSOC )[0];

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
