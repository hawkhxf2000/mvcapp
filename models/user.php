<?php

    // What is the difference between include and require?
    // include will not break the code if the file doesn't exist
    // require the code in this fille will not execute if the required file doesn't exist
    
    // __DIR__ gives the path to the current directory: htdocs/mvcapp/models
    // dirname gives the path to the parent directory of the parameter
    //// dirname(__DIR__): htdocs/mvcapp
    
    require(dirname(__DIR__)."/core/database/dbconnectionmanager.php");

    class User {

        public $id;
        public $username;
        public $password;
        public $email;
        public $picture;

        private $conn;

        function __construct(){

            $connectionManager = new DBConnectionManager();

            $this->conn = $connectionManager->getConnection();

        }
        
        // Functions that support the CRUD functionality
        function getAllUsers(){

            $query = "select * from users";

            $statement = $this->conn->prepare($query);           

            $statement->execute();
			
			return $statement->fetchAll(PDO::FETCH_CLASS);           

        }

        // Funtion to get a user by its username
        // when is this function useful:
        //// search YES
        //// Login YES
        //// Sign up -> check if the user already exists
        //// other situations ...

        function getUserbyUsername($username){

            // SQL Injection
            // If the user on the HTML form types a username on a search form
            // it will be passed as parameter to this function
            // the user can inject malicious SQL code
            // If the user types "user1; delete from users;"
            ////  if just append/concatinate the parameter to the main query, the queyr becomes:
            //// "select * from users where username = user1; delete from users;"
            //// the query will cause the deletion of all users data.

            $query = "select * from users where username = :username";

            $statement = $this->conn->prepare($query);           

            $statement->execute([ 'username' => $username ]);
			
			return $statement->fetchAll(PDO::FETCH_CLASS);  //FETCH_ASSOC

        }

        function getUserbyID($id){

//            return "unimplemented";
            $query = "select * from users where id = :id";

            $statement = $this->conn->prepare($query);

            $statement->execute([ 'id' => $id ]);

            return $statement->fetchAll(PDO::FETCH_CLASS);

        }

        function addUser($username, $password, $email, $picture): bool
        {
            $query = "insert into users values (null, :username, :password, :email, :picture)";

            $statement = $this->conn->prepare($query);

            return $statement->execute([
//                'id' => $user->id,
                'username' => $username,
                'password' => $password,
                'email' => $email,
                'picture' => $picture
            ]);

        }

    }// class User

    
    // // Test that the connection to the database works
    //  $user = new User();
    
    //  $result = $user->getAllUsers();

    // var_dump($result);

    // echo "</br>";
    // // $result is an array of associative arrays, 
    // // each associative array is a user record
    // // echo the username of the first user?:
   //  echo($result[0]["username"]);
     


    // With fetchAll(PDO::FETCH_CLASS)
    // the parameter FETCH_CLASS makes the result as an aray of user objects
    // we can do:
    //  $user = $result[0];
    //  echo $user->username;

    // // Yes the below is possible:
    // // $assoc["test"]["v1"] = 100;
    // // var_dump($assoc);
?>