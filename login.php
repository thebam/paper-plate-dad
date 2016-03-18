<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "includes/recipeConnection.php";
$error = '';
if(count($_POST)>0){
    $username = $_POST['username'];
    $password = $_POST['password'];
    $hash = crypt($password,'hamburger');
    $guid = "";
     $connection = openConnection();
            $query = 'SELECT GUID FROM cooks WHERE Username=? AND Password=?';
            $cooks = $connection->prepare($query);
            $cooks->bind_param('ss',$username,$hash);
            $cooks->execute();
            $results = $cooks->get_result();
            if($results->num_rows===1){
                $guid = "";
                while ($row = $results->fetch_array())
                {
                    $guid = $row["GUID"];
                }
                $_SESSION["id"] = $guid;
                $_SESSION["username"] = $username;
            }
            $connection->close();
            
            
            if($guid != ""){
            header('Location: index.php');
            }
}
$pageTitle = "Login";
require_once 'includes/header.php';
?>
<div class="container">
        <h1>LOGIN</h1>
        <p><?=$error?></p>
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