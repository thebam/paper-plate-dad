<?php
namespace Cooking;
require_once 'includes/recipe.php';
$recipes = Recipe::allRecipes();
$pageTitle = "Recipes";
require_once 'includes/header.php';
?>
        <h1>Recipes</h1>
        <a href="addRecipe.php">Add Recipe</a>
        <div class="recipes container-fluid">
        
            <?php
            $id = 0;
            $title = '';
            $tasteRating = 0;
            $prepRating = 0;
            $cleanRating = 0;
            $imageUrl = '';
            $recipeCnt = 0;
            $blnAlternate = false;
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
                    <div class="col-md-3 recipeDetails">
                        
                        <h2><?=$title?></h2>
                        <p><?=$tasteRating?> out of 5<br/>
                        <?=$prepRating?> out of 5<br/>
                        <?=$cleanRating?> out of 5
                    </p>
                        <a class="btn btn-default" href="showRecipe.php?name=<?=urlencode($title)?>">Details</a>
                        <p>
                        <a href="editMeal.php?name=<?=urlencode($title)?>">edit</a> - 
                    <a href="deleteMeal.php?id=<?=$id?>">delete</a>
                        </p>
                        
                    </div>
                  <?php
                }else{
                  ?>
                  <div class="recipe rowBackwards">
            <div class="col-md-3 recipeDetails">
                <h2><?=$title?></h2>
                        <p><?=$tasteRating?> out of 5<br/>
                        <?=$prepRating?> out of 5<br/>
                        <?=$cleanRating?> out of 5
                    </p>
                        <a class="btn btn-default" href="showRecipe.php?name=<?=urlencode($title)?>">Details</a>
                        <p>
                        <a href="editMeal.php?name=<?=urlencode($title)?>">edit</a> - 
                    <a href="deleteMeal.php?id=<?=$id?>">delete</a>
                        </p>
            </div>
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
        
        
        
        
        
        
         
            

            <!--<div class="col-md-3 recipeImage">
                <img src="http://technext.github.io/restaurant-html-template/images/blog/blog-img-2.jpg" />
            </div>
            <div class="col-md-3 recipeDetails">
                <h2>What Waffles</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <a class="btn btn-default">Details</a>
            </div>
        </div>
        <div class="row">
            <div class="recipe rowBackwards">
            <div class="col-md-3 recipeDetails">
                <h2>Sup Steak</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <a class="btn btn-default">Details</a>
            </div>
            <div class="col-md-3 recipeImage">
                <img src="http://technext.github.io/restaurant-html-template/images/blog/blog-img-3.jpg" />
            </div>
            </div>
            <div class="recipe rowBackwards">
            <div class="col-md-3 recipeDetails">
                <h2>So Sausage</h2>
                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p>
                <a class="btn btn-default">Details</a>
            </div>
            <div class="col-md-3 recipeImage">
                <img src="http://technext.github.io/restaurant-html-template/images/blog/blog-img-4.jpg" />
            </div>
            </div>-->
        
        
        
        
        
    <?php
    require_once 'includes/footer.php';
    ?>