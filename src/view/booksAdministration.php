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
    if (empty($_POST["isbn"]) || empty($_POST["title"]) || empty($_POST["author"]) || empty($_FILES["image"]) || empty($_POST["description"])) {
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

$booksController = new BooksController();
$books = $booksController->getBooks();

if (isset($_GET['id'])) {
    $booksController->deleteBook($_GET['id']);
}
?>

<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BookWorms Admin</title>

    <link rel="stylesheet" href="../../resources/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&display=swap">

</head>

<body class="custom-bd">
    <header class="my-3 mx-5 d-flex justify-content-between align-items-center">
        <img src="../../resources/img/bookworms.png" alt="Logo" class="logo">
        <form action="" method="post">
            <input type="submit" name="logout" value="Cerrar Sesion" class="btn btn-primary mb-3 secondary-button">
        </form>
    </header>
    <main>
        <h1 class="m-3 text-center my-5 first-title">BOOKWORMS</h1>
        <div class="row">
            <div class="col-sm-12">
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><?php echo $error; ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <form action="" method="post" enctype="multipart/form-data" class="form-control">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="mb-3">
                            <label for="title" class="custom-input mb-2">Titulo:
                                <input class="form-control custom-input mb-2" type="text" name="title">
                            </label>
                        </div>
                        <div class="mb-3">
                            <label for="author">Autor:
                                <input type="text" name="author" class="custom-input form-control mb-2">
                            </label>
                        </div>
                        <label for="isbn">ISBN:
                            <input type="text" name="isbn" class="custom-input form-control mb-2"> </input>
                        </label>
                    </div>
                    <div class="col-md-6">
                        <label for="image">Imagen:
                            <input type="file" name="image" class="mb-2"> </input>
                        </label>
                        <label for="description">Descripción:
                            <textarea name="description" class="custom-input mb-2"> </textarea>
                        </label>
                    </div>
                    <div class="col-md-12 text-center mt-3">    
                        <button type="submit" name="addBook" class="btn btn-primary mb-3 custom-button primary-button ">Añadir</button>
                    </div>
                </div>
            </div>
        </form>

        <input type="search" id="search" placeholder="Buscar..." />
        <button>Buscar</button>

        <section>
            <div>
                <p>delete</p>
                <p>edit</p>
                <article>
                    <?php if ($books) : ?>
                        <?php foreach ($books as $book) : ?>
                            <div class="col-md-3">
                                <div class="card custom-card" style="width: 18rem;">
                                    <img src="data:image/jpeg; base64,<?= base64_encode($book['image']) ?>" class="rounded-3 card-img-top py-3 px-5 " alt="Book Image">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <h4 class="card-title text-center"><?= $book['title'] ?></h4>
                                        <p class="card-text text-center fw-bolder"><strong></strong> <?= $book['author'] ?></p>
                                        <p class="card-text small text-center"><strong></strong> <?= $book['description'] ?></p>
                                        <a href="../view/booksAdministration.php?id=<?= $book['id'] ?>" class="btn btn-danger rounded-3">Eliminar</a>
                                        <a href="#" class="btn btn-success rounded-3">Editar</a>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p>No hay libros en la base de datos.</p>
                    <?php endif; ?>
                </article>
            </div>
        </section>
    </main>


    <?php
    require_once __DIR__ . '/head/footer.php';
    ?>