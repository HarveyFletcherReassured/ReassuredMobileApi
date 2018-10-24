<?php

    /**
    * This file contains the database connection,
    * It has been written once with null values and
    * committed to file tracking. Do not commit it
    * again. But if you have to, check you have made
    * the username and password for the database
    * null values.
    **/

    //These are the database credentials
    $database_host = "127.0.0.1";
    $database_user = "";
    $database_pass = "";
    $database_name = "reassured_app";

    //Try to create a new connection object
    try{
        $db = new PDO('mysql:host=' . $database_host . ';dbname=' . $database_name, $database_user, $database_pass);
    } catch(PDOException $ex){
        //If it fails, kill the api connection with 503 service unavailable
        $api->stdOut( 503, "The database service is unavailable.");
    }
