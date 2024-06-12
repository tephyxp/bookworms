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


$pageTitle = "Recs. Book Recommendations";
include __DIR__ . '/src/view/layout.php';

?>

<body>
    <header class="">
        <a href="./index.php">
        </a>
        <form action="" method="post" class=>
            <label for="user" class="">User:</label>
            <input class="" type="text" name="user">
            <label for="password" class="">Password:</label>
            <input class="custom-input me-2 " type="password" name="password">
            <button class="" type="submit">Start session</button>
        </form>
    </header>
    <section class="">
        <form class="" action="?action=search" method="get">
            <div class="">

                <input type="text" name="keyword" class="" id="inputPassword2" placeholder="Search...">
            </div>
            <div class="">
                <button type="submit" class="">Search </button>
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
            <div class="">
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
