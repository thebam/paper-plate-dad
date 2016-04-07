<?php
namespace Cooking;
require_once "config.php";
require_once "recipeConnection.php";
class Recipe
{
    public $id;
    public $title;
    public $mainIngredientId;
    public $cuisineId;
    public $cuisineName;
    public $url;
    public $tasteRating;
    public $notes;
    public $dateModified;
    
    public $imageUrl;
    public $videoUrl;
    public $prepRating;
    public $cleanRating;
    public $servings;
    public $prepTimeInMinutes;
    public $description;
    public $ingredients = array();
    public $quantities = array();
    public $instructions = array();

    public static function addRecipe($tempTitle, $tempMainIngredientId,$tempCuisineId,$tempUrl,$tempTaste,$tempNotes,$tempImage,$tempVideo,$tempPrep,$tempClean,$tempIngredients,$tempQuantities,$tempSteps,$tempServings,$tempPrepTime,$tempDesc,$tempNewCuisine,$tempNewIngredients){
        $output="";
        if(!empty(trim($tempTitle)))
        {
            $connection = openConnection();
            
            if($tempCuisineId=="0"){
                $query = 'INSERT INTO Cuisines (Title) VALUES (:title)';
                $statement = $connection->prepare($query);
                $statement->bindParam(':title',$tempNewCuisine, \PDO::PARAM_STR);
                
                $statement->execute();
                if($connection->lastInsertId()){
                    $tempCuisineId = $connection->lastInsertId();
                }
            }
            
            
            $query = 'INSERT INTO recipes (Title, MainIngredientId,CuisineId,Url,TasteRating,Notes,ImageUrl,VideoUrl,PrepRating,CleanRating,Servings,PrepTime,Description) VALUES (:title,:mainIngredientId,:cuisineId,:url,:tasteRating,:notes,:imageUrl,:videoUrl,:prepRating,:cleanRating,:servings,:prepTime,:description)';
            $statement = $connection->prepare($query);
            $statement->bindParam(':title',$tempTitle, \PDO::PARAM_STR);
            $statement->bindParam(':mainIngredientId',$tempMainIngredientId, \PDO::PARAM_INT);
            $statement->bindParam(':cuisineId',$tempCuisineId, \PDO::PARAM_INT);
            $statement->bindParam(':url',$tempUrl, \PDO::PARAM_STR);
            $statement->bindParam(':tasteRating',$tempTaste, \PDO::PARAM_INT);
            $statement->bindParam(':notes',$tempNotes, \PDO::PARAM_STR);
            $statement->bindParam(':imageUrl',$tempImage, \PDO::PARAM_STR);
            $statement->bindParam(':videoUrl',$tempVideo, \PDO::PARAM_STR);
            $statement->bindParam(':prepRating',$tempPrep, \PDO::PARAM_INT);
            $statement->bindParam(':cleanRating',$tempClean, \PDO::PARAM_INT);
            $statement->bindParam(':servings',$tempServings, \PDO::PARAM_INT);
            $statement->bindParam(':prepTime',$tempPrepTime, \PDO::PARAM_INT);
            $statement->bindParam(':description',$tempDesc, \PDO::PARAM_STR);
            $statement->execute();
            if($connection->lastInsertId()){
                $id = $connection->lastInsertId();
                if(count($tempIngredients) > 0){
                    if(count($tempIngredients) == count($tempQuantities)){
                        for ($x=0;$x<count($tempIngredients);$x++) {
                            if($tempIngredients[$x]=="0"){
                                $query = 'INSERT INTO Ingredients (Title) VALUES (:title)';
                                $statement = $connection->prepare($query);
                                $statement->bindParam(':title',$tempNewIngredients[$x], \PDO::PARAM_STR);
                                
                                $statement->execute();
                                if($connection->lastInsertId()){
                                    $tempIngredients[$x] = $connection->lastInsertId();
                                }
                                
                            }
                            
                            
                            $query = 'INSERT INTO recipeIngredients (RecipeId, IngredientId,Quantity) VALUES (:id,:ingredientId,:quantity)';
                            $statement = $connection->prepare($query);
                            $statement->bindParam(':id',$id, \PDO::PARAM_INT);
                            $statement->bindParam(':ingredientId',$tempIngredients[$x], \PDO::PARAM_INT);
                            $statement->bindParam(':quantity',$tempQuantities[$x], \PDO::PARAM_STR);
                            $statement->execute();
                        }
                    }
                }
                if(count($tempSteps) > 0){
                    for ($x=0;$x<count($tempSteps);$x++) {
                        $query = 'INSERT INTO steps (RecipeId, Description ,DisplayOrder) VALUES (:id,:description,:displayOrder)';
                        $statement = $connection->prepare($query);
                        $statement->bindParam(':id',$id, \PDO::PARAM_INT);
                        $statement->bindParam(':description',$tempSteps[$x], \PDO::PARAM_STR);
                        $statement->bindParam(':displayOrder',$x, \PDO::PARAM_INT);
                        $statement->execute();
                    }
                }
                $output ="success";
            }else{
                $output ="failed";
            }
            $connection=null;
        }
        return $output;
    }
    public static function deleteRecipe($id){
        if(!empty(trim($id)))
        {
            $connection = openConnection();
            $query = "DELETE FROM steps WHERE RecipeId = :id";
            $statement = $connection->prepare($query);
            $statement->bindParam(':id',$id, \PDO::PARAM_INT);
            $statement->execute();
            
            $query = "DELETE FROM recipeIngredients WHERE RecipeId = :id";
            $statement = $connection->prepare($query);
            $statement->bindParam(':id',$id, \PDO::PARAM_INT);
            $statement->execute();
            
            $query = "DELETE FROM recipes WHERE Id = :id";
            $statement = $connection->prepare($query);
            $statement->bindParam(':id',$id, \PDO::PARAM_INT);
            $statement->execute();
            $connection=null;
        }
    }
    
