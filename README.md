# Book Library API

A simple RESTful API for managing a list of books, built with Laravel. This project is part of a full-stack assessment and is designed to work seamlessly with a React frontend. It provides endpoints for creating, reading, updating, and deleting books, with robust validation and comprehensive automated tests.

## Features
- CRUD operations for books (title, author, publication year)
- JSON API responses
- Validation using FormRequest
- Feature tests for all endpoints
- Database seeding for test data
- Clean, modern Laravel codebase

## Installation & Setup

### Prerequisites
- PHP 8.1 or higher
- Composer
- MySQL
- [Herd](https://herd.laravel.com/) or Laravel Valet/other local dev server

### Steps
1. **Clone the repository**
   ```bash
   git clone <repository-url>
   cd book-library-api
   ```
2. **Install dependencies**
   ```bash
   composer install
   ```
3. **Copy the environment file**
   ```bash
   cp .env.example .env
   ```
4. **Generate the application key**
   ```bash
   php artisan key:generate
   ```
5. **Configure your database**
   - MySQL update the DB settings in `.env` as needed.
   ```
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=your_database_name
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```
6. **Run migrations and seeders**
   ```bash
   php artisan migrate --seed
   ```
7. **Start the development server**
   ```bash
   php artisan serve
   ```
   Or use Herd/Valet for automatic domain routing (e.g., http://book-library-api.test)

## API Endpoints

| Method | Endpoint           | Description         |
|--------|--------------------|---------------------|
| GET    | /api/books         | List all books      |
| GET    | /api/books/{id}    | Get one book        |
| POST   | /api/books         | Create a book       |
| PUT    | /api/books/{id}    | Update a book       |
| DELETE | /api/books/{id}    | Delete a book       |

### Example Request (POST/PUT)
```json
{
  "title": "Book Title",
  "author": "Author Name",
  "publication_year": 2024
}
```

### Example Response
```json
{
  "id": 1,
  "title": "Book Title",
  "author": "Author Name",
  "publication_year": 2024,
  "created_at": "2024-03-16T12:00:00.000000Z",
  "updated_at": "2024-03-16T12:00:00.000000Z"
}
```

### Validation Rules
- `title`: required, string
- `author`: required, string
- `publication_year`: required, integer between 1500 and current year

## Running Tests
To run all feature and unit tests:
```bash
php artisan test
```

## License
This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
