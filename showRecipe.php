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
    $pageDescription = $myRecipe->description;
    $pageURL = "";
    
    
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
            
            <p>CUISINE :<?=$myRecipe->cuisineName?></p>
            <p>SERVINGS :<?=$myRecipe->servings?></p>
            <p>TOTAL TIME :<?=$myRecipe->prepTimeInMinutes?> minutes</p>
            <p>RECIPE SOURCE : <a href='<?=$myRecipe->url?>' target='_blank'><?=$myRecipe->url?></a></p>
            <hr/>
            <p>TASTE :
            
            <?php
            for($x=1;$x<6;$x++){
                if($x<=$myRecipe->tasteRating){
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
                if($x<=$myRecipe->prepRating){
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
                if($x<=$myRecipe->cleanRating){
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
            </div>
            
            
            <div class="col-md-8">
                
            
            
            
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
                <hr/>
                <div class="container-fluid instructions">
<h2>Cooking Instructions</h2>
            
                <?php
                $instuctionCnt =0;
                foreach ($myRecipe->instructions as $instruction) {
                    $instuctionCnt++
                ?>
                <div class="instruction col-md-6">
                    <div class="instructionNumber col-xs-1 col-sm-1 col-md-1 col-lg-1">
                        <?=$instuctionCnt?>
                    </div>
                    <div class="instructionDetail col-xs-11 col-sm-11 col-md-11 col-lg-11">
                        <?=$instruction?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <?php
                }
                ?>
                
            
            </div>
            
            <hr/>
            <div class="container-fluid">
            <h2>Notes</h2>
            <p><?=$myRecipe->notes?></p>
            </div>
            <hr/>
            <div class="fb-comments" data-href="http://paperplatedad.com/showRecipe.php?<?=$_SERVER['QUERY_STRING']?>" data-numposts="3" data-colorscheme="dark"  data-width="100%"></div>
            
            
            
            <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5&appId=829664503806006";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
        <?php
    require_once 'includes/footer.php';
    ?>