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

        public function getBooks(){
            return ($this ->model->getBooks()) ? $this->model->getBooks() : 'No hay libros en la base de datos';
        }

        public function getBookDetails($id){
            return ($this ->model->getBookDetails($id) !=false) ? $this->model->getBookDetails($id) : 'El libro no existe';
        }

        public function searchBooks(){
            $keyword = isset($_GET['keyword']) ? $_GET['keyword'] : '';
            return  $this->model->searchBooks($keyword);
        }
    }
