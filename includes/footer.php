        <footer>
            
            <div class="container">
                <hr/>
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
                $("#ingredientsContainer").on('click','.addIngredient', function(){
                    $(".ingredient").first().clone().appendTo("#ingredientsContainer");
                });
                $("#ingredientsContainer").on('click','.removeIngredient', function(){
                    $(this).parent().parent().remove();
                });
                
                $("#instructionsContainer").on('click','.addStep', function(){
                    $(".instruction").first().clone().appendTo("#instructionsContainer");
                });
                $("#instructionsContainer").on('click','.removeStep', function(){
                    $(this).parent().parent().remove();
                });
        });
        
        // function buildIngredientDropDown(){
        //     $.getJSON("includes/ingredient", function(result){
        //         $.each(result, function(i, field){
        //             $("div").append(field + " ");
        //         });
        //     });
            
            
            
        //     $.each(selectValues, function(key, value) {   
        //         $('#mySelect')
        //             .append($("<option></option>")
        //             .attr("value",key)
        //             .text(value)); 
        //     });
        // }
        
        </script>
    </body>
</html>