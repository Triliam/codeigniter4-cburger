🍔 CodeIgniter 4 CBurger: Seu Restaurante Fullstack Completo! 🚀
Bem-vindo ao CodeIgniter 4 CBurger, uma aplicação fullstack robusta e deliciosa, desenvolvida para simplificar a gestão de restaurantes! Este projeto não é apenas um sistema; é uma experiência completa de desenvolvimento, abraçando as melhores práticas e as ferramentas mais eficientes do mercado.

CodeIgniter 4 Fullstack Project
This project is a fullstack application built with CodeIgniter 4, demonstrating key features and architectural patterns for web development.

<br>
<br>
💻 Technologies Utilized:
Backend:

PHP

CodeIgniter 4 Framework

<br>
<br>
Frontend:

HTML

CSS

JavaScript

Bootstrap

<br>
<br>
Development Environment:

Laragon

Database Management:

MySQL Workbench

DBeaver

<br>
<br>

⚙️ Architectural Pattern: MVC (Model-View-Controller)
The project adheres to the MVC architectural pattern for structured and maintainable code:

Routes: Defines application endpoints and their corresponding handlers.

Controllers: Manages application logic, processes user input, and interacts with Models and Views.

Views: Responsible for presenting data to the user.

Models: Handles data logic and direct interaction with the database.

<br>
<br>
🚀 Key Features and Implementations:
Database Management:

Migrations: Database schema version control.

Seeds: Population of database with initial or test data.

<br>
<br>
Request & Response Handling:

Filters: Middleware for processing requests before and after controller execution (e.g., authentication, security).

Request & Response Objects: Standardized handling of HTTP requests and responses.

<br>
<br>
Templating:

Partials: Reusable view components.

Layouts: Master templates for consistent page structure.

<br>
<br>
Communication:

Email Sending: Functionality for sending emails via PHP.

REST APIs: Development of RESTful endpoints for data exchange.

<br>
<br>
Security & Validation:

Form Validation: Server-side validation of user input.

Encryption: Data encryption for enhanced security.

Security Features: Implementation of various security measures.
<br>
<br>
Utilities:

Helpers: Collection of utility functions to assist development.

<br>
<br>

💾 Setup and Installation:
Clone the Repository:
(https://github.com/Triliam/codeigniter4-cburger)

Environment Setup:

Ensure Laragon is installed and running.

Import the database schema (.sql file) using MySQL Workbench or DBeaver.

Configure database connection settings in app/Config/Database.php.

Configure email settings in app/Config/Email.php.

Install Composer Dependencies:
composer install

Run Migrations and Seeds (Optional, for initial database setup):

php spark migrate

php spark spark db:seed UsersSeeds

php spark spark db:seed RestaurantsSeeds

Access the Application:
Open your web browser and navigate to the project URL configured in Laragon.
