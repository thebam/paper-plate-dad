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
    public $ingredients = array();
    public $quantities = array();
    public $instructions = array();

    public static function addRecipe($tempTitle, $tempMainIngredientId,$tempCuisineId,$tempUrl,$tempTaste,$tempNotes,$tempImage,$tempVideo,$tempPrep,$tempClean,$tempIngredients,$tempQuantities,$tempSteps,$tempServings,$tempPrepTime){
        $output="";
        if($tempTitle!==NULL &&  $tempMainIngredientId !== NULL && $tempCuisineId !== NULL && $tempUrl !== NULL&& $tempTaste !== NULL)
        {
            $connection = openConnection();
            $query = 'INSERT INTO recipes (Title, MainIngredientId,CuisineId,Url,TasteRating,Notes,ImageUrl,VideoUrl,PrepRating,CleanRating,Servings,PrepTime) VALUES (?,?,?,?,?,?,?,?,?,?,?,?)';
            $recipes = $connection->prepare($query);
            $recipes->bind_param('siisisssiiii',$tempTitle, intval($tempMainIngredientId),intval($tempCuisineId),$tempUrl,intval($tempTaste),$tempNotes,$tempImage,$tempVideo,intval($tempPrep),intval($tempClean),intval($tempServings),intval($tempPrepTime));
            
            //TODO add $query->erroe_list
            $recipes->execute();
            if($connection->insert_id){
                $recipeId = $connection->insert_id;
                if(count($tempIngredients) > 0){
                    if(count($tempIngredients) == count($tempQuantities)){
                        for ($x=0;$x<count($tempIngredients);$x++) {
                            $query = 'INSERT INTO recipeIngredients (RecipeId, IngredientId,Quantity) VALUES (?,?,?)';
                            $recipes = $connection->prepare($query);
                            $recipes->bind_param('iis',$recipeId, intval($tempIngredients[$x]),$tempQuantities[$x]);
                            $recipes->execute();
                        }
                    }
                }
                if(count($tempSteps) > 0){
                    for ($x=0;$x<count($tempSteps);$x++) {
                        $query = 'INSERT INTO steps (RecipeId, Description ,DisplayOrder) VALUES (?,?,?)';
                        $recipes = $connection->prepare($query);
                        $recipes->bind_param('isi',$recipeId,$tempSteps[$x],intval($x));
                        $recipes->execute();
                    }
                }
                $output ="success";
            }else{
                $output ="failed";
            }
            $recipes->close();
            $connection->close();
        }
        return $output;
    }
    public static function deleteRecipe($id){
        if($id!==NULL)
        {
            $connection = openConnection();
            // $params = array(':id' => $id);
            // $query = "DELETE FROM steps WHERE RecipeId = :id";
            // $connection->prepare($query);
            // $connection->execute($params);
            
            $query = "DELETE FROM steps WHERE RecipeId = ?";
            $recipe = $connection->prepare($query);
            $recipe->bind_param('i',intval($id));
            $recipe->execute();
            
            $query = "DELETE FROM recipeIngredients WHERE RecipeId = ?";
            $recipe = $connection->prepare($query);
            $recipe->bind_param('i',intval($id));
            $recipe->execute();
            
            $query = "DELETE FROM recipes WHERE Id = ?;";
            $recipe = $connection->prepare($query);
            $recipe->bind_param('i',intval($id));
            $recipe->execute();
            $recipe->close();
            $connection->close();
        }
    }
    
    public static function editRecipe($id,$tempTitle, $tempMainIngredientId,$tempCuisineId,$tempUrl,$tempTaste,$tempNotes,$tempImage,$tempVideo,$tempPrep,$tempClean,$tempIngredients,$tempQuantities,$tempSteps,$tempServings,$tempPrepTime){
        if($id!==NULL &&$tempTitle!==NULL &&  $tempMainIngredientId !== NULL && $tempUrl !== NULL)
        {
            $connection = openConnection();
            $query = 'UPDATE recipes SET Title=?, MainIngredientId=?,CuisineId=?, Url=?,TasteRating=?,Notes=?,ImageUrl=?,VideoUrl=?,PrepRating=?,CleanRating=?,Servings=?,PrepTime=? WHERE id=?';
            $recipes = $connection->prepare($query);
            $recipes->bind_param('siisisssiiiii',$tempTitle, intval($tempMainIngredientId),intval($tempCuisineId),$tempUrl,intval($tempTaste),$tempNotes,$tempImage,$tempVideo,intval($tempPrep),intval($tempClean),intval($tempServings),intval($tempPrepTime),intval($id));
            $recipes->execute();
            
            $query = "DELETE FROM steps WHERE RecipeId = ?";
            $recipe = $connection->prepare($query);
            $recipe->bind_param('i',intval($id));
            $recipe->execute();
            
            $query = "DELETE FROM recipeIngredients WHERE RecipeId = ?";
            $recipe = $connection->prepare($query);
            $recipe->bind_param('i',intval($id));
            $recipe->execute();
            
            
            if(count($tempIngredients) > 0){
                    if(count($tempIngredients) == count($tempQuantities)){
                        for ($x=0;$x<count($tempIngredients);$x++) {
                            $query = 'INSERT INTO recipeIngredients (RecipeId, IngredientId,Quantity) VALUES (?,?,?)';
                            $recipes = $connection->prepare($query);
                            $recipes->bind_param('iis',$id, intval($tempIngredients[$x]),$tempQuantities[$x]);
                            $recipes->execute();
                        }
                    }
                }
                if(count($tempSteps) > 0){
                    for ($x=0;$x<count($tempSteps);$x++) {
                        $query = 'INSERT INTO steps (RecipeId, Description ,DisplayOrder) VALUES (?,?,?)';
                        $recipes = $connection->prepare($query);
                        $recipes->bind_param('isi',$id,$tempSteps[$x],intval($x));
                        $recipes->execute();
                    }
                }
            
            
            
            
            $recipes->close();
            $connection->close();
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
            $statement = $connection->prepare('SELECT Id, Title, TasteRating,PrepRating,CleanRating, ImageUrl,Servings,PrepTime FROM recipes ORDER BY Title');
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