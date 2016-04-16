<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?=$pageTitle?></title>
    <meta name="description" content="<?=$pageDescription?>">
    <meta name="author" content="Paper Plate Dad">

    <!-- Facebook -->
    <meta property="fb:app_id" content="829664503806006" /> 
<!-- Facebook, LinkedIn, Pinterest Open Graph data -->
    <meta property="og:site_name" content="Paper Plate Dad" />
    <meta property="og:title" content="<?=$pageTitle?>" />
    <meta property="og:description" content="<?=$pageDescription?>" />
    <meta property="og:type" content="website" />
    <meta property="og:url" content="http://paperplatedad.com/<?=$pageURL?>" />
    <meta property="og:image" content="<?=$pageImage?>" />

    <!-- Twitter data -->
    <meta name="twitter:card" content="summary_large_image" />
    <meta name="twitter:site" content="@paperplatedad" />
    <meta name="twitter:title" content="Paper Plate Dad" />
    <meta name="twitter:description" content="<?=$pageDescription?>" />
    <meta name="twitter:image" content="<?=$pageImage?>" />
    
    
    <!-- Bootstrap -->
    <link rel="stylesheet" href="css/bootstrap.min.css" />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="css/paperPlateDad.css" />
</head>

<body>
    <header>
        <div class="logoTitle"><a href="index.php">Paper Plate Dad</a></div>
        <nav>
            <ul>
                <li><a href="recipes.php">Recipes</a></li>
                <?php
                if(isset($_SESSION["id"]) && isset($_SESSION["username"])){
                ?>
                <li><a href="addRecipe.php">Add Recipe</a></li>
                <?php
                }
                ?>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
            <div class="container searchContainer">
                <form action="recipes.php" method="get">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="search by ingredient or recipe title" />
                        <span class="input-group-btn"> <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-cutlery"></span></button> </span> 
                    </div>
                </form>
            </div>
        </nav>
    </header>