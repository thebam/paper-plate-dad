<?php
require_once "includes\recipe.php";

if(count($_GET)>0){
    $id=$_GET['id'];
    $id = intval($id);
        Cooking\Recipe::deleteRecipe($id);
        header('Location: index.php');
}

?>