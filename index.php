<?php
namespace Cooking;
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once 'includes/recipe.php';

$recipes = Recipe::getFeaturedRecipes();

$pageTitle = "Paper Plate Dad";
$pageDescription = "The cooking adventures of a husband and father.";
$pageURL = "";
$pageImage = "http://paperplatedad.com/photos/empty-plates.jpg";
require_once 'includes/header.php';
?>

        <div class="container">
        
            <?php

            $title = '';
            $tasteRating = 0;
            $prepRating = 0;
            $cleanRating = 0;
            $imageUrl = '';
            $prepTimeInMinutes=1;
            $servings=1;
            $recipeCnt = 0;
$blnAlternate = false;
            $description = '';
            $videoUrl='';
            

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
                    if(empty(trim($imageUrl))){
                        $imageUrl = "photos/empty-plates.jpg";
                    }
                }
                if (array_key_exists('PrepTime',$recipe)){ 
                    $prepTimeInMinute =  $recipe['PrepTime'];
                }
                if (array_key_exists('Servings',$recipe)){ 
                    $servings =  $recipe['Servings'];
                }
                
                if (array_key_exists('VideoUrl',$recipe)){ 
                    $videoUrl =  $recipe['VideoUrl'];
                }
                
                if (array_key_exists('Description',$recipe)){ 
                    $description =  $recipe['Description'];
                }
                
                if($recipeCnt==0){
                ?>
                <div class="row">
                    <div class="col-md-12">
                        <h1><?=$title?></h1>
                        </div>
                        </div>
                
                <div class="row">
                    <div class="col-md-6">
                        <?php
                        if($videoUrl != null){
                        ?>
                        <div class="bs-example" data-example-id="responsive-embed-16by9-iframe-youtube"> 
                            <div class="embed-responsive embed-responsive-16by9"> 
                                <iframe class="embed-responsive-item" src="<?=$videoUrl?>" allowfullscreen=""></iframe> 
                            </div> 
                        </div>
                        <?php
                        }else{
                        ?>
                            <img class="img-responsive" src="<?=$imageUrl?>" alt="<?=$title?>" />
                            <?php
                        }
                        ?>
                    </div>
                    <div class="col-md-6">
                        
                         <p><?=$description?></p>
                         <hr/>
                        <p>SERVINGS :<?=$servings?></p>
                        <p>TOTAL TIME :<?=$prepTimeInMinutes?> minutes</p>
                        
                    
                        <p>TASTE :
                        
                        <?php
                        for($x=1;$x<6;$x++){
                            if($x<=$tasteRating){
                            ?>
                            <i class="star glyphicon glyphicon-star"></i>
                            <?php
                            }else{
                                ?>
                            <i class="star glyphicon glyphicon-star-empty"></i>
                            <?php
                            }
                        }
                        ?>
                        </p>
                        <p>PREPARATION :
                        <?php
                        for($x=1;$x<6;$x++){
                            if($x<=$prepRating){
                            ?>
                            <i class="star glyphicon glyphicon-star"></i>
                            <?php
                            }else{
                                ?>
                            <i class="star glyphicon glyphicon-star-empty"></i>
                            <?php
                            }
                        }
                        ?>
                        </p>
                        <p>CLEAN UP :
                        <?php
                        for($x=1;$x<6;$x++){
                            if($x<=$cleanRating){
                            ?>
                            <i class="star glyphicon glyphicon-star"></i>
                            <?php
                            }else{
                                ?>
                            <i class="star glyphicon glyphicon-star-empty"></i>
                            <?php
                            }
                        }
                        ?>
                        </p>
                         <a class="btn btn-default" href="showRecipe.php?name=<?=urlencode($title)?>">VIEW RECIPE</a>
                    </div>
                    
                </div>
                <hr/>
                <h2>Related Recipes</h2>
                <div class="recipes">
                <div class="row">
                   <?php
                }else{
                    $descriptionBlock="";
                    $descriptionBlock = '<a href="showRecipe.php?name='.urlencode($title).'"><div class="col-md-3 recipeDetails">';
                    $descriptionBlock .= '<h2>'.$title.'</h2>';
                    $descriptionBlock .= '<p><strong>'.$servings.'</strong> Servings<br/>';
                    
                    $descriptionBlock .= '<strong>Difficulty:</strong>';
                            
                            for($x=1;$x<6;$x++){
                                if($x<=$prepRating){
                                
                                $descriptionBlock .= '<i class="star glyphicon glyphicon-star"></i>';
                            
                                }else{
                                    
                                $descriptionBlock .= '<i class="star glyphicon glyphicon-star-empty"></i>';
                                
                                }
                            }
                            
                            
                    
                    
                    $descriptionBlock .= '<br/><strong>Total Time: </strong>'.$prepTimeInMinute.' Minutes</p>';
                    
                    if(isset($_SESSION["id"]) && isset($_SESSION["username"])){
                        $descriptionBlock .= '<p>';
                        $descriptionBlock .= '<a href="editRecipe.php?name='.urlencode($title).'">edit</a> - ';
                        $descriptionBlock .= '<a href="deleteRecipe.php?id='.$id.'">delete</a></p>';
                    }
                    $descriptionBlock .= '</div></a>';
                    
                    if($blnAlternate==false){
                ?>
                    <div class="col-md-3 recipeImage">
                        <img class="food" src="<?=$imageUrl?>" alt="<?=$title?>" />
                        <div class="arrow">
                            <img src="images/arrow-left.png"/>
                        </div>
                    </div>
                    
                  <?php
                  echo $descriptionBlock;
                }else{
                  ?>
                  <div class="recipe rowBackwards">
           <?= $descriptionBlock?>
            <div class="col-md-3 recipeImage">
                <img class="food" src="<?=$imageUrl?>" alt="<?=$title?>" />
                <div class="arrow">
                    <img src="images/arrow-right.png"/>
                </div>
            </div>
            </div>
            <?php
                }
                    
                    
                }
                $recipeCnt++;
                if ((intval($recipeCnt) % 2) === 1){
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
    </div>
    <?php
    require_once 'includes/footer.php';
    ?>