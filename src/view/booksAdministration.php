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
                <?php if (isset($error)) : ?>
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