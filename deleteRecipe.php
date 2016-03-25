<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
if(!isset($_SESSION["id"]) || !isset($_SESSION["username"])){
    header('Location: index.php');
}
require_once "includes/recipe.php";
$id=0;
$confirm="n";
if(count($_GET)>0){
    $id=$_GET['id'];
    if (isset($_GET['con'])){
        $confirm=$_GET['con'];
        if($confirm == "y"){
            $id = intval($id);
            Cooking\Recipe::deleteRecipe($id);
            header('Location: index.php');
        }
    }
}
$pageTitle = "Delete recipe";
require_once 'includes/header.php';
?>
    <div class="container">
        <h1>Delete Recipe</h1>
        <p>Are you sure you want to delete this recipe?</p>
        <a class="btn btn-default" href="deleteRecipe.php?id=<?=$id?>&con=y">delete</a>
        <a class="btn btn-default" href="index.php">cancel</a>
    </div>       
<?php
require_once 'includes/footer.php';
?>