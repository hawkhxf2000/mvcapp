<!DOCTYPE HTML>
<HTML>
<head>
    <style>
    table, th, td {
    border:1px solid black;
    }
    </style>
</head>
<body>

    <h1> This is a user View</h1>
    <hr>

    <h2>Add a new user</h2>

    <form action="../controllers/UsersController.php" method="post">
<!--        <label for="id">id</label>-->
<!--        <input type="number" name="id"><br>-->
        <label for="username">username</label>
        <input type="text" name="username"><br>
        <label for="password">password</label>
        <input type="password" name="password"><br>
        <label for="email">email</label>
        <input type="text" name="email"><br>
<!--        <label for="picture">picture</label>-->
<!--        <input type="file" name="picture"><br>-->
        <input type="submit" value="submit">
    </form>
    <hr>
    <h2>List user</h2>
    <?php
    
        // This code will display the User data in a table
        // The table will be built dynamically
        class UserView{

          public $data;

          function __construct($data){

            $this->data = $data;

            $this->render();

          }

          function render(){
            $html = "<table>";
            $html .= "<tr>";
            $html .= "<td>username</td>
                      <td>password</td>
                      <td>email</td>";
            $html .= "</tr>";
    
            foreach($this->data as $user){
    
              $html .= "<tr>";
              $html .= "<td>".$user->username."</td>"
                       ."<td>".$user->password."</td>"
                       ."<td>".$user->email."</td>";
              $html .= "</tr>";         
    
            }
            $html .= "<table>";
    
            echo $html;
    
          }

        }
        

    ?>

</body>

</HTML>