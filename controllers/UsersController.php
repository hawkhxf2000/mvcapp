<?php

   // namespace controllers\User;
    // We need to acces both User Model and View
    require(dirname(__DIR__)."/models/user.php");
    require(dirname(__DIR__)."/views/users.php");

    //Add new user
    if(isset($_POST["username"]) && isset($_POST["password"]) && isset($_POST["email"]))
    {
        $userController = new UsersController();
        $user = new User();

        $username = $_POST["username"];
        $password = $_POST["password"];
        $email = $_POST["email"];

        $userController->add($username, $password, $email);

        new UserView($user->getAllUsers());
    }

    // Controller class
    class UsersController {

        private $data;


        function index($requestmethod, $params, $payload){
            // Get user data so that it is used by the View
            $user = new User();
            
            switch($requestmethod){
                case "GET": if(isset($params[1]) && !empty($params[1])){ 
                                $this->data =  $user->getUserbyID($params[1]);
                            }else
                            $this->data = $user->getAllUsers();
            }



            $userview = new UserView($this->data);

        }

        function add($username, $password, $email){
            $picture = '';

            $user = new User();
            $isSaved = $user->addUser($username, $password, $email, $picture);

            if($isSaved)
            {
                echo "<script>alert(\"The new user has been saved\")</script>";
            }
            else
            {
                echo "<script>alert(\"New user can't be saved, please check again!\")</script>";
            }
        }
    }

    // test controller an view interaction

    // $usercontroller = new UserController();

    // $usercontroller->index();

?>