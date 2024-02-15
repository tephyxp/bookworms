<?php

use Controller\BooksController;

require_once __DIR__ . "../../../vendor/autoload.php";

$singleBook = new BooksController();

$book = $singleBook->getBookDetails($_GET["id"]);
//var_dump($book);
?>

<h2>Libro</h2>

<p><?= $book["title"];?></p>
<p><?= $book["author"];?></p>
<p><?= $book["description"];?></p>
<img src="data:image/jpeg;base64,<?=base64_encode($book['image']) ?>" alt="Book Image">

