<?php

use Controller\BooksController;

require_once __DIR__ . "../../../vendor/autoload.php";

$singleBook = new BooksController();

$book = $singleBook->getBookDetails($_GET["id"]);
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Bootstrap demo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" 
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Roboto+Slab:wght@400;700&display=swap">
    <style>
    .custom-blue-text {
      color: #073060;
      /* font-family:'Roboto-Slab, serif'; */
    }
    .paragraph-text {
      color: #073060;
      text-align: justify;
    }
    body {
      background-color: #F6EEE0;
    }
    </style>
  
</head>
  <body>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    <article class="text-center w-50 m-auto">
    <h2 class="custom-blue-text">BOOKWORMS</h2>

    <img src="data:image/jpeg;base64,<?=base64_encode($book['image']) ?>" alt="Book Image" class="img-fluid w-20 h-40">

    <h3 class="custom-blue-text mt-4"><?= $book["title"];?></h3>
    <h4 class="custom-blue-text mt-3"><?= $book["author"];?></h4>
    <p class="paragraph-text mt-3"><?= $book["description"];?></p>
    </article>
  </body>
</html>



