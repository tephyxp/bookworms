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
    $userController = new UserController();
    $userController->logout();
}


$booksController = new BooksController();
$bookId = $_GET['edit'] ?? null;
$bookIdToDelete = $_GET['delete'] ?? null;


if (isset($_GET['confirm_delete']) && $_GET['confirm_delete'] !== '') {
    $confirmDeleteId = $_GET['confirm_delete'];
    $result = $booksController->deleteBook($confirmDeleteId);

    if ($result) {
        header("Location: booksAdministration.php?success=Book deleted successfully");
        exit();
    } else {
        echo 'Error deleting the book';
    }
}


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['editBookSubmit'])) {
        $isbn = $_POST['isbn'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $image = file_get_contents($_FILES["image"]["tmp_name"]);
        $description = $_POST['description'];

        $bookId = $_POST['bookId'];
        $result = $booksController->editBook($bookId, $isbn, $title, $author, $image, $description);

        if ($result) {
            header("Location: booksAdministration.php?success=Book edited successfully");
            exit();
        } else {
            echo 'Error editing the book';
        }
    }


    if (isset($_POST['addBook'])) {
        $isbn = $_POST['isbn'];
        $title = $_POST['title'];
        $author = $_POST['author'];
        $image = file_get_contents($_FILES["image"]["tmp_name"]);
        $description = $_POST['description'];

        $result = $booksController->addBook($isbn, $title, $author, $image, $description);

        if ($result) {
            unset($_SESSION['isbn'], $_SESSION['title'], $_SESSION['author'], $_SESSION['description'], $_SESSION['image']);
            header("Location: booksAdministration.php?success=Book added successfully");
            exit();
        } else {
            echo 'Error adding the book';
        }
    }
}

$searchKeyword = $_GET['keyword'] ?? '';
$books = $booksController->searchBooks($searchKeyword);

$bookDetails = null;
if ($bookId !== null) {
    $bookDetails = $booksController->getBookDetails($bookId);
}
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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"/>
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>

