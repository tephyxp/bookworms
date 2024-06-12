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


$pageTitle = "Recs. Admin Panel";
include __DIR__ . '/layout.php';

?>

<body class="">
    <header class="">
        <a href="../../index.php">
        </a>
        <form action="" method="post">
            <input type="submit" name="logout" value="Log out" class="">
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
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post" enctype="multipart/form-data">
            <div class="">
                <div class="">
                    <input type="hidden" name="bookId" value="<?= ($bookDetails !== null) ? $bookDetails['id'] : '' ?>">

                    <div class="">
                        <label for="title">Title:
                            <input class="" type="text" name="title" value="<?= (isset($_SESSION['title'])) ? $_SESSION['title'] : (($bookDetails !== null) ? $bookDetails['title'] : '') ?>">

                        </label>
                    </div>
                    <div class="">
                        <label for="author">Author:
                            <input type="text" name="author" value="<?= (isset($_SESSION['author'])) ? $_SESSION['author'] : (($bookDetails !== null) ? $bookDetails['author'] : '') ?>" class="">
                        </label>
                    </div>
                    <div class="">
                        <label for="isbn">ISBN:
                            <input type="text" name="isbn" value="<?= (isset($_SESSION['isbn'])) ? $_SESSION['isbn'] : (($bookDetails !== null) ? $bookDetails['isbn'] : '') ?>" class="" />
                        </label>
                    </div>
                </div>
                <div class="">
                    <div class="">
                        <label for="image" class="">Cover image:
                            <input type="file" name="image" class="" value="<?= (isset($_SESSION['image'])) ? $_SESSION['image'] : ''  ?>" />
                        </label>
                    </div>
                    <div class="">
                        <label for="description">Description:
                            <textarea name="description" class=""><?= (isset($_SESSION['description'])) ? $_SESSION['description'] : (($bookDetails !== null) ? $bookDetails['description'] : '')?></textarea>
                        </label>
                    </div>
                </div>
            </div>
            <div class="">
                <button type="submit" name="<?= ($bookId !== null) ? 'editBookSubmit' : 'addBook' ?>" class=""><?= ($bookId !== null) ? 'Save changes' : 'Add book' ?></button>
            </div>
        </form>

        <section class="">
            <form class="" action="?action=search" method="get">
                <div class="">
                    <input type="text" name="keyword" class="" placeholder="Search...">
                </div>
                <div class="">
                    <button type="submit" class="">Search </button>
                </div>
            </form>
        </section>

        <section>
            <div class="">
                <div class="">
                    <?php if ($books) : ?>
                        <?php foreach ($books as $book) : ?>
                            <div class="">
                                <div class="" style="width: 18rem;">
                                    <img src="data:image/jpeg; base64,<?= base64_encode($book['image']) ?>" class="" alt="Book cover image">
                                    <div class="">
                                        <h4 class=""><?= $book['title'] ?></h4>
                                        <p class=""><strong></strong> <?= $book['author'] ?></p>
                                        <p class=""><strong></strong> <?= $book['description'] ?></p>

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

    ?>
