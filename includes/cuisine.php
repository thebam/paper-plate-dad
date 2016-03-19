<?php
namespace Cooking;
require_once "config.php";
require_once "recipeConnection.php";
class Cuisine
{
    public static function getAllCuisines(){
        $cuisines=array();
        
            $connection = openConnection();
            $statement = $connection->prepare('SELECT Id, Title FROM Cuisines ORDER BY Title');
            $statement->execute();
            $results = $statement->setFetchMode(\PDO::FETCH_ASSOC);
            if($results){
                while ($row = $statement->fetch()) {
                    $cuisines[]=$row;
                }
            }
            $connection=null;
        
        return ($cuisines);
    }
}
?>