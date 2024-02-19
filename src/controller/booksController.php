<?php

namespace Controller;

use Model\booksModel;

class BooksController
{
    private $model;

    public function __construct()
    {
        $this->model = new booksModel;
    }

    public function getBooks()
    {
        return ($this->model->getBooks()) ? $this->model->getBooks() : 'No hay libros en la base de datos';
    }

    public function getTotalBooks(){
        return ($this ->model->getTotalBooks()  > 0) ? $this->model->getTotalBooks() : 'No hay libros en la base de datos';
    }

    public function getBooksPagination($page, $limit)
    {
        return ($this->model->getBooksPagination($page, $limit)) ? $this->model->getBooksPagination($page, $limit) : 'No hay libros en la base de datos';
    }

    public function getBookDetails($id)
    {
        return ($this->model->getBookDetails($id) != false) ? $this->model->getBookDetails($id) : 'El libro no existe';
    }

    public function searchBooks($keyword)
    {
        $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        return  $this->model->searchBooks($keyword);
    }

    public function addBook($isbn, $title, $author, $image, $description)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addBook'])) {

            if (!empty($isbn) && !empty($title) && !empty($author) && !empty($image) && !empty($description)) {
                $result = $this->model->addBook($isbn, $title, $author, $image, $description);
                $success = 'Los datos fueron añadidos correctamente';
                return header("Location: ../view/booksAdministration.php?success=" . urlencode($success));
            } else {
                return 'Error al crear el libro';
            }
        }
    }

    public function deleteBook($id)
    {
        return ($this->model->deleteBook($id)) ? header("Location: ../view/booksAdministration.php") : 'error eliminar libro';
    }


    public function editBook($id, $isbn, $title, $author, $image, $description)
    {
        $result = $this->model->editBook($id, $isbn, $title, $author, $image, $description);
        $success = 'Los datos fueron editados correctamente';

        return ($result) ?  header("Location: ../view/booksAdministration.php?success=" . urlencode($success)): 'error al Editar libro';
    }
}
