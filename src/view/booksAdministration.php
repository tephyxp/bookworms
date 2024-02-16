<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use Controller\UserController;

session_start();

if(!isset($_SESSION['user'])){
    
    header("Location: ../../index.php");
    exit();
}

if (isset($_POST['logout'])){
    echo "entra";
    $userController = new UserController;
    $userController->logout();
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <header>
        <img src="" alt="">
        <form action="" method="post">
            <input type="submit" name="logout" value="Cerrar Sesion">
        </form>
    </header>
    <h1>Administration</h1>
</body>
</html>