<body>
    <header class="bg-bright-yellow h-16 flex items-center justify-between p-4">
        <div class="text-black font-bold text-5xl">
            Recs.
        </div>
        <a href="../../index.php">
        </a>
        <form action="" method="post">
            <input type="submit" name="logout" value="LOG OUT"
                class="text-gray-700 font-semibold border border-gray-700 py-2 px-4 bg-lilac">
        </form>
    </header>

    <main>
        <div class="">
            <div class="">
                <?php if (isset($error)) : ?>
                <div class="" role="alert">
                    <strong><?php echo $error; ?></strong>
                    <button type="button" class="" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
                <?php endif; ?>
                <?php if (isset($_GET['success'])) : ?>
                <div class="" role="alert">
                    <?php echo $_GET['success']; ?>
                    <button type="button" class="" data-bs-dismiss="alert"
                        aria-label="Close"></button>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <form action="<?= $_SERVER['PHP_SELF'] ?>" method="post"
            enctype="multipart/form-data"
            class="grid grid-cols-2 gap-4 my-4 mx-20 border border-black p-4">
            <input type="hidden" name="bookId"
                value="<?= ($bookDetails !== null) ? $bookDetails['id'] : '' ?>">

            <div>
                <label for="title"
                    class="block font-medium text-gray-800 mb-2">Title</label>
                <input type="text" id="title" name="title"
                    class="w-full border border-gray-400 p-2 h-12"
                    value="<?= (isset($_SESSION['title'])) ? $_SESSION['title'] : (($bookDetails !== null) ? $bookDetails['title'] : '') ?>"
                    required>
            </div>

            <div>
                <label for="author"
                    class="block font-medium text-gray-800 mb-2">Author</label>
                <input type="text" id="author" name="author"
                    class="w-full border border-gray-400 p-2 h-12"
                    value="<?= (isset($_SESSION['author'])) ? $_SESSION['author'] : (($bookDetails !== null) ? $bookDetails['author'] : '') ?>"
                    required>
            </div>

            <div>
                <label for="isbn"
                    class="block font-medium text-gray-800 mb-2">ISBN</label>
                <input type="text" id="isbn" name="isbn"
                    class="w-full border border-gray-400 p-2 h-12"
                    value="<?= (isset($_SESSION['isbn'])) ? $_SESSION['isbn'] : (($bookDetails !== null) ? $bookDetails['isbn'] : '') ?>"
                    required>
            </div>

            <div>
                <label for="image"
                    class="block font-medium text-gray-800 mb-2">Cover
                    Image</label>
                <input type="file" id="image" name="image"
                    class="w-full border border-gray-400 p-2"
                    value="<?= (isset($_SESSION['image'])) ? $_SESSION['image'] : '' ?>">
            </div>

            <div class="col-span-2">
                <label for="description"
                    class="block font-medium text-gray-800 mb-2">Description</label>
                <textarea id="description" name="description" rows="4"
                    class="w-full border border-gray-400 p-2"
                    required><?= (isset($_SESSION['description'])) ? $_SESSION['description'] : (($bookDetails !== null) ? $bookDetails['description'] : '') ?></textarea>
            </div>

            <div class="col-span-2 flex justify-center mb-4">
                <button type="submit"
                    name="<?= ($bookId !== null) ? 'editBookSubmit' : 'addBook' ?>"
                    class="border border-gray-600 py-2 px-4 bg-lilac"><?= ($bookId !== null) ? 'Save changes' : 'Add book' ?></button>
            </div>
        </form>

        <section
            class="m-4 pl-16 pt-4 pb-8">
            <form action="?action=search" method="get"
                class="flex items-center space-x-2">
                <input type="text" name="keyword"
                    class="w-64 border border-gray-400 py-1"
                    placeholder=" Search by title or author...">
                <button type="submit"
                    class="bg-lilac border border-gray-600 px-2 py-1">Search</button>
            </form>
        </section>


        <section>
            <div
                class="grid grid-cols-4 gap-6 mx-20 mt-4 mb-8">
                <?php if ($books): ?>
                <?php foreach ($books as $book): ?>
                <div
                    class="bg-gray-200 flex flex-col items-center justify-center pt-8 h-160 relative">
                    <img src="data:image/jpeg;base64,<?= base64_encode($book['image']) ?>"
                        class=" h-48 w-36 shadow-2xl absolute top-6"
                        alt="Cover of <?= htmlspecialchars($book['title']) ?>">
                    <div
                        class="text-center py-4 px-6">
                        <h4
                            class="text-lg font-semibold mb-1 mt-48"><?= $book['title'] ?></h4>
                        <h5
                            class="mb-2"><?= $book['author'] ?></h5>
                        <p
                            class="text-sm"><?= substr($book['description'], 0, 99) . (strlen($book['description']) > 99 ? '...' : '') ?></p>
                        <div
                            class="mt-4">
                            
                            <a
                            href="booksAdministration.php?delete=<?= $book['id'] ?>"
                            class="bg-gray-500 border border-gray-600 px-2 py-1 font-semibold text-white">
                            <i class="fas fa-trash-alt text-white mr-1"></i>
                            Delete
                            </a>
                            
                            <a
                            href="booksAdministration.php?edit=<?= $book['id'] ?>"
                            class="bg-lilac border border-gray-600 px-2 py-1 font-semibold ml-2">
                            <i class="fas fa-pen text-gray-800 mr-0.5"></i>
                            Edit
                            </a>

                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p>No books found.</p>
                <?php endif; ?>
            </div>
        </section>

        <?php if ($bookIdToDelete): ?>
        <?php
        $bookToDelete = $booksController->getBookDetails($bookIdToDelete);
        ?>
        <div
            class="fixed inset-0 flex items-center justify-center bg-gray-800 bg-opacity-75 z-50">
            <div
                class="bg-white p-6 max-w-lg w-full mx-auto">
                <h5
                    class="text-lg font-bold">Confirm
                    Deletion</h5>
                <p
                    class="my-4">Are you sure you want to delete
                    <strong><?= $bookToDelete['title'] ?></strong> by
                    <?= $bookToDelete['author'] ?>? This action cannot be undone.</p>
                <div
                    class="flex justify-end space-x-4">
                    <a
                        href="booksAdministration.php"
                        class="px-4 py-2 bg-gray-300 font-semibold">Cancel</a>
                    <a
                        href="booksAdministration.php?confirm_delete=<?= $bookIdToDelete ?>"
                        class="px-4 py-2 bg-red-600 text-white font-semibold">Delete</a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </main>
    <?php
    require_once __DIR__ . '/partials/footer.php';
    ?>

</body>

</html>
