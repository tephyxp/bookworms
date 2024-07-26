![ ](<resources/img/smaller recs.png>)       ![alt text](<resources/img/Recs. (3).jpg>)

# Recs. Book Recommendations App
 
 Book recommendations site that enables all users to view and search book recommendations by title and author. The site also features a login-accessible CRUD where users with admin permissions can add new book recommendations as well as editing and deleting existing entries. 

IMAGE OF MAIN PAGE

## Table of Contents

- [Overview](#overview)
  - [Requirements](#requirements)
  - [Demo Videos and Images](#demo-videos-and-images)
  - [Link](#link)
  - [Testing](#testing)
  - [Installation](#installation)

- [The Process](#the-process)
  - [Technologies](#technologies)
  - [Features](#features)
  - [Project Updates](#project-updates)
  - [Authors](#authors)

## Overview

### Requirements

You will need to develop a PHP web application connected to a MySQL database. Your project should have a well-organised file structure, be designed with a monolithic MVC architecture, and developed with object-oriented programming (OOP). 

#### Functional Requirements:
- The application MUST display all the books in the database to be viewed by all users
- The application MUST allow all users search for a book by title or author
- The application MUST show detailed information about each book on a different page
- The application MUST have pagination on the main page
- The application MUST have a login/logout feature for the admin user
- The admin user of the application MUST be able to add a book
- The admin user of the application MUST be able to edit the information of each book
- The admin user of the application MUST be able to delete each book

#### Non-Functional Requirements (Quality Attributes)
- There must be good naming conventions for classes, IDs, functions, etc
- Each book entry must have a title, an image, at least one author, and a description/review at a minimum
- Files should be properly organized and separated based on an MVC architecture
- Any CSS library can be used
- There should be a good user experience (UX) 
- Repository commits should be related to the task checklist

### Demo Videos and Images

Desktop demo video:

VIDEO

Mobile demo video:

VIDEO

Screenshot of ...

Screenshot of ...

### Link 

- Live site URL: 


### Testing

This project includes unit testing in PHPUnit to ensure the reliability and functionality of the BooksController class, which interacts with the booksModel class. The tests focus on checking that various functions exist and work correctly. All tests passed. Here is an overview of the tests and their purposes:

#### Method Existence Tests:
- *testThatThereIsAGetBooksFunction()* ---> Verifies that the getBooks method exists in the BooksController class

- *testThatThereIsASearchBooksFunction()* ---> Ensures the searchBooks method is present

- *testThatThereIsADeleteBookFunction()* ---> Checks for the existence of the deleteBook method

- *testThatThereIsAnAddBookFunction()* ---> Confirms the presence of the addBook method

- *testThatThereIsAnEditBookFunction()* ---> Validates the existence of the editBook method

#### Functionality Tests:

- *testSearchBooksFunctionality()*
  - Mocks the searchBooks method of booksModel to check that it returns the correct results for a given keyword
  - Asserts that the results are not empty and matches with the expected output

- *testAddBookFunctionality()*
  - Mocks the addBook method of booksModel to check that it is called with the correct parameters
  - Confirms that the method adds the book as expected

- *testEditBookFunctionality()*
  - Mocks the editBook method of booksModel to check that it is called with the correct parameters
  - Confirms that the method edits the book as expected

- *testDeleteBookFunctionality()*
  - Mocks the deleteBook method of booksModel to check that it is called with the correct parameters
  - Confirms that the method deletes the book as expected


```
PS C:\xampp\htdocs\phpstuff\recs> vendor/bin/phpunit tests/BooksControllerTest.php
PHPUnit 10.5.28 by Sebastian Bergmann and contributors.

Runtime:       PHP 8.2.12

.........                                                           9 / 9 (100%)

Time: 00:00.046, Memory: 8.00 MB

OK (9 tests, 11 assertions)
PS C:\xampp\htdocs\phpstuff\recs> 
```


### Installation 

To install this project: 

- Clone or fork the repository https://github.com/lolamindi/recs 
- Make sure to place the project in the htdocs folder of XAMPP (or MAMP) installation
- Create a MySQL database named: bookworms_library 
- Create a .env file at the root of your project and modify the password field according to whether you use XAMPP or MAMP:

```
DB_HOST="localhost"
DB_USER="user"
DB_PASSWORD="" (XAMPP)/"password" (MAMP)
DB_NAME="bookworms_library"
  ```



## The Process 

### Technologies

The following technologies and versions were used in this project:

- **HTML5**: Structuring the content of the web application
- **Tailwind CSS (v3.4.4)**: Utility-first CSS framework for styling
- **PostCSS (v8.4.38)**: CSS processor used with Tailwind CSS
- **Autoprefixer (v10.4.19)**: Adds vendor prefixes for browser compatibility
- **CSS3**: Custom styling 
- **PHP (v7.4)**: Server-side scripting language for backend logic
- **PHPUnit (v10.5)**: Framework for writing and running PHP tests
- **Composer (v2.6.6)**: Dependency manager for PHP packages
- **MySQL(v8.2.12)**: Relational database system for storing application data 
- **Apache (v2.4.53)**: Web server used to serve the PHP application
- **XAMPP Control Panel(v3.3.0)**: Manages Apache, MySQL, and PHP locally

### Features 

- MVC architecture 
- Password-protected admin page with login
- CRUD capabilities 
- Pagination
- Responsive design for non-admin pages 
- Search feature by book title or author
- Confirmation and notification modals
- Personalised, original book reviews 

### Project Updates 

When originally submitted in February 2024, this project was tailored to our class requirements for a desktop-only library book app in Spanish that prioritised backend functioning.  

Following project updates, completed in July 2024, the app:

- Features a new name, logo, and layout, as well as an eye-catching fluorescent yellow and lilac colour scheme
- Uses Tailwind instead of Bootstrap for styling
- Is now responsive on the main page and details page
- Comes with an extensive README
- Includes a more extensive range of unit tests 
- Has been translated to English
- Showcases a curated collection of books with original book reviews written by Laura Artaza 
 

### Authors

  - [Laura Artaza](https://github.com/lolamindi)
  - [Melissa Casola](https://github.com/melitacasola)
  - [Vicky Robertson](https://github.com/vicki-robertson) 
  - [Laura Gil Solano](https://github.com/ImLauraGS)
  - [Zohra Bellamine](https://github.com/zohra-b)
  - [Stephanie Céspedes](https://github.com/tephyxp)
