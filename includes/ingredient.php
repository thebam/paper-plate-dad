<?php
namespace Cooking;
require_once "config.php";
require_once "recipeConnection.php";
class Ingredient
{
    public static function getAllIngredients(){
        $ingredients=array();
        
            $connection = openConnection();
            $statement = $connection->prepare('SELECT Id, Title FROM Ingredients ORDER BY Title');
            $statement->execute();
            $results = $statement->setFetchMode(\PDO::FETCH_ASSOC);
            if($results){
                while ($row = $statement->fetch()) {
                    $ingredients[]=$row;
                }
            }
            $connection=null;
        
        return ($ingredients);
    }
}
?>