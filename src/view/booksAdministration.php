<?php

require_once __DIR__ . "/../../vendor/autoload.php";

use Controller\BooksController;
use Controller\UserController;

session_start();

if (!isset($_SESSION['user'])) {

    header("Location: ../../index.php");
    exit();
}

if (isset($_POST['logout'])) {
    $userController = new UserController;
    $userController->logout();
}


if (isset($_POST["addBook"])) {
    if( empty($_POST["isbn"])|| empty($_POST["title"]) || empty($_POST["author"]) || empty( $_FILES["image"]) || empty($_POST["description"])){
        $error = "Error! campos vacios";
    } else {  
        $isbn = $_POST["isbn"];
        $title = $_POST["title"];
        $author = $_POST["author"];
        $image = file_get_contents($_FILES["image"]["tmp_name"]); 
        $description = $_POST["description"];

        $newbook = new BooksController;

        $newbook->addBook($isbn, $title, $author, $image, $description);
    }
}

?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookWorms Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    
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
        <div class="row">
            <div class="col-sm-12">
            <?php if(isset($error)) : ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <strong><?php echo $error; ?></strong> 
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>
            </div>  
        </div>
        <form action="" method="post" enctype="multipart/form-data" class="form-control">
            <div>
                <label for="title" class="form-control">Titulo:
                    <input class="form-control" type="text" name="title">
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
            <button type="submit" name="addBook">Añadir</button>
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

    <?php
        require_once __DIR__ . '/head/footer.php';
    ?>