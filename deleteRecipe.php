<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
if(!isset($_SESSION["id"]) || !isset($_SESSION["username"])){
    header('Location: index.php');
}
require_once "includes/recipe.php";

if(count($_GET)>0){
    $id=$_GET['id'];
    $id = intval($id);
        Cooking\Recipe::deleteRecipe($id);
        header('Location: index.php');
}

?>