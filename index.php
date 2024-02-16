<?php


require_once __DIR__ . "/vendor/autoload.php";

use Controller\BooksController;
use Controller\UserController;


$booksController = new BooksController();
$books = $booksController->getBooks();
// var_dump($books);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userController = new UserController;
    $userController->login();
}

?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link rel="stylesheet" href="./resources/styles.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
</head>

<body>
    <header>
        <form action="" method="post">
            <label for="user">Usuario:</label>
            <input type="text" name="user">
            <label for="password">Contraseña:</label>
            <input type="password" name="password">
            <button type="submit">Iniciar sesión</button>

        </form>
    </header>
    <h1>es SOLO una prueba</h1>

    <div class="container mt-5">
    <div class="row g-4">
        <?php if ($books) : ?>
            <?php foreach ($books as $book) : ?>
                <div class="col-md-3">
                    <div class="card custom-card" style="width: 18rem;">
                        <img src="data:image/jpeg;base64,<?= base64_encode($book['image']) ?>" class="rounded-3 card-img-top py-3 px-5 " alt="Book Image">
                        <div class="card-body d-flex flex-column justify-content-center align-items-center">
                            <h4 class="card-title text-center"><?= $book['title'] ?></h4>
                            <p class="card-text text-center fw-bolder"><strong></strong> <?= $book['author'] ?></p>
                            <p class="card-text small text-center"><strong></strong> <?= $book['description'] ?></p>
                            <!-- <p class="card-text"><strong>ISBN:</strong> <?= $book['isbn'] ?></p> -->
                            <button href="#" class="btn btn-light rounded-3"style="background-color: #8bca54;color: white;">Ver más</button>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else : ?>
            <p>No hay libros en la base de datos.</p>
        <?php endif; ?>
    </div>
</div>


    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
</body>

</html>