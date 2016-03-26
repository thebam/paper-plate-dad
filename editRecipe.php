<?php
namespace Cooking;
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
if(!isset($_SESSION["id"]) || !isset($_SESSION["username"])){
    header('Location: index.php');
}
require_once "includes/recipe.php";
require_once "includes/cuisine.php";
require_once "includes/ingredient.php";
if(count($_POST)>0){
    Recipe::editRecipe($_POST['id'],$_POST['title'],$_POST['mainIngredient'],$_POST['cuisine'],$_POST['url'],$_POST['tasteRating'],$_POST['notes'],$_POST['imageUrl'],$_POST['videoUrl'],$_POST['preparationRating'],$_POST['cleanUpRating'],$_POST['ingredients'],$_POST['quantities'],$_POST['instructions'],$_POST['servings'],$_POST['prepTime'],$_POST['description']);
    header('Location: index.php');
}else{
    if(count($_GET)>0){
        $myRecipe = new recipe();
        $myRecipe->getRecipeByName(urldecode($_GET['name']));
    }
    $cuisines = Cuisine::getAllCuisines();
    $ingredients = Ingredient::getAllIngredients();
}
$pageTitle = "Edit Recipe";
require_once 'includes/header.php';
?>
<div class="container">
        <h1>Edit Recipe</h1>

        <form action="editRecipe.php" method="post" role="form">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control" value="<?=$myRecipe->title?>"  required/>
            </div>
            <div class="form-group">
                <label for="url">Description:</label>
                <input type="text" name="description" class="form-control" value="<?=$myRecipe->description?>" maxlength="160"  required/>
            </div>
            <div class="form-group">
                <label for="url">Url:</label>
                <input type="text" name="url" class="form-control" value="<?=$myRecipe->url?>"  required/>
            </div>
            <div class="form-group">
                <label for="cuisine">Cuisine:</label>
            <select name="cuisine" class="form-control">
            <?php
            foreach($cuisines as $cuisine){
                if($cuisine['Id'] == intval($myRecipe->cuisineId)){?>
                    <option selected value="<?=$cuisine['Id']?>"><?=$cuisine['Title']?></option>
                <?php
                }else{
                    ?>
                    <option value="<?=$cuisine['Id']?>"><?=$cuisine['Title']?></option>
                    <?php
                }
            }
            ?>    
            </select>
            </div>

            <div class="form-group">
                <label for="mainIngredient">Main Ingredient:</label>
                <select name="mainIngredient" class="form-control">
                    <?php
                    foreach($ingredients as $ingredient){
                        if($ingredient['Id'] == intval($myRecipe->mainIngredientId)){?>
                    <option selected value="<?=$ingredient['Id']?>"><?=$ingredient['Title']?></option>
                <?php
                }else{
                    ?>
                    <option value="<?=$ingredient['Id']?>"><?=$ingredient['Title']?></option>
                    <?php
                }
                    }
                    ?>    
                </select>
            </div>
            
            
            <div class="form-group">
                <label for="servings">Servings:</label>
            <select name="servings" class="form-control">
                <?php
                    for($servingCnt=1;$servingCnt<13; $servingCnt++){
                        if($servingCnt == intval($myRecipe->servings)){?>
                    <option selected><?=$servingCnt?></option>
                <?php
                }else{
                    ?>
                    <option><?=$servingCnt?></option>
                    <?php
                }
                    }
                    ?>    
                </select>
                </div>
            
            <div class="form-group">
                <label for="prepTime">Total Time:</label>
                
                     <input class="form-control" type="text" name="prepTime" value="<?=$myRecipe->prepTimeInMinutes?>" required/>

            </div>
            
            <label>All Ingredients:</label>
            <div id="ingredientsContainer" class="controls form-inline">
                
                
                 <?php
                 if(count($myRecipe->ingredients)==0){
                     ?>
                     <div class="ingredient controls form-inline">
                <div class="form-group">
                    <label>Ingredient:</label>
                    <select name="ingredients[]" class="form-control">
                        <?php
                        foreach($ingredients as $ingredient){
                            ?>
                            <option value="<?=$ingredient['Id']?>"><?=$ingredient['Title']?></option>
                            <?php
                        }
                        ?>    
                    </select>
                    <label>Quantity:</label>
                    <input type="text" name="quantities[]" class="form-control" required/>
                    <div class="addIngredient btn btn-default form-control">+</div>
                    <div class="removeIngredient btn btn-default form-control">-</div>
                </div>
            </div>
                     <?php
                 }
                     for ($ingredientCnt=0;$ingredientCnt<count($myRecipe->ingredients);$ingredientCnt++) {
                        ?>
            <div class="ingredient controls form-inline controlGroup">
                <div class="form-group">
                    <label>Ingredient:</label>
                    <select name="ingredients[]" class="form-control">
                        <?php
                        foreach($ingredients as $ingredient){
                        if($ingredient['Title'] == $myRecipe->ingredients[$ingredientCnt]){?>
                    <option selected value="<?=$ingredient['Id']?>"><?=$ingredient['Title']?></option>
                <?php
                }else{
                    ?>
                    <option value="<?=$ingredient['Id']?>"><?=$ingredient['Title']?></option>
                    <?php
                }
                    }
                    ?>       
                    </select>
                    <label>Quantity:</label>
                    <input type="text" name="quantities[]" class="form-control" value="<?=$myRecipe->quantities[$ingredientCnt]?>" required/>
                    <div class="addIngredient btn btn-default form-control">+</div>
                    <div class="removeIngredient btn btn-default form-control">-</div>
                </div>
            </div>
            
            <?php
            }
            ?>
            
            
            </div>
            
            <label>Cooking Instructions:</label>
            <div id="instructionsContainer" class="controls form-inline controlGroup">
                <?php
                 if(count($myRecipe->instructions)==0){
                     ?>
                     <div class="instruction controls form-inline">
                <div class="form-group">
                    <label>Step:</label>
                    <textarea name="instructions[]" class="form-control"></textarea>
                    <div class="addStep btn btn-default form-control">+</div>
                    <div class="removeStep btn btn-default form-control">-</div>
                </div>
            </div>
                     <?php
                 }
                foreach ($myRecipe->instructions as $instruction) {
                ?>
            <div class="instruction controls form-inline">
                <div class="form-group">
                    <label>Step:</label>
                    <textarea name="instructions[]" class="form-control"><?=$instruction?></textarea>
                    <div class="addStep btn btn-default form-control">+</div>
                    <div class="removeStep btn btn-default form-control">-</div>
                </div>
            </div>
             <?php
                }
                ?>
            
            </div>
            
            
            
            
            <div class="form-group">
                <label for="imageUrl">Image:</label>
            <input type="text" name="imageUrl" class="form-control" value="<?=$myRecipe->imageUrl?>" />
                </div>
                <div class="form-group">
                <label for="videoUrl">Video:</label>
            <input type="text" name="videoUrl" class="form-control" value="<?=$myRecipe->videoUrl?>" />
                </div>
            
            <div class="form-group">
                <label for="tasteRating">Taste Rating:</label>
            <select name="tasteRating" class="form-control">
                <?php
                    for($tasteCnt=0;$tasteCnt<6; $tasteCnt++){
                        if($tasteCnt == intval($myRecipe->tasteRating)){?>
                    <option selected><?=$tasteCnt?></option>
                <?php
                }else{
                    ?>
                    <option><?=$tasteCnt?></option>
                    <?php
                }
                    }
                    ?>    
                </select>
                </div>
                <div class="form-group">
                <label for="preparationRating">Preparation Difficulty:</label>
            <select name="preparationRating" class="form-control">
                <?php
                    for($prepCnt=0;$prepCnt<6; $prepCnt++){
                        if($prepCnt == intval($myRecipe->prepRating)){?>
                    <option selected><?=$prepCnt?></option>
                <?php
                }else{
                    ?>
                    <option><?=$prepCnt?></option>
                    <?php
                }
                    }
                    ?>    
                </select>
                </div>
                <div class="form-group">
                <label for="cleanUpRating">Clean Up Rating:</label>
            <select name="cleanUpRating" class="form-control">
                <?php
                    for($cleanCnt=0;$cleanCnt<6; $cleanCnt++){
                        if($cleanCnt == intval($myRecipe->cleanRating)){?>
                    <option selected><?=$cleanCnt?></option>
                <?php
                }else{
                    ?>
                    <option><?=$cleanCnt?></option>
                    <?php
                }
                    }
                    ?>    
                </select>
                </div>
                <div class="form-group">
                <label for="notes">Comments:</label>
                <textarea name="notes" class="form-control"><?=$myRecipe->notes?></textarea>
                </div>
                
                <input type="hidden" name="id" value="<?=$myRecipe->id?>" />
            <input type="submit" value="Save" class="btn btn-default" />
            <a href="index.php" class="btn btn-default">Cancel</a>
        </form>
         </div>
        
        
<?php
require_once 'includes/footer.php';
?>