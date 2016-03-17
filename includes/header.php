<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <title><?=$pageTitle?></title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="/css/bootstrap.min.css" />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="stylesheet" href="/css/paperPlateDad.css" />
</head>

<body>
    <header>
        <div class="logoTitle">Paper Plate Dad</div>
        <nav>
            <ul>
                <li><a href="index.php">Recipes</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="#">Contact</a></li>
            </ul>
            <div class="container">
                <form action="index.php" method="get">
                
                
                <div class="input-group">
                    <input type="text" name="q" class="form-control" placeholder="search" />
                    <span class="input-group-btn"> <button class="btn btn-default" type="button"><span class="glyphicon glyphicon-cutlery"></span></button> </span> 
                </div>
                
                
                </form>
            </div>
        </nav>
    </header>