# PHP Blog CMS

Simple Content Management System for blogging built with PHP 5.6 and MySQL.

## Features

- User authentication (login/register)
- Create, edit, delete blog posts
- Comments system
- Categories and tags
- Admin panel
- MySQL database

## Requirements

- PHP 5.6+
- MySQL 5.5+
- Apache with mod_rewrite

## Installation

1. Clone this repository
2. Import `database.sql` to MySQL
3. Configure database in `config/database.php`
4. Point your web server to the project folder

## Configuration

Edit `config/database.php`:

```php
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'blog_cms');
```

## Usage

### Admin Access
- URL: `http://localhost/admin`
- Default user: `admin`
- Default password: `admin123`

### Folder Structure

```
php-blog-cms-2015/
├── config/
│   └── database.php
├── includes/
│   ├── header.php
│   └── footer.php
├── admin/
│   ├── index.php
│   ├── posts.php
│   └── users.php
├── assets/
│   ├── css/
│   └── js/
├── index.php
├── post.php
└── database.sql
```

## Technologies

- PHP 5.6
- MySQL
- jQuery 2.1
- Bootstrap 3.3
- HTML5/CSS3

## License

MIT License

## Author

David Badell - 2015
