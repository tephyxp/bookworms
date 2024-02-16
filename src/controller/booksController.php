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

        public function addBook($isbn, $title, $author, $image, $description)
        {
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addBook'])) {

                $isbn = $_POST['isbn'];
                $title = $_POST['title'];
                $author = $_POST['author'];
                $description = $_POST['description'];

                // Verificar si se ha seleccionado una imagen y procesarla
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $image_tmp = $_FILES['image']['tmp_name'];
                    $image_content = file_get_contents($image_tmp);
                    // Escapar los datos de la imagen
                    $image = addslashes($image_content);
                } else {
                    
                    $image = null;
                }
                        
                if( !empty($isbn) && !empty($title) && !empty($author) && !empty($image) && !empty($description) ) {
                    $result = $this->model->addBook($isbn, $title, $author, $image, $description);
                    return header( "Location: ../view/booksAdministration.php");
                } else {
                    return 'Error al crear el libro';
                }
            }
        }
    }
