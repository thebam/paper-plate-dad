<?php
namespace Cooking;
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'includes/recipe.php';
$keyword = "";
$recipeSearchTerm  = "";
if(count($_GET)>0){
    $keyword = $_GET['q'];
    $recipeSearchTerm = $keyword;
}
$recipes = Recipe::allRecipes($keyword);

$pageTitle = "Recipes";
require_once 'includes/header.php';
?>
<div class="container">
    <h1>Recipes</h1>
    <?php
    if(!empty(trim($recipeSearchTerm))){
    ?>
        <hr/>
        <h2>search results for <em>'<?=$recipeSearchTerm?>'</em></h2>
    <?php
        if(count($recipes)===0){
            echo "No recipes found. Please try a different search term. You can search for recipes by title or ingredient.";
        }
    }
    ?>
        <?php
        if(isset($_SESSION["id"]) && isset($_SESSION["username"])){
        ?>
        <a href="addRecipe.php">Add Recipe</a>
        <?php
        }
        ?>
        </div>
        <div class="recipes container-fluid">
        
            <?php
            $id = 0;
            $title = '';
            $tasteRating = 0;
            $prepRating = 0;
            $cleanRating = 0;
            $imageUrl = '';
            $prepTimeInMinutes=1;
            $servings=1;
            $recipeCnt = 0;
            $blnAlternate = false;
            
            
            $descriptionBlock="";
            foreach($recipes as $recipe){
                if (array_key_exists('Id',$recipe)){ 
                    $id =  $recipe['Id'];
                }
                if (array_key_exists('Title',$recipe)){ 
                    $title =  $recipe['Title'];
                }
                if (array_key_exists('TasteRating',$recipe)){ 
                    $tasteRating =  $recipe['TasteRating'];
                }
                if (array_key_exists('PrepRating',$recipe)){ 
                    $prepRating =  $recipe['PrepRating'];
                }
                if (array_key_exists('CleanRating',$recipe)){ 
                    $cleanRating =  $recipe['CleanRating'];
                }
                if (array_key_exists('ImageUrl',$recipe)){ 
                    $imageUrl =  $recipe['ImageUrl'];
                }
                if (array_key_exists('PrepTime',$recipe)){ 
                    $prepTimeInMinute =  $recipe['PrepTime'];
                }
                if (array_key_exists('Servings',$recipe)){ 
                    $servings =  $recipe['Servings'];
                }
                
                $descriptionBlock = '<div class="col-md-3 recipeDetails">';
                $descriptionBlock .= '<h2>'.$title.'</h2>';
                $descriptionBlock .= '<p>'.$servings.' Servings</p>';
                $descriptionBlock .= '<p>Taste: '.$tasteRating.' out of 5<br/>Difficulty: ';
                $descriptionBlock .= $prepRating.' out of 5<br/>Clean Up: ';
                $descriptionBlock .= $cleanRating.' out of 5';
                $descriptionBlock .= '</p>';
                $descriptionBlock .= '<p>Total Time: '.$prepTimeInMinute.' Minutes</p>';
                $descriptionBlock .= '<a class="btn btn-default" href="showRecipe.php?name='.urlencode($title).'">Details</a>';
                if(isset($_SESSION["id"]) && isset($_SESSION["username"])){
                    $descriptionBlock .= '<p>';
                    $descriptionBlock .= '<a href="editRecipe.php?name='.urlencode($title).'">edit</a> - ';
                    $descriptionBlock .= '<a href="deleteRecipe.php?id='.$id.'">delete</a></p>';
                }
                $descriptionBlock .= '</div>';
                
                if ($recipeCnt ===0){
                    ?>
                    <div class="row">
                   <?php 
                }
                if($blnAlternate==false){
                ?>
                    <div class="col-md-3 recipeImage">
                        <img src="<?=$imageUrl?>" alt="<?=$title?>" />
                        <div class=" glyphicon glyphicon-triangle-left arrow"></div>
                    </div>
                    
                  <?php
                  echo $descriptionBlock;
                }else{
                  ?>
                  <div class="recipe rowBackwards">
           <?= $descriptionBlock?>
            <div class="col-md-3 recipeImage">
                <img src="<?=$imageUrl?>" alt="<?=$title?>" />
                <div class=" glyphicon glyphicon-triangle-right arrow"></div>
            </div>
            </div>
            <?php
                }
                $recipeCnt++;
                if ((intval($recipeCnt) % 2) === 0){
                    if($blnAlternate){
                        $blnAlternate = false;
                    }else{
                        $blnAlternate = true;
                    }
                    
                    
                    ?>
                    </div>
                    <div class="row">
                   <?php 
                }
            }    
            ?>
                    </div>
        
    </div>
    <?php
    require_once 'includes/footer.php';
    ?>