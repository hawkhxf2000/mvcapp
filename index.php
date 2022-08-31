<?php

// All the cannonical URLs will be rewritten to be pointing to this index file
// in this index file we determine the controller that is being requested based on the resource e.g., users
// then we will dynamically load the required controller

// How do we load a class dynamically (since we don't know the name of the controller in advance)?
// instead of using the controller name variable and concatenating it with a path in a require function call
// instead of doing require('.../controllers/'.$controllername.'.php') for each controller
// we will use a method called spl_autoload_register that will load a class when that class is used in the code

    spl_autoload_register(
        function ($class_name) { 
            include(__DIR__.'/controllers/'.$class_name.'.php'); 
        }
    );


// How do we determine which controller to load?
// 1- implement rewrite rules
// 2- get the controller name from the URL e.g., index.php?users where users would be the controller name


    // Note that the $_GET array is populated even if the HTTP request method is POST or other methods.
    
    $paramsArray = array();
    $controllerName = "";

    if(isset($_GET["params"])) //params=users=1 -> $_GET["params"] = 'users=1'
        // Transform the URL parameters from a string into an array
        $paramsArray = explode("=", $_GET["params"]); //  $paramsArray = ['users','1']


    // htmlentities transforms the input by the user either from the URL or in a form's text field into
    // just character symbols, to prevent malicious code injection.
//    $controllername = ucfirst(htmlentities($paramsArray[0]))."Controller";
    $controllerName = ucfirst(htmlentities($paramsArray[0]))."Controller";   //"Users"."Controller" = "UsersController" = $controllerName

    if(file_exists(__DIR__.'/controllers/' .$controllerName. '.php')){

        if(class_exists($controllerName)){

            $controllerName = new $controllerName();

            // Pass to the controller the request info and data

            // How do we get the body/payload of the HTTP post request?

            $payload =  file_get_contents('php://input');

            if($paramsArray[1] =='adduser')
            {
                header('Location:localhost/mvcapp/views/users.php');
            }

            if(is_numeric($paramsArray[1]))
            {
                $controllerName->index($_SERVER['REQUEST_METHOD'], $paramsArray, $payload);
            }
        
        }       
    }


?>