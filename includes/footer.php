        <footer>
            
            <div class="container">
                
                <div class="footerLeft">
                    &copy <?=date("Y")?>
                </div>
                <div class="footerRight">
                    <?php
                    if(!isset($_SESSION["id"]) || !isset($_SESSION["username"])){
                    ?>
                        <a href="login.php">login</a>
                    <?php
                    }else{
                    ?>
                        <a href="logout.php">logout</a>
                    <?php
                    }
                    ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </footer>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
        <script src="scripts/bootstrap.min.js"></script>
        <script>
            $(document).ready(function(){
                if ( $( "#ingredientsContainer" ).length ) {
                    $("#ingredientsContainer").on('click','.addIngredient', function(){
                        $(".ingredient").first().clone().appendTo("#ingredientsContainer");
                    });
                    $("#ingredientsContainer").on('click','.removeIngredient', function(){
                        $(this).parent().parent().remove();
                    });
                    
                    $(".txtNewIngredient").hide();
                    $("#ingredientsContainer").on('change','.selIngredient', function(){
                        if($(this).val()==0){
                            $(this).siblings(".txtNewIngredient").val("");
                             $(this).siblings(".txtNewIngredient").show();
                        }else{
                             $(this).siblings(".txtNewIngredient").val("");
                             $(this).siblings(".txtNewIngredient").hide();
                        }
                    });
                    
                    
                    
                    $("#instructionsContainer").on('click','.addStep', function(){
                        $(".instruction").first().clone().appendTo("#instructionsContainer");
                    });
                    $("#instructionsContainer").on('click','.removeStep', function(){
                        $(this).parent().parent().remove();
                    });
                }
                
                if ( $( ".txtNewCuisine" ).length && $( ".selCuisine" ).length) {
                    $( ".selCuisine" ).change(function(){
                        $( ".txtNewCuisine" ).val("");
                        if($( ".selCuisine" ).val()==0){
                            $( ".txtNewCuisine" ).show();
                        }else{
                            $( ".txtNewCuisine" ).hide();
                        }
                    });
                }
        });
        
        </script>
    </body>
</html>