    public static function editRecipe($id,$tempTitle, $tempMainIngredientId,$tempCuisineId,$tempUrl,$tempTaste,$tempNotes,$tempImage,$tempVideo,$tempPrep,$tempClean,$tempIngredients,$tempQuantities,$tempSteps,$tempServings,$tempPrepTime,$tempDesc,$tempNewCuisine,$tempNewIngredients){
        if(!empty(trim($id)) && !empty(trim($tempTitle)))
        {
            $connection = openConnection();
            
            if($tempCuisineId=="0"){
                $query = 'INSERT INTO Cuisines (Title) VALUES (:title)';
                $statement = $connection->prepare($query);
                $statement->bindParam(':title',$tempNewCuisine, \PDO::PARAM_STR);
                
                $statement->execute();
                if($connection->lastInsertId()){
                    $tempCuisineId = $connection->lastInsertId();
                }
            }
            
            
            $query = 'UPDATE recipes SET Title=:title, MainIngredientId=:mainIngredientId,CuisineId=:cuisineId, Url=:url,TasteRating=:tasteRating,Notes=:notes,ImageUrl=:imageUrl,VideoUrl=:videoUrl,PrepRating=:prepRating,CleanRating=:cleanRating,Servings=:servings,PrepTime=:prepTime,Description=:description WHERE id=:id';
            
            $statement = $connection->prepare($query);
            $statement->bindParam(':title',$tempTitle, \PDO::PARAM_STR);
            $statement->bindParam(':mainIngredientId',$tempMainIngredientId, \PDO::PARAM_INT);
            $statement->bindParam(':cuisineId',$tempCuisineId, \PDO::PARAM_INT);
            $statement->bindParam(':url',$tempUrl, \PDO::PARAM_STR);
            $statement->bindParam(':tasteRating',$tempTaste, \PDO::PARAM_INT);
            $statement->bindParam(':notes',$tempNotes, \PDO::PARAM_STR);
            $statement->bindParam(':imageUrl',$tempImage, \PDO::PARAM_STR);
            $statement->bindParam(':videoUrl',$tempVideo, \PDO::PARAM_STR);
            $statement->bindParam(':prepRating',$tempPrep, \PDO::PARAM_INT);
            $statement->bindParam(':cleanRating',$tempClean, \PDO::PARAM_INT);
            $statement->bindParam(':servings',$tempServings, \PDO::PARAM_INT);
            $statement->bindParam(':prepTime',$tempPrepTime, \PDO::PARAM_INT);
            $statement->bindParam(':description',$tempDesc, \PDO::PARAM_STR);
            $statement->bindParam(':id',$id, \PDO::PARAM_INT);
            $statement->execute();
            
            $query = "DELETE FROM steps WHERE RecipeId = :id";
            $statement = $connection->prepare($query);
            $statement->bindParam(':id',$id, \PDO::PARAM_INT);
            $statement->execute();
            
            $query = "DELETE FROM recipeIngredients WHERE RecipeId = :id";
            $statement = $connection->prepare($query);
            $statement->bindParam(':id',$id, \PDO::PARAM_INT);
            $statement->execute();
            
            
            if(count($tempIngredients) > 0){
                    if(count($tempIngredients) == count($tempQuantities)){
                        for ($x=0;$x<count($tempIngredients);$x++) {
                            if($tempIngredients[$x]=="0"){
                                $query = 'INSERT INTO Ingredients (Title) VALUES (:title)';
                                $statement = $connection->prepare($query);
                                $statement->bindParam(':title',$tempNewIngredients[$x], \PDO::PARAM_STR);
                                
                                $statement->execute();
                                if($connection->lastInsertId()){
                                    $tempIngredients[$x] = $connection->lastInsertId();
                                }
                                
                            }
                            
                            
                            
                            $query = 'INSERT INTO recipeIngredients (RecipeId, IngredientId,Quantity) VALUES (:id,:ingredientId,:quantity)';
                            $statement = $connection->prepare($query);
                            $statement->bindParam(':id',$id, \PDO::PARAM_INT);
                            $statement->bindParam(':ingredientId',$tempIngredients[$x], \PDO::PARAM_INT);
                            $statement->bindParam(':quantity',$tempQuantities[$x], \PDO::PARAM_STR);
                            $statement->execute();
                        }
                    }
                }
                if(count($tempSteps) > 0){
                    for ($x=0;$x<count($tempSteps);$x++) {
                        $query = 'INSERT INTO steps (RecipeId, Description ,DisplayOrder) VALUES (:id,:description,:displayOrder)';
                        $statement = $connection->prepare($query);
                        $statement->bindParam(':id',$id, \PDO::PARAM_INT);
                        $statement->bindParam(':description',$tempSteps[$x], \PDO::PARAM_STR);
                        $statement->bindParam(':displayOrder',$x, \PDO::PARAM_INT);
                        $statement->execute();
                    }
                }
            
            $connection=null;
        }
    }
    
