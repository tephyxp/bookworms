<?php

require_once __DIR__ . "/vendor/autoload.php";

use Controller\BooksController;
use Controller\UserController;

$booksController = new BooksController();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userController = new UserController;
    $userController->login();
}

$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 8;
$totalBooks = $booksController->getTotalBooks();
$numberOfPages = ceil($totalBooks / $limit);

$searchKeyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
$books = [];

if (!empty($searchKeyword)) {
    $books = $booksController->searchBooks($searchKeyword);
} else {
    $books = $booksController->getBooksPagination($page, $limit);
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recs. Book Recommendations</title>
    <link href="../recs/src/styles.css" rel="stylesheet">
    <link href="../recs/src/custom-styles.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../recs/resources/img/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" integrity="sha512-Fo3rlrQkTy0vSTK+mkwTo1PY7x4t/TpP4KlfF/e+ux+OP7vK/lF+dyIqR+xgXM/8A1fnd7HjK1F34JqxjU8RA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</html>

<body>
<header class="bg-bright-yellow h-16 flex items-center justify-between p-4">
<div class="text-black font-bold text-5xl">
        Recs.
    </div>
        <form action="" method="post" class="flex items-center space-x-4">
            <label for="user" class="text-m">User:</label>
            <input class="w-24" type="text" name="user">
            <label for="password" class="text-m">Password:</label>
            <input class="w-24" type="password" name="password">
            <button class=" text-gray-700 font-semibold border-2 border-gray-700 py-2 px-4 bg-lilac" type="submit">START</button>
        </form>
    </header>
    <section class="flex flex-row>
        <form class="" action="?action=search" method="get">
            <div>
                <input type="text" name="keyword" class="border border-gray-400 py-1 ml-8 mt-8" placeholder=" Search...">
            </div>
            <div>
                <button type="submit" class="mt-9 ml-4">Search </button>
            </div>
        </form>
    </section>

    <div class="">
        <ul class="pagination">
            <?php for ($i = 1; $i <= $numberOfPages; $i++) : ?>
                <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
            <div class=>
            <?php if ($books) : ?>
                <?php foreach ($books as $book) : ?>
                    <div class="">
                        <div class="">
                            <img src="data:image/jpeg; base64,<?= base64_encode($book['image']) ?>" class="" alt="Book Image">
                            <div class="">
                                <h4 class=""><?= $book['title'] ?></h4>
                                <p class=""><strong></strong> <?= $book['author'] ?></p>
                                <p class=""><strong></strong> <?= $book['description'] ?></p>

                            <a href="src/view/bookDetails.php?id=<?= $book['id'] ?>" class="">View more</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>There are no books in the database</p>
        <?php endif; ?>
    </div>
</div>


</body>
</html>
