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
    }
