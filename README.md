# PHP Blog Web Application

A lightweight, object-oriented blog web application built using raw PHP 8.2.  
It follows the MVC architectural pattern and implements best practices like dependency injection, routing, centralized error handling, Middleware, and database access via Doctrine ORM.

---

## 🚀 Features

- 🧱 MVC Architecture (Model-View-Controller)
- ⚙️ Custom Dependency Injection Container
- 🗃️ Doctrine ORM for database operations
- 🌐 Phroute for routing (supports middleware)
- 🔐 CSRF protection middleware
- 📂 Centralized error handling and logging
- 📦 Environment variable support using `phpdotenv`
- 🧪 Ready for PHPUnit testing

---

## 🗂️ Project Structure
├── app/
│ ├── Core/ # Core system (DI, Routing, DB, ErrorHandler)
│ ├── Controllers/ # Controllers (AuthController, BlogController, etc.)
│ ├── Models/ # Application logic and database models
│ ├── Views/ # HTML/PHP templates
│ ├── Middleware/ # Custom middleware (e.g., AuthMiddleware, CSRFMiddleware)
│
├── bin/ # CLI scripts for Doctrine (migrations, setup)
├── config/ # Doctrine & environment config files
├── public/ # Public entry point (index.php)
├── vendor/ # Composer dependencies
├── migrations/ # Doctrine migration files
├── .env # Environment variables
├── composer.json
├── README.md

✨ Available Routes

| Method | Route               | Description        |
| ------ | ------------------- | ------------------ |
| GET    | `/`                 | Home (show blogs)  |
| GET    | `/register`         | Registration form  |
| POST   | `/register`         | Register a user    |
| GET    | `/signin`           | Login form         |
| POST   | `/signin`           | Sign in user       |
| GET    | `/logout`           | Logout user        |
| GET    | `/blog/create`      | Blog post form     |
| POST   | `/blog/create`      | Create a blog post |
| GET    | `/blog/edit/{id}`   | Edit blog form     |
| POST   | `/blog/edit/{id}`   | Update blog post   |
| GET    | `/blog/delete/{id}` | Delete blog post   |
