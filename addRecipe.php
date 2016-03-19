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
$error = '';
if(count($_POST)>0){
     $result = Recipe::addRecipe($_POST['title'],$_POST['mainIngredient'],$_POST['cuisine'],$_POST['url'],$_POST['tasteRating'],$_POST['notes'],$_POST['imageUrl'],$_POST['videoUrl'],$_POST['preparationRating'],$_POST['cleanUpRating'],$_POST['ingredients'],$_POST['quantities'],$_POST['instructions'],$_POST['servings'],$_POST['prepTime']);
     if($result==='success'){
         header('Location: index.php');
     }else{
         $error=$result;
     }
}else{
    $cuisines = Cuisine::getAllCuisines();
    $ingredients = Ingredient::getAllIngredients();
}
$pageTitle = "Add Recipe";
require_once 'includes/header.php';
?>
<div class="container">
        <h1>Add Recipe</h1>
        <p><?=$error?></p>
        <form action="addRecipe.php" method="post" role="form">
            <div class="form-group">
                <label for="title">Title:</label>
                <input type="text" name="title" class="form-control"  required/>
            </div>
            <div class="form-group">
                <label for="url">Url:</label>
                <input type="text" name="url" class="form-control"  required/>
            </div>
            <div class="form-group">
                <label for="cuisine">Cuisine:</label>
            <select name="cuisine" class="form-control">
            <?php
            foreach($cuisines as $cuisine){
                ?>
                <option value="<?=$cuisine['Id']?>"><?=$cuisine['Title']?></option>
                <?php
            }
            ?>    
            </select>
            </div>
            
           
            
            <div class="form-group">
                <label for="mainIngredient">Main Ingredient:</label>
                <select name="mainIngredient" class="form-control">
                    <?php
                    foreach($ingredients as $ingredient){
                        ?>
                        <option value="<?=$ingredient['Id']?>"><?=$ingredient['Title']?></option>
                        <?php
                    }
                    ?>    
                </select>
            </div>
            
            <div class="form-group">
                <label for="servings">Servings:</label>
                
                     <select name="servings" class="form-control">
                <option>0</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                <option>6</option>
                <option>7</option>
                <option>8</option>
                <option>9</option>
                <option>10</option>
                <option>11</option>
                <option>12</option>
                </select> 

            </div>
            
            <div class="form-group">
                <label for="prepTime">Total Time:</label>
                
                     <input class="form-control" type="text" name="prepTime" required/>

            </div>
            
            <label>All Ingredients:</label>
            <div id="ingredientsContainer" class="controls form-inline">
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
            </div>
            
            <label>Cooking Instructions:</label>
            <div id="instructionsContainer" class="controls form-inline">
            <div class="instruction controls form-inline">
                <div class="form-group">
                    <label>Step:</label>
                    <textarea name="instructions[]" class="form-control"></textarea>
                    <div class="addStep btn btn-default form-control">+</div>
                    <div class="removeStep btn btn-default form-control">-</div>
                </div>
            </div>
            </div>
            
            
            
            
            <div class="form-group">
                <label for="imageUrl">Image:</label>
            <input type="text" name="imageUrl" class="form-control" />
                </div>
                <div class="form-group">
                <label for="videoUrl">Video:</label>
            <input type="text" name="videoUrl" class="form-control" />
                </div>
            
            <div class="form-group">
                <label for="tasteRating">Taste Rating:</label>
            <select name="tasteRating" class="form-control">
                <option>0</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select>
                </div>
                <div class="form-group">
                <label for="preparationRating">Preparation Difficulty:</label>
            <select name="preparationRating" class="form-control">
                <option>0</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select>
                </div>
                <div class="form-group">
                <label for="cleanUpRating">Clean Up Rating:</label>
            <select name="cleanUpRating" class="form-control">
                <option>0</option>
                <option>1</option>
                <option>2</option>
                <option>3</option>
                <option>4</option>
                <option>5</option>
                </select>
                </div>
                <div class="form-group">
                <label for="notes">Comments:</label>
                <textarea name="notes" class="form-control"></textarea>
                </div>
            <input type="submit" value="Add Recipe" class="btn btn-default" />
        </form>
        </div>
<?php
    require_once 'includes/footer.php';
    ?>