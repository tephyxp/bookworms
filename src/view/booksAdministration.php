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

$booksController = new BooksController();
$bookId = isset($_GET['id']) ? $_GET['id'] : null;

$books = $booksController->getBooks();
$bookDetails = null;


if ($bookId !== null) {
    $bookDetails = $booksController->getBookDetails($bookId);
}

// if (isset($_POST["addBook"])) {
//     if (empty($_POST["isbn"]) || empty($_POST["title"]) || empty($_POST["author"]) || empty($_FILES["image"]) || empty($_POST["description"])) {
//         $error = "Error! campos vacios";
//     } else {
//         $isbn = $_POST["isbn"];
//         $title = $_POST["title"];
//         $author = $_POST["author"];
//         $image = file_get_contents($_FILES["image"]["tmp_name"]);
//         $description = $_POST["description"];

//         $newbook = new BooksController;

//         $newbook->addBook($isbn, $title, $author, $image, $description);
//     }
// }



if (isset($_GET['action']) && $_GET['action'] === 'delete' && $bookId !== null) {
    $result = $booksController->deleteBook($bookId);

    if ($result) {
        header("Location: ../view/booksAdministration.php");
        exit();
    } else {
        echo 'Error al eliminar el libro';
    }
}




if ($_SERVER['REQUEST_METHOD'] === 'POST') {
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
            // Redireccion a la pagina principal de libros con mensaje de exito
            header("Location: ../view/booksAdministration.php"); 
            exit();
        }
    }elseif (isset($_POST['editBookSubmit'])) { 
        
        $isbn = $_POST['isbn'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $image = file_get_contents($_FILES["image"]["tmp_name"]);
        $description = $_POST['description'];
        
        
        $bookId = $_POST['bookId']; 
        $result = $booksController->editBook($bookId, $isbn, $title, $author, $image, $description);

        if ($result) {
            header("Location: ../view/bookDetails.php?id=".$bookId);
            exit();
        } else {
            echo 'Error al editar el libro';
        }
    }
}
// if (isset($_GET['id'])) {
//     $booksController->deleteBook($_GET['id']);
// }
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
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" class="form-control">
            <div>
                <input type="hidden" name="bookId" value="<?= ($bookDetails !== null) ? $bookDetails['id'] : '' ?>">
                <label for="title" class="form-control">Titulo:
                    <input class="form-control" type="text" name="title" value="<?= ($bookDetails !== null) ? $bookDetails['title'] : '' ?>">
                </label>
                <label for="author">Autor:
                    <input type="text" name="author" value="<?= ($bookDetails !== null) ? $bookDetails['author'] : '' ?>">
                </label>
                <label for="isbn">ISBN:
                    <input type="text" name="isbn" value="<?= ($bookDetails !== null) ? $bookDetails['isbn'] : '' ?>"/> 
                </label>
                <label for="image">Imagen:
                    <input type="file" name="image" /> 
                </label>
                <label for="description">Descripción:
                    <textarea name="description"><?= ($bookDetails !== null) ? $bookDetails['description'] : '' ?></textarea>
                </div>
                <button type="submit" name="<?= ($bookId !== null) ? 'editBookSubmit' : 'addBook' ?>">
                <?= ($bookId !== null) ? 'Guardar Cambios' : 'Añadir' ?>
                </button>
        </form>

        <input type="search" id="search" placeholder="Buscar..." />
        <button>Buscar</button>

        <section>
            <div>
                
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
                                        <a class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">Eliminar</a>
                                        
                                        <a href="../view/booksAdministration.php?id=<?= $book['id'] ?>" class="btn btn-success rounded-3">Editar</a>
                                    </div>
                                </div>
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel">¿Desea eliminar el registro?</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Una vez eliminado no se podra recuperar el registro
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-success" data-bs-dismiss="modal">Cerrar</button>
                                        <a href="../view/booksAdministration.php?action=delete&id=<?= $book['id'] ?>" class="btn btn-danger rounded-3">Eliminar</a>
                                    </div>
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