    public static function search($keyword){
        $recipes=array();
        if(!empty(trim($keyword))){
            $param = "%{$keyword}%";
            $connection = openConnection();
            $query = 'SELECT Id, Title, TasteRating, PrepRating, CleanRating, ImageUrl, Servings, PrepTime FROM recipes WHERE Title LIKE :keyword OR Id IN (SELECT RecipeId FROM recipeIngredients WHERE IngredientId IN (SELECT Id FROM Ingredients WHERE Title LIKE :keyword)) ORDER BY Title';
            $statement = $connection->prepare($query);
            $statement->bindParam(':keyword',$param,\PDO::PARAM_STR);
            $statement->execute();
            $results = $statement->setFetchMode(\PDO::FETCH_ASSOC);
            if($results){
                while ($row = $statement->fetch()) {
                    $recipes[]=$row;
                }
            }
            $connection=null;
        }
        return ($recipes);
    }
    
    public static function allRecipes($keyword){
        $recipes=array();
        if($keyword!=null && !empty($keyword)){
            $recipes = Recipe::search($keyword);
        }else{
            $connection = openConnection();
            $statement = $connection->prepare('SELECT Id, Title, TasteRating,PrepRating,CleanRating, ImageUrl,Servings,PrepTime,DateModified FROM recipes ORDER BY Title');
            $statement->execute();
            $results = $statement->setFetchMode(\PDO::FETCH_ASSOC);
            if($results){
                while ($row = $statement->fetch()) {
                    $recipes[]=$row;
                }
            }
            $connection=null;
        }
        return ($recipes);
    }
    
