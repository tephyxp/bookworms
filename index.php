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
$limit = 12;
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
            <button class=" text-gray-700 font-semibold border border-gray-700 py-2 px-4 bg-lilac" type="submit">LOG IN</button>
        </form>
    </header>
    <section class="flex justify-between items-center mx-20 my-8">
        <form action="?action=search" method="get" class="flex items-center space-x-2">
            <input type="text" name="keyword" class="w-64 border border-gray-400 py-1" placeholder=" Search by title or author...">
            <button type="submit" class="border border-gray-600 bg-lilac px-2 py-1">Search</button>
        </form>

        <ul class="flex gap-2 items-center">
            <li>Page:</li>
            <?php for ($i = 1; $i <= $numberOfPages; $i++) : ?>
                <li class="page-item <?= ($i == $page) ? 'underline' : 'text-gray-500' ?>">
                    <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
                </li>
            <?php endfor; ?>
        </ul>
    </section>
            <div class="grid grid-cols-4 gap-6 mx-20 mt-4">
            <?php if ($books) : ?>
                <?php foreach ($books as $book) : ?>
                    <div class="mb-8">
                        <div class="bg-gray-200 flex flex-col items-center justify-center pt-8 h-80">
                            <img src="data:image/jpeg; base64,<?= base64_encode($book['image']) ?>" class="h-48 w-36 mb-4 shadow-2xl" alt="Cover of <?= htmlspecialchars($book['title']) ?>">
                            <div class="text-center py-4 px-6">
                                <!-- <h3 class="text-xl font-bold"><?= $book['title'] ?></h3> -->
                                <!-- <h4 class="mt-2 text-lg font-medium"><strong></strong> <?= $book['author'] ?></h4> -->
                                <!-- <p class=""><strong></strong> <?= $book['description'] ?></p> -->

                            <a href="src/view/bookDetails.php?id=<?= $book['id'] ?>" class="border border-gray-600 bg-lilac px-2 py-1 font-medium">View more</a>
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

<?php
    require_once __DIR__ . '/src/view/partials/footer.php';
    ?>
