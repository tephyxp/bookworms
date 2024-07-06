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
        return ($this->model->getBooks()) ? $this->model->getBooks() : 'There are no books in the database';
    }

    public function getTotalBooks(){
        return ($this ->model->getTotalBooks()  > 0) ? $this->model->getTotalBooks() : 'There are no books in the database';
    }

    public function getBooksPagination($page, $limit)
    {
        return ($this->model->getBooksPagination($page, $limit)) ? $this->model->getBooksPagination($page, $limit) : 'There are no books in the database';
    }

    public function getBookDetails($id)
    {
        return ($this->model->getBookDetails($id) != false) ? $this->model->getBookDetails($id) : 'This book is not on file';
    }

    public function searchBooks($keyword)
    {
        // $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
        return  $this->model->searchBooks($keyword);
    }

    public function addBook($publish_date, $title, $author, $image, $description)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addBook'])) {

            if (!empty($publish_date) && !empty($title) && !empty($author) && !empty($image) && !empty($description)) {
                $result = $this->model->addBook($publish_date, $title, $author, $image, $description);
                $success = 'The details were added correctly';
                return header("Location: ../view/booksAdministration.php?success=" . urlencode($success));
            } else {
                return 'Error creating the book';
            }
        }
    }

    public function deleteBook($id)
    {
        return ($this->model->deleteBook($id)) ? header("Location: ../view/booksAdministration.php") : 'Error deleting the book';
    }


    public function editBook($id, $publish_date, $title, $author, $image, $description)
    {
        $result = $this->model->editBook($id, $publish_date, $title, $author, $image, $description);
        $success = 'The details were edited correctly';

        return ($result) ?  header("Location: ../view/booksAdministration.php?success=" . urlencode($success)): 'Error editing the book';
    }
}
