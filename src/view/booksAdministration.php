<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use Controller\UserController;

session_start();

if (!isset($_SESSION['user'])) {

    header("Location: ../../index.php");
    exit();
}

if (isset($_POST['logout'])) {
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
    <main>
        <h1>Bookworms</h1>
        <form action="" method="post">
            <div>
                <label for="title">Titulo:
                    <input type="text" name="title">
                </label>
                <label for="author">Autor:
                    <input type="text" name="author">
                </label>
                <label for="isbn">ISBN:
                    <input type="text" name="isbn"> </input>
                </label>
                <label for="image">Imagen:
                    <input type="file" name="image"> </input>
                </label>
                <label for="description">Descripción:
                    <textarea name="description"> </textarea>
            </div>
            <button type="submit">Añadir</button>
        </form>

        <input type="search" id="search" placeholder="Buscar..." />
        <button>Buscar</button>

        <section>
            <div>
                <p>delete</p>
                <p>edit</p>
                <article>
                    <img src="" alt="portada  del libro"/>
                    <div>
                        <h3>Title</h3>
                        <h4>Autor</h4>
                        <p>Descripción</p>
                    </div>
                </article>
            </div>
        </section>
    </main>
</body>

</html>