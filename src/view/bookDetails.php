<?php

use Controller\BooksController;

require_once __DIR__ . "../../../vendor/autoload.php";

$singleBook = new BooksController();

$bookId = $_GET['id'];
$bookController = new BooksController();
$book = $bookController->getBookDetails($bookId);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Recs. Book Details</title>
    <link href="../custom-styles.css" rel="stylesheet">
    <link href="../styles.css" rel="stylesheet">
    <link rel="icon" type="image/png" href="../../resources/img/favicon.ico">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body class="flex flex-col min-h-screen">
  <header class="bg-bright-yellow h-16 flex items-center justify-between p-4">
  <a href="../../index.php" class="text-black font-bold text-5xl">Recs.</a>
        <a href="../../index.php" class="text-gray-700 font-semibold border border-gray-700 py-2 px-4 bg-lilac">
        BACK ➔ </a>
    </header>

    <main class="flex-grow">
      <section class="flex flex-row py-20 justify-center">
        <img src="data:image/jpeg;base64,<?=base64_encode($book['image']) ?>" alt="Cover of <?= htmlspecialchars($book['title']) ?>" class="h-96 w-68">
        <article class="pl-10 w-3/6">
        <h3 class="font-bold text-4xl"><?= $book["title"];?></h3>
        <h4 class="font-regular text-2xl"><?= $book["author"];?></h4>
        <span class=""><?= $book["publish_date"];?></span>
        <p class="mt-2"><?= $book["description"];?></p>
        </article>
      </section>
      </main>
    <?php
    require_once __DIR__ . '/partials/footer.php';
    ?>

</body>

</html>



