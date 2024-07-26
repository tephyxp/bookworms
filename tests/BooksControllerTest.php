<?php

namespace Tests;

use Controller\BooksController;
use Model\booksModel;
use PHPUnit\Framework\TestCase;

class BooksControllerTest extends TestCase
{
    private $modelMock;
    private $controller;

    protected function setUp(): void
    {
    
        $this->modelMock = $this->createMock(booksModel::class);

        $this->controller = new BooksController();
        $this->controller->setModel($this->modelMock);
    }

    public function testThatThereIsAGetBooksFunction()
    {
        $this->assertTrue(
            method_exists(BooksController::class, 'getBooks'),
            'BooksController class does not include getBooks function'
        );
    }

    public function testThatThereIsASearchBooksFunction()
    {
        $this->assertTrue(
            method_exists(BooksController::class, 'searchBooks'),
            'BooksController class does not include searchBooks function'
        );
    }

    public function testSearchBooksFunctionality()
    {
        $keyword = 'Maggie';
        $expectedResult = ['Book 1', 'Book 2'];

        $this->modelMock->expects($this->once())
                        ->method('searchBooks')
                        ->with($keyword)
                        ->willReturn($expectedResult);

        $result = $this->controller->searchBooks($keyword);
        $this->assertNotEmpty($result, 'No results found for the keyword: ' . $keyword);
        $this->assertEquals($expectedResult, $result, 'The search results do not match the expected results.');
    }

    public function testThatThereIsADeleteBookFunction()
    {
        $this->assertTrue(
            method_exists(BooksController::class, 'deleteBook'),
            'BooksController class does not include deleteBook function'
        );
    }

    public function testThatThereIsAnAddBookFunction()
    {
        $this->assertTrue(
            method_exists(BooksController::class, 'addBook'),
            'BooksController class does not include addBook function'
        );
    }

    public function testThatThereIsAnEditBookFunction()
    {
        $this->assertTrue(
            method_exists(BooksController::class, 'editBook'),
            'BooksController class does not include editBook function'
        );
    }

    public function testAddBookFunctionality()
    {
        $publish_date = '2023';
        $title = 'Book';
        $author = 'Author';
        $image = 'image.jpg';
        $review = 'Great book!';
        $expectedResult = true;

    
        $this->modelMock->expects($this->once())
                        ->method('addBook')
                        ->with($publish_date, $title, $author, $image, $review)
                        ->willReturn($expectedResult);

    
        $this->controller->addBook($publish_date, $title, $author, $image, $review);
    }

    public function testEditBookFunctionality()
    {
        $id = 1;
        $publish_date = '2023';
        $title = 'Updated Book';
        $author = 'Updated Author';
        $image = 'updated_image.jpg';
        $review = 'Updated review';
        $expectedResult = true;

        $this->modelMock->expects($this->once())
                        ->method('editBook')
                        ->with($id, $publish_date, $title, $author, $image, $review)
                        ->willReturn($expectedResult);

        $this->controller->editBook($id, $publish_date, $title, $author, $image, $review);
    }


    public function testDeleteBookFunctionality()
    {
        $id = 1;
        $expectedResult = true;

        $this->modelMock->expects($this->once())
                        ->method('deleteBook')
                        ->with($id)
                        ->willReturn($expectedResult);
        
        $this->controller->deleteBook($id);
    }
}
?>
