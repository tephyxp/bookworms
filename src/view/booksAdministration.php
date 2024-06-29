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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recs. Admin Panel</title>
    <link href="../custom-styles.css" rel="stylesheet">
    <link href="../styles.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../../resources/img/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
</head>

<body class="">
<header class="bg-bright-yellow h-16 flex items-center justify-between p-4">
<div class="text-black font-bold text-5xl">
        Recs.
    </div>
    <a href="../../index.php">
        </a>
        <form action="" method="post">
            <input type="submit" name="logout" value="LOG OUT" class=" text-gray-700 font-semibold border border-gray-700 py-2 px-4 bg-lilac">
        </form>
    </header>

    <main>
        <div class="">
            <div class="">
                <?php if (isset($error)) : ?>
                    <div class="" role="alert">
                        <strong><?php echo $error; ?></strong>
                        <button type="button" class="" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
                <?php if (isset($_GET['success'])) : ?>
                    <div class="" role="alert">
                        <?php echo $_GET['success']; ?>
                        <button type="button" class="" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data" class="grid grid-cols-2 gap-4 my-4 mx-20 border border-black p-4">
            <input type="hidden" name="bookId" value="<?= ($bookDetails !== null) ? $bookDetails['id'] : '' ?>">

            <div>
                <label for="title" class="block font-medium text-gray-700 mb-2">Title</label>
                <input type="text" id="title" name="title" class="w-full border border-gray-400 p-2 h-12" value="<?= (isset($_SESSION['title'])) ? $_SESSION['title'] : (($bookDetails !== null) ? $bookDetails['title'] : '') ?>" required>
            </div>

            <div>
                <label for="author" class="block font-medium text-gray-700 mb-2">Author</label>
                <input type="text" id="author" name="author" class="w-full border border-gray-400 p-2 h-12" value="<?= (isset($_SESSION['author'])) ? $_SESSION['author'] : (($bookDetails !== null) ? $bookDetails['author'] : '') ?>" required>
            </div>

            <div>
                <label for="isbn" class="block font-medium text-gray-700 mb-2">ISBN</label>
                <input type="text" id="isbn" name="isbn" class="w-full border border-gray-400 p-2 h-12" value="<?= (isset($_SESSION['isbn'])) ? $_SESSION['isbn'] : (($bookDetails !== null) ? $bookDetails['isbn'] : '') ?>" required>
            </div>

            <div>
                <label for="image" class="block font-medium text-gray-700 mb-2">Cover Image</label>
                <input type="file" id="image" name="image" class="w-full border border-gray-400 p-2" value="<?= (isset($_SESSION['image'])) ? $_SESSION['image'] : '' ?>">
            </div>

            <div class="col-span-2">
                <label for="description" class="block font-medium text-gray-700 mb-2">Description</label>
                <textarea id="description" name="description" rows="4" class="w-full border border-gray-400 p-2" required><?= (isset($_SESSION['description'])) ? $_SESSION['description'] : (($bookDetails !== null) ? $bookDetails['description'] : '') ?></textarea>
            </div>

            <div class="col-span-2 flex justify-center mb-4">
                <button type="submit" name="<?= ($bookId !== null) ? 'editBookSubmit' : 'addBook' ?>" class="text-gray-700 font-semibold border border-gray-700 py-2 px-4 bg-lilac"><?= ($bookId !== null) ? 'Save changes' : 'Add book' ?></button>
            </div>
        </form>

        <section class="m-4 pl-16 pt-4 pb-8">
        <form action="?action=search" method="get" class="flex items-center space-x-2">
            <input type="text" name="keyword" class="w-64 border border-gray-400 py-1" placeholder=" Search by title or author...">
            <button type="submit" class="bg-lilac border border-gray-600 px-2 py-1">Search</button>
        </form>
        </section>

        <section>
            <div class="">
                <div class="grid grid-cols-4 gap-6 mx-20 mt-4">
                    <?php if ($books) : ?>
                        <?php foreach ($books as $book) : ?>
                            <div class="">
                                <div class="" style="width: 18rem;">
                                    <img src="data:image/jpeg; base64,<?= base64_encode($book['image']) ?>" class="" alt="Book cover image">
                                    <div class="">
                                        <h4 class=""><?= $book['title'] ?></h4>
                                        <p class=""><strong></strong> <?= $book['author'] ?></p>
                                        <p class="text-gray-600">
    <?= substr($book['description'], 0, 100) . (strlen($book['description']) > 100 ? '...' : '') ?>
</p>


                                        <div class="">
    <a class="" data-bs-toggle="modal" data-bs-target="#exampleModal<?= $book['id'] ?>">
        <i class=""></i> Delete
    </a>
    <a href="booksAdministration.php?id=<?= $book['id'] ?>" class="">
        <i class=""></i> Edit
    </a>
</div>
<div class="" id="exampleModal<?= $book['id'] ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="">
        <div class="">
            <div class="">
                <h5 class="" id="exampleModalLabel">Confirm Deletion</h5>
                <button type="button" class="" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="">
                Are you sure you want to delete <?= $book['title'] ?> by <?= $book['author'] ?>? This action cannot be undone.
            </div>
            <div class="">
                <button type="button" class="" data-bs-dismiss="modal">Cancel</button>
                <a href="booksAdministration.php?action=delete&id=<?= $book['id'] ?>" class="">Delete</a>
            </div>
        </div>
    </div>
</div>




                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <p class=""><?php echo $error ?></p>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    </main>

    <?php
    require_once __DIR__ . '/partials/footer.php';
    ?>