    public function getRecipeByName($recipeName){
        if(!empty(trim($recipeName))){
            $connection = openConnection();        
            $query = 'SELECT * FROM recipes WHERE title = :title LIMIT 1';
            $statement = $connection->prepare($query); 
            $statement->bindParam(':title',$recipeName);
            $statement->execute();
            $results = $statement->fetch(\PDO::FETCH_ASSOC);
            if($results){       
                $this->id = $results['Id'];
                $this->title = $results['Title'];
                $this->mainIngredientId = $results['MainIngredientId'];
                $this->cuisineId = $results['CuisineId'];
                $this->tasteRating = $results['TasteRating'];
                $this->notes = $results['Notes'];
                $this->url = $results['Url'];
                $this->dateModified = $results['DateModified'];    
                $this->imageUrl = $results['ImageUrl'];
                $this->videoUrl = $results['VideoUrl'];
                $this->prepRating = $results['PrepRating'];
                $this->cleanRating = $results['CleanRating'];
                $this->servings = $results['Servings'];
                $this->prepTimeInMinutes = $results['PrepTime'];
                $this->description = $results['Description'];
            }
            $connection = null;
            $this->getRecipeInstructions();
            $this->getRecipeIngredients();
            $this->cuisineName = $this->getCuisineNameById($this->cuisineId);
        }
    }
     
    private function getRecipeInstructions(){
        if(is_numeric($this->id)){
            $connection = openConnection();
            $recipeId = intval($this->id);
            $query = 'SELECT Description FROM steps WHERE RecipeId = :recipeId ORDER BY DisplayOrder';
            $statement = $connection->prepare($query);
            $statement->bindParam(':recipeId',$recipeId, \PDO::PARAM_INT);
            $statement->execute();
            if ($statement->rowCount()>0) {
                while($results = $statement->fetchObject()){
                    array_push($this->instructions,$results->Description);
                }
            }
            $connection=null;
        }
    }

    private function getRecipeIngredients(){
        if(is_numeric($this->id)){
            $connection = openConnection();
            $recipeId = intval($this->id);
            $query = 'SELECT i.Title,r.Quantity FROM recipeIngredients r, ingredients i WHERE r.IngredientId = i.Id AND r.RecipeId = :recipeId';
            $statement = $connection->prepare($query);
            $statement->bindParam(':recipeId',$recipeId,\PDO::PARAM_INT);
            $statement->execute();
            if ($statement->rowCount()>0) {
                while($results = $statement->fetchObject()){
                    array_push($this->ingredients,$results->Title);
                    array_push($this->quantities,$results->Quantity);
                }
            }
            $connection=null;
        }
    }
    
    public function getCuisineNameById($cuisineId){
        if(is_numeric($cuisineId)){
            $connection = openConnection();
            $cuisineId = intval($cuisineId);
            $cuisineName = "";
            $query = 'SELECT Title FROM cuisines WHERE Id = :cuisineId LIMIT 1';
            $statement = $connection->prepare($query);
            $statement->bindParam(':cuisineId',$cuisineId,\PDO::PARAM_INT);
            $statement->execute();
            if ($statement->rowCount()>0) {
                while($results = $statement->fetchObject()){
                    $cuisineName = $results->Title;
                }
            }
            $connection=null;
        }
        return $cuisineName;
    }
}
?>