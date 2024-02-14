<?php


    require_once __DIR__ . "/vendor/autoload.php";
    use Controller\BooksController;
    
    $booksController = new BooksController();
    $books = $booksController->getBooks();
    // var_dump($books);

?>

<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Bootstrap demo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    </head>
    <body>
        <h1>es SOLO una prueba</h1>
        
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">Titulo</th>
                    <th scope="col">Autor</th>
                    <th scope="col">Descripción</th>
                    <th scope="col">ISBN</th>
                </tr>
            </thead>
            <tbody>
                <?php if($books): ?>
                    <?php foreach ($books as $book) : ?>  
                        <tr> 
                            <td><?=$book['title'] ?></td>
                            <td><?=$book['author'] ?></td>
                            <td><?=$book['description'] ?></td>
                            <td><?=$book['isbn'] ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No hay libros en la base de datos.</p>
                <?php endif; ?>
            </tbody>
            </table>

        ?>

        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    </body>
</html>