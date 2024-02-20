<?php

namespace Tests;

use Controller\BooksController;
use PHPUnit\Framework\TestCase;

class BooksControllerTest extends TestCase


{
    public function testsThatThereIsAGetBooksFunction()
        {
        $this->assertTrue(
            method_exists(BooksController::class, 'getBooks'),
            'BooksController class does not include getBooks function'
        );
    }

    public function testsThatThereIsASearchBooksFunction()
        {   
        $this->assertTrue(
            method_exists(BooksController::class, 'searchBooks'),
            'BooksController class does not include searchBooks function'
        );   
    }

    public function testSearchBooksFunctionality()
    {
        // given
        $controller = new BooksController();
        $keyword = 'George';
        // when
        $result = $controller->searchBooks($keyword);
        // then
        $this->assertNotEmpty($result, 'No results found for the keyword: ' . $keyword);
    }
    
    public function testThatThereIsADeleteBookFunction ()
    {
      $this->assertTrue(
        method_exists(BooksController::class, 'deleteBook'),
        'BooksController class does not include deleteBook function'
    );
    }

    public function testThatThereIsAnAddBookFunction ()
    {
      $this->assertTrue(
        method_exists(BooksController::class, 'addBook'),
        'BooksController class does not include addBook function'
    );
    }


    public function testThatThereIsAnEditBookFunction ()
    {
      $this->assertTrue(
        method_exists(BooksController::class, 'editBook'),
        'BooksController class does not include editBook function'
    );
    }
} 
?>
