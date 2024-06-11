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
$bookId =  $_GET['id'] ?? null;

$books = $booksController->getBooks();
$bookDetails = null;

if ($bookId !== null) {
    $bookDetails = $booksController->getBookDetails($bookId);
}

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
    unset($_SESSION['isbn'], $_SESSION['title'], $_SESSION['author'], $_SESSION['description']);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST["addBook"])) {
        if (empty($_POST["isbn"]) || empty($_POST["title"]) || empty($_POST["author"]) || empty($_FILES["image"]) || empty($_POST["description"])) {
            $_SESSION['isbn'] = $_POST["isbn"];
            $_SESSION['title'] = $_POST["title"];
            $_SESSION['author'] = $_POST["author"];
            $_SESSION['image'] = $_FILES["image"];
            $_SESSION['description'] = $_POST["description"];

            $error = "Error! All fields are compulsory!";
        } else {
            $isbn = $_POST["isbn"];
            $title = $_POST["title"];
            $author = $_POST["author"];
            $image = file_get_contents($_FILES["image"]["tmp_name"]);
            $description = $_POST["description"];

            $newbook = new BooksController;

            $newbook->addBook($isbn, $title, $author, $image, $description);
        
            exit();
        }
    } elseif (isset($_POST['editBookSubmit'])) {
        $isbn = $_POST['isbn'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $image = file_get_contents($_FILES["image"]["tmp_name"]);
        $description = $_POST['description'];

        $bookId = $_POST['bookId'];
        $result = $booksController->editBook($bookId, $isbn, $title, $author, $image, $description);

        if ($result) {
            exit();
        } else {
            echo 'Error editing the book';
        }
    }
}

    $searchKeyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
    $books = $booksController->searchBooks($searchKeyword);
?>

<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recs. Admin Page</title>

    <link rel="stylesheet" href="../../resources/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Lexend+Deca:wght@100..900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="icon" type="image/png" href="../../resources/img/favicon.ico">
    <style>
        .form-control {
            display: grid;
        }
    </style>
</head>

<body class="custom-bd">
    <header class="my-3 mx-5 d-flex justify-content-between align-items-center">
        <a href="../../index.php">
        </a>
        <form action="" method="post">
            <input type="submit" name="logout" value="Log out" class="btn btn-primary mb-3 secondary-button">
        </form>
    </header>

    <main>
        <div class="row">
            <div class="d-flex justify-content-around mx-2 col-sm-12">
                <?php if (isset($error)) : ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <strong><?php echo $error; ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if (isset($_GET['success'])) : ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <?php echo $_GET['success']; ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <div class="d-flex justify-content-around">
                <div class="left-column">
                    <input type="hidden" name="bookId" value="<?= ($bookDetails !== null) ? $bookDetails['id'] : '' ?>">

                    <div class="mb-2">
                        <label for="title">Title:
                            <input class="form-control custom-input-form mb-2" type="text" name="title" value="<?= (isset($_SESSION['title'])) ? $_SESSION['title'] : (($bookDetails !== null) ? $bookDetails['title'] : '') ?>">

                        </label>
                    </div>
                    <div class="mb-2">
                        <label for="author">Author:
                            <input type="text" name="author" value="<?= (isset($_SESSION['author'])) ? $_SESSION['author'] : (($bookDetails !== null) ? $bookDetails['author'] : '') ?>" class="custom-input-form form-control mb-2">
                        </label>
                    </div>
                    <div class="mb-2">
                        <label for="isbn">ISBN:
                            <input type="text" name="isbn" value="<?= (isset($_SESSION['isbn'])) ? $_SESSION['isbn'] : (($bookDetails !== null) ? $bookDetails['isbn'] : '') ?>" class="custom-input-form form-control mb-2" />
                        </label>
                    </div>
                </div>
                <div class="right-column">
                    <div class="mb-2">
                        <label for="image" class="custom-input-image">Cover image:
                            <input type="file" name="image" class="mb-2 form-control custom-input-image " value="<?= (isset($_SESSION['image'])) ? $_SESSION['image'] : ''  ?>" />
                        </label>
                    </div>
                    <div class="mb-2">
                        <label for="description">Description:
                            <textarea name="description" class="custom-input-form form-control mb-2"><?= (isset($_SESSION['description'])) ? $_SESSION['description'] : (($bookDetails !== null) ? $bookDetails['description'] : '')?></textarea>
                        </label>
                    </div>
                </div>
            </div>
            <div class="col-md-12 text-center mt-4">
                <button type="submit" name="<?= ($bookId !== null) ? 'editBookSubmit' : 'addBook' ?>" class="btn btn-primary mb-3 custom-button primary-button"><?= ($bookId !== null) ? 'Save changes' : 'Add book' ?></button>
            </div>
        </form>

        <section class="d-flex justify-content-center">
            <form class="row g-3 m-2" action="?action=search" method="get">
                <div class="col-auto">
                    <input type="text" name="keyword" class="form-control custom-input" placeholder="Search...">
                </div>
                <div class="col-auto">
                    <button type="submit" class="btn btn-primary mb-3 secondary-button">Search </button>
                </div>
            </form>
        </section>

        <section>
            <div class="container mt-5">
                <div class="row g-4">
                    <?php if ($books) : ?>
                        <?php foreach ($books as $book) : ?>
                            <div class="col-md-3 mb-4">
                                <div class="card custom-card" style="width: 18rem;">
                                    <img src="data:image/jpeg; base64,<?= base64_encode($book['image']) ?>" class="card-img-top py-3 px-5 " alt="Book cover image">
                                    <div class="card-body d-flex flex-column justify-content-center align-items-center">
                                        <h4 class="card-title text-center"><?= $book['title'] ?></h4>
                                        <p class="card-text text-center fw-bolder"><strong></strong> <?= $book['author'] ?></p>
                                        <p class="card-text small text-center description"><strong></strong> <?= $book['description'] ?></p>

                                        <div class="d-flex justify-content-between align-items-center w-90">
    <a class="btn btn-danger mx-1 py-2 px-3" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $book['id'] ?>">
        <i class="fa fa-trash"></i> Delete
    </a>
    <a href="booksAdministration.php?id=<?= $book['id'] ?>" class="secondary-button-book mx-1 py-2 px-3">
        <i class="fa fa-edit"></i> Edit
    </a>
</div>
<div class="modal fade" id="exampleModal<?= $book['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete <?= $book['title'] ?> by <?= $book['author'] ?>? This action cannot be undone.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                <a href="booksAdministration.php?action=delete&id=<?= $book['id'] ?>" class="btn btn-danger">Delete</a>
            </div>
        </div>
    </div>
</div>




                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class="col-12"><?php echo $error ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <?php
    require_once __DIR__ . '/head/footer.php';
    ?>
