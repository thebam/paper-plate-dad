<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once "includes/recipe.php";
$error = '';
if(count($_GET)>0){
        $myRecipe = new Cooking\recipe();
        $myRecipe->getRecipeByName(urldecode($_GET['name']));
    }
    $pageTitle = $myRecipe->title;
    $pageDesc = $myRecipe->description;
    
    
                    $imageUrl =  $myRecipe->imageUrl;
                    if(empty(trim($imageUrl))){
                        $imageUrl = "photos/empty-plates.jpg";
                    }
                $pageImage = $imageUrl;
    
require_once 'includes/header.php';
?>

        <div class="hero" >
           <img class="bgImage" src="<?=$imageUrl?>"/>
                <div class="col-md-4">
            <h1><?=$myRecipe->title?></h1>
            <p><?=$myRecipe->description?></p>
            <p>Recipe Source : <a href='<?=$myRecipe->url?>' target='_blank'><?=$myRecipe->url?></a></p>
            <p>Cuisine :<?=$myRecipe->cuisineName?></p>
            <p>Servings :<?=$myRecipe->servings?></p>
            <p>Time :<?=$myRecipe->prepTimeInMinutes?> minutes</p>
            <hr/>
            <p>TASTE</p>
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?=$myRecipe->tasteRating?>" aria-valuemin="0" aria-valuemax="5" style="width: <?=(intval($myRecipe->tasteRating)/5)*100?>%">
                    <?=$myRecipe->tasteRating?>
                </div>
            </div>
            <p>PREPARATION</p>
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?=$myRecipe->prepRating?>" aria-valuemin="0" aria-valuemax="5" style="width: <?=(intval($myRecipe->prepRating)/5)*100?>%">
                    <?=$myRecipe->prepRating?>
                </div>
            </div>
            <p>CLEAN UP</p>
            <div class="progress">
                <div class="progress-bar progress-bar-success" role="progressbar" aria-valuenow="<?=$myRecipe->cleanRating?>" aria-valuemin="0" aria-valuemax="5" style="width: <?=(intval($myRecipe->cleanRating)/5)*100?>%">
                    <?=$myRecipe->cleanRating?>
                </div>
            </div>
            </div>
            
            
            <div class="col-md-4">
                
            
            
            
            <?php
            if($myRecipe->videoUrl != null){
            ?>
             <div class="bs-example" data-example-id="responsive-embed-16by9-iframe-youtube"> 
                <div class="embed-responsive embed-responsive-16by9"> 
                    <iframe class="embed-responsive-item" src="<?=$myRecipe->videoUrl?>" allowfullscreen=""></iframe> 
                    </div> 
                    </div>
            <?php
            }else{
            ?>
            
                
                
                
                
                <img class="mainImage" src="<?=$imageUrl?>"/>
                <?php
            }
                ?>
            
            </div>
            
            <div class="clearfix">
            </div>
        </div>
        
        
            
            <div class="container-fluid ingredients">
            <h2>Ingredients</h3>
            <ul>
                <?php
                for ($x=0;$x<count($myRecipe->ingredients);$x++) {
                ?>
                <li><?=$myRecipe->ingredients[$x]." - ".$myRecipe->quantities[$x]?></li>
                <?php
                }
                ?>
                </ul>
                </div>
                
                <div class="container-fluid instructions">
<h2>Cooking Instructions</h2>
            <ul>
                <?php
                foreach ($myRecipe->instructions as $instruction) {
                ?>
                <li><?=$instruction?></li>
                <?php
                }
                ?>
                </ul>
            
            </div>
            

            
            
            
            
            
            <div class="container-fluid">
            <h2>Comments</h2>
            <p><?=$myRecipe->notes?></p>
            </div>
        <?php
    require_once 'includes/footer.php';
    ?>