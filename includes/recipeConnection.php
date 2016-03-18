<?php
$connection;

function openConnection()
{
    global $connection;
    $dbPassword='cooking';
    $dbUser='chef';
    $dbServer='localhost';
    $dbName='recipes';
    
    try{
        $connection = new PDO('mysql:host='.$dbServer.';dbname='.$dbName.'',$dbUser, $dbPassword);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $connection;
    }catch(PDOException $e){
        echo $e->getMessage();       
    }
}
?>