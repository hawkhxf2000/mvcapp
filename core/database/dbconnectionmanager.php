<?php

    class DBConnectionManager{

        private $conn;
		private $host;
		private $user;
		private $password;
		private $dbname;

        function __construct(){
            $config = simplexml_load_file(__DIR__.'/config.xml');           

			$this->host = $config->host;

            // Instead of storing the user in the XML file
            // which is less secure we could store the user and passowrd 
            // in an environment variable
            // and then read it in this code
			$this->user = $config->user;

            // In the command prompt of Windows set an environment vairable
            // c:/>set mvcuser=root
            // Then in PHP you read the environment variable:

           // $this->user = getenv("mvcuser");
			$this->password = $config->password;
			$this->dbname = $config->dbname;
        }

        function getConnection(){

            // We will use the PDO PHP library to onnect to the database
            try{
			
				$this->conn = new PDO("mysql:host=".$this->host.";dbname=".$this->dbname,$this->user,$this->password);
				
			} catch(PDOException $exception){
				
                echo "Database Connection error: " . $exception->getMessage();
               
           }         

           return $this->conn;

        }

    }

?>