<?php

    //The API will be returning JSON
    header('Content-Type: application/json');

    //There is an input/output controller here
    include '../ApiFiles/api.php';
    $api = new api();

    //This is a list of controllers we want the user to have access to.
    $api->listAvailableControllers();

    //Get the request, explode it into the different parameters, and remove blanks
    $params = array_values( array_filter( explode( '/', $_SERVER['REQUEST_URI'] ) ) );

    //Check the user has requested a valid controller
    if( !in_array( $params[0], $api->listAvailableControllers() ) ){
        $api->stdOut( 405, "The controller `" . $params[0] ."` does not exist." );
    }

    //Load the controller
    include '../Controllers/' . $params[0] . 'Controller.php';

    //Load the class from the controller we just loaded
    $Controller = new $params[0]();
    $Function   = $params[1];

    //Check that the requested function exists
    if( !in_array( $Function, get_class_methods( $Controller ) ) ){
        $api->stdOut( 405, "The function `" . $Function . "` does not exist." );
    }

    /**
    * If the user has made it this far, the controller exists, and within the controller
    * exists the requested function. No further controller or function validation is beyond
    * this point. Parameter checking must be done within the requested function.
    **/

    //Make a call to execute the function.
    $Controller->$Function();
