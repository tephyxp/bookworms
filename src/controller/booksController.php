<?php

namespace Controller;

use Model\booksModel;

class BooksController
{
    private $model;

    public function __construct()
    {
        $this->model = new booksModel();
    }

    public function setModel(booksModel $model)
    {
        $this->model = $model;
    }

    public function getBooks()
    {
        return ($this->model->getBooks()) ? $this->model->getBooks() : 'There are no books in the database';
    }

    public function getTotalBooks()
    {
        return ($this->model->getTotalBooks() > 0) ? $this->model->getTotalBooks() : 'There are no books in the database';
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
        return $this->model->searchBooks($keyword);
    }

    public function addBook($publish_date, $title, $author, $image, $review)
    {
        if (!empty($publish_date) && !empty($title) && !empty($author) && !empty($image) && !empty($review)) {
            $result = $this->model->addBook($publish_date, $title, $author, $image, $review);
            $success = 'The details were added correctly';
            return header("Location: ../view/booksAdministration.php?success=" . urlencode($success));
        } else {
            return 'Error creating the book';
        }
    }

    public function deleteBook($id)
    {
        $result = $this->model->deleteBook($id);
        if ($result) {
            $success = 'Book deleted successfully';
            return header("Location: ../view/booksAdministration.php?success=" . urlencode($success));
        } else {
            return 'Error deleting the book';
        }
    }

    public function editBook($id, $publish_date, $title, $author, $image, $review)
    {
        $result = $this->model->editBook($id, $publish_date, $title, $author, $image, $review);
        $success = 'The details were edited correctly';

        return ($result) ? header("Location: ../view/booksAdministration.php?success=" . urlencode($success)) : 'Error editing the book';
    }
}

