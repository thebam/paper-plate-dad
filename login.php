<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "includes/recipeConnection.php";
$error = '';
if(count($_POST)>0){
    $username = $_POST['username'];
    $password = $_POST['password'];
    if(!empty(trim($username)) && !empty(trim($password))){
        $hash = crypt($password,'hamburger');
        $guid = "";
        $connection = openConnection();
        $query = 'SELECT GUID FROM cooks WHERE Username=:username AND Password=:password';
        $statement = $connection->prepare($query);
        $statement->bindParam(':username',$username,\PDO::PARAM_STR);
        $statement->bindParam(':password',$hash,\PDO::PARAM_STR);
        $statement->execute();
        if($statement->rowCount()===1){        
            while ($row = $statement->fetchObject())
            {
                $guid = $row->GUID;
            }
        }else{
            $error="The username or password you entered was not correct.";
        }
        $connection=null;    
            
        if($guid != ""){
            $_SESSION["id"] = $guid;
            $_SESSION["username"] = $username;
            header('Location: index.php');
        }else{
            $error="The username or password you entered was not correct.";
        }
    }else{
        $error="Enter a username and password to login.";
    }
}
$pageTitle = "Login";
require_once 'includes/header.php';
?>
<div class="container">
    <h1>LOGIN</h1>
    <p class="error"><?=$error?></p>
    <form action="login.php" method="post" role="form">
        <div class="form-group">
            <label for="username">Username:</label>
            <input type="text" name="username" class="form-control"  required/>
        </div>
        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" class="form-control"  required/>
        </div>    
        <input type="submit" value="Login" class="btn btn-default" />
    </form>
</div>
<?php
require_once 'includes/footer.php';
?>