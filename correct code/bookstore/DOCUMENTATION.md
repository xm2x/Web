# 📚 Bookstore Web Application Documentation

## Table of Contents
1. [Project Overview](#project-overview)
2. [Project Structure](#project-structure)
3. [Database Schema](#database-schema)
4. [Features](#features)
5. [File Documentation](#file-documentation)
6. [Setup Instructions](#setup-instructions)
7. [API Endpoints](#api-endpoints)
8. [Security Considerations](#security-considerations)

---

## Project Overview

**Your Book Space** is a full-stack PHP-based online bookstore application that allows users to:
- Browse and purchase books
- Register and login to accounts
- Add items to a shopping cart
- Preview books with a page-by-page viewer
- Manage books (Admin functionality)

### Technologies Used
| Technology | Purpose |
|------------|---------|
| **PHP** | Server-side scripting |
| **MySQL** | Database management |
| **HTML5/CSS3** | Frontend structure & styling |
| **JavaScript** | Client-side interactivity |
| **Font Awesome** | Icons |
| **jQuery** | DOM manipulation (About page) |

---

## Project Structure

```
bookstore/
├── cart.php                    # Shopping cart functionality
├── login.sql                   # Database schema
├── DOCUMENTATION.md            # This file
│
├── about/                      # About Us page
│   ├── about_us.html
│   ├── about.css
│   └── about.js
│
├── admin/                      # Admin panel
│   ├── manage_books.php        # CRUD operations for books
│   └── edit_book.php           # Edit individual book
│
├── book_preview/               # Book reader/viewer
│   ├── book_preview.php
│   ├── book_preview.css
│   └── book_preview.js
│
├── contact/                    # Contact page
│   ├── contact.html
│   ├── cont.css
│   └── cont.js
│
├── info/                       # User profile page
│   ├── info.html
│   ├── info.css
│   └── info.js
│
├── log-in form/                # Authentication system
│   ├── login.php               # Login/Signup UI
│   ├── auth.php                # Authentication logic
│   ├── login.css
│   └── login.js
│
├── main page/                  # Main storefront
│   ├── main_page.php
│   ├── main page.css
│   └── main page.js
│
└── plans/                      # Subscription plans
    ├── plan.html
    ├── plan.css
    └── plan.js
```

---

## Database Schema

### Database: `bookstore_db`

#### 1. Users Table
```sql
CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL
);
```

| Column | Type | Description |
|--------|------|-------------|
| `id` | INT | Primary key, auto-increment |
| `full_name` | VARCHAR(100) | User's full name |
| `email` | VARCHAR(100) | Unique email address |
| `password` | VARCHAR(255) | User password (plain text - see security notes) |

#### 2. Products Table
```sql
CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    image VARCHAR(255) NOT NULL,
    price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
    category VARCHAR(100) DEFAULT 'General'
);
```

| Column | Type | Description |
|--------|------|-------------|
| `id` | INT | Primary key, auto-increment |
| `title` | VARCHAR(255) | Book title |
| `image` | VARCHAR(255) | Image filename |
| `price` | DECIMAL(10,2) | Book price in USD |
| `category` | VARCHAR(100) | Book category |

#### 3. Orders Table
```sql
CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT DEFAULT 1,
    order_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);
```

| Column | Type | Description |
|--------|------|-------------|
| `id` | INT | Primary key, auto-increment |
| `user_id` | INT | Foreign key to users table |
| `product_id` | INT | Foreign key to products table |
| `quantity` | INT | Number of items ordered |
| `order_date` | TIMESTAMP | Order timestamp |

---

## Features

### 🔐 Authentication System
- **Location**: `log-in form/`
- **Features**:
  - User registration with email validation
  - User login with session management
  - Toggle between Login and Signup forms
  - Password visibility toggle
  - Error/Success message display

### 🏠 Main Page (Storefront)
- **Location**: `main page/main_page.php`
- **Features**:
  - Display all products from database
  - Add to Cart functionality
  - User dropdown menu (logged in/out states)
  - Auto-login via cookies
  - Category sidebar
  - Click on book to preview

### 🛒 Shopping Cart
- **Location**: `cart.php`
- **Features**:
  - Session-based cart storage
  - Add items to cart
  - Remove items from cart
  - Calculate subtotals and totals
  - Checkout (saves orders to database)
  - Login requirement for checkout

### 📖 Book Preview/Reader
- **Location**: `book_preview/`
- **Features**:
  - Chapter-based navigation
  - Page-by-page viewing
  - Previous/Next page navigation
  - Jump to specific page
  - Fullscreen mode
  - Night mode toggle
  - Sidebar toggle
  - Keyboard navigation (Arrow keys)
  - Dynamic cover/title from URL parameters

### 👨‍💼 Admin Panel
- **Location**: `admin/`
- **Features**:
  - **Create**: Add new books with drag-and-drop image upload
  - **Read**: View all existing books in table
  - **Update**: Edit book details
  - **Delete**: Remove books with confirmation
  - File upload to `main page/` directory

### 📝 Static Pages
- **About Us** (`about/about_us.html`): Company story, mission, community focus
- **Contact** (`contact/contact.html`): Contact form with company info
- **User Profile** (`info/info.html`): Display user information
- **Plans** (`plans/plan.html`): Subscription tiers (Basic, Premium, Premium-Plus)

---

## File Documentation

### Core Files

#### `cart.php`
**Purpose**: Shopping cart management

**Session Variables**:
- `$_SESSION['cart']` - Array of product IDs and quantities
- `$_SESSION['user_id']` - Logged-in user ID

**Operations**:
| Action | Method | Parameter |
|--------|--------|-----------|
| Add to Cart | POST | `add_to_cart`, `product_id` |
| Remove Item | GET | `remove` (product_id) |
| Checkout | POST | `checkout` |

---

#### `log-in form/auth.php`
**Purpose**: Handle user authentication

**POST Parameters**:
| Parameter | Values | Description |
|-----------|--------|-------------|
| `action` | `login`, `register` | Authentication action |
| `email` | string | User email |
| `password` | string | User password |
| `full_name` | string | (Register only) User's name |

**Redirects**:
- Success Login → `../main page/main_page.php`
- Error → `login.php?error=MESSAGE`
- Success Register → `login.php?success=MESSAGE`

---

#### `log-in form/login.php`
**Purpose**: Login/Registration UI

**JavaScript Functions**:
- `showSignup()` - Display registration form
- `showLogin()` - Display login form
- `togglePassword(id)` - Toggle password visibility

---

#### `main page/main_page.php`
**Purpose**: Main storefront displaying products

**Features**:
- Auto-login from cookies
- Dynamic product listing from database
- Add to Cart forms for each product
- User dropdown menu with conditional content

---

#### `book_preview/book_preview.php`
**Purpose**: Book reader interface

**URL Parameters**:
| Parameter | Description |
|-----------|-------------|
| `title` | Book title to display |
| `img` | Book cover image path |

---

#### `book_preview/book_preview.js`
**Purpose**: Book reader functionality

**Key Functions**:
| Function | Description |
|----------|-------------|
| `loadPage(index)` | Load and display specific page |
| `toggleDropdown()` | Show/hide user menu |
| `makeDataSvg()` | Generate placeholder SVG pages |

**Controls**:
- Arrow keys for navigation
- Click image to go to next page
- Chapter links to switch chapters

---

#### `admin/manage_books.php`
**Purpose**: Admin CRUD operations

**Operations**:
| Operation | Method | Description |
|-----------|--------|-------------|
| Add Book | POST (`add_book`) | Create new product with image upload |
| Delete Book | GET (`delete_id`) | Remove product from database |

**File Upload**:
- Accepts image files
- Saves to `../main page/` directory
- Stores filename in database

---

#### `admin/edit_book.php`
**Purpose**: Edit existing book

**URL Parameters**:
| Parameter | Description |
|-----------|-------------|
| `id` | Product ID to edit |

**POST Parameters**: `title`, `image`, `price`, `category`

---

### CSS Files

| File | Description |
|------|-------------|
| `main page.css` | Main page styling, cards, navigation |
| `login.css` | Login form styling, input boxes |
| `book_preview.css` | Reader layout, controls, sidebar |
| `about.css` | About page sections, alternating layouts |
| `cont.css` | Contact form styling |
| `info.css` | User profile styling |
| `plan.css` | Subscription cards styling |

### JavaScript Files

| File | Description |
|------|-------------|
| `main page.js` | User dropdown functionality |
| `login.js` | Form toggle, password visibility |
| `book_preview.js` | Page navigation, chapter switching |
| `about.js` | About page interactions |
| `cont.js` | Contact page interactions |
| `info.js` | Profile page interactions |
| `plan.js` | Plans page interactions |

---

## Setup Instructions

### Prerequisites
- XAMPP, WAMP, or similar PHP/MySQL environment
- PHP 7.0+
- MySQL 5.7+

### Installation Steps

1. **Start your local server** (Apache + MySQL)

2. **Create the database**:
   ```sql
   -- Run the contents of login.sql in phpMyAdmin
   -- or MySQL command line
   ```

3. **Configure database connection** (already set in files):
   ```php
   $servername = "localhost";
   $username = "root";
   $password = "";
   $dbname = "bookstore_db";
   ```

4. **Place files in web directory**:
   - For XAMPP: `C:\xampp\htdocs\bookstore\`
   - For WAMP: `C:\wamp\www\bookstore\`

5. **Add book images** to `main page/` folder

6. **Access the application**:
   - Main Page: `http://localhost/bookstore/main page/main_page.php`
   - Admin: `http://localhost/bookstore/admin/manage_books.php`
   - Login: `http://localhost/bookstore/log-in form/login.php`

### Test Credentials
```
Email: test@test.com
Password: 123
```

---

## API Endpoints

This application uses traditional PHP form submissions rather than REST APIs:

| Page | Method | Action |
|------|--------|--------|
| `auth.php` | POST | Login/Register |
| `cart.php` | POST | Add to cart |
| `cart.php` | GET | Remove from cart |
| `cart.php` | POST | Checkout |
| `manage_books.php` | POST | Add book |
| `manage_books.php` | GET | Delete book |
| `edit_book.php` | POST | Update book |

---

## Security Considerations

### ⚠️ Current Vulnerabilities (For Educational Purposes)

1. **SQL Injection**: Direct string interpolation in SQL queries
   ```php
   // Vulnerable
   $sql = "SELECT * FROM users WHERE email='$email'";
   
   // Recommended: Use prepared statements
   $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
   $stmt->bind_param("s", $email);
   ```

2. **Plain Text Passwords**: Passwords stored without encryption
   ```php
   // Recommended: Use password_hash()
   $hashed = password_hash($password, PASSWORD_DEFAULT);
   
   // And password_verify() for login
   if (password_verify($input_password, $stored_hash)) { ... }
   ```

3. **XSS Vulnerability**: Some user inputs not sanitized
   ```php
   // Use htmlspecialchars() for all outputs
   echo htmlspecialchars($user_input, ENT_QUOTES, 'UTF-8');
   ```

4. **No CSRF Protection**: Forms lack CSRF tokens

5. **File Upload Security**: Should validate file types server-side

### Recommended Improvements
- [ ] Implement prepared statements for all SQL queries
- [ ] Hash passwords with `password_hash()`
- [ ] Add CSRF tokens to all forms
- [ ] Validate and sanitize all user inputs
- [ ] Implement proper session security
- [ ] Add file type validation for uploads
- [ ] Use HTTPS in production

---

## Navigation Flow

```
┌─────────────────────────────────────────────────────────────┐
│                        Main Page                            │
│                    (main_page.php)                          │
│                                                             │
│  ┌─────────┐  ┌─────────┐  ┌─────────┐  ┌─────────┐        │
│  │ Login   │  │ Profile │  │  Cart   │  │  Admin  │        │
│  └────┬────┘  └────┬────┘  └────┬────┘  └────┬────┘        │
│       │            │            │            │              │
│       ▼            ▼            ▼            ▼              │
│  ┌─────────┐  ┌─────────┐  ┌─────────┐  ┌─────────┐        │
│  │login.php│  │info.html│  │cart.php │  │manage_  │        │
│  │         │  │         │  │         │  │books.php│        │
│  └─────────┘  └─────────┘  └─────────┘  └─────────┘        │
│                                                             │
│  ┌──────────────────────────────────────────────────┐      │
│  │              Book Cards (Click to Preview)        │      │
│  │                        │                          │      │
│  │                        ▼                          │      │
│  │              book_preview.php                     │      │
│  └──────────────────────────────────────────────────┘      │
│                                                             │
│  ┌─────────┐  ┌─────────┐  ┌─────────┐                     │
│  │ About   │  │ Contact │  │  Plans  │                     │
│  └─────────┘  └─────────┘  └─────────┘                     │
└─────────────────────────────────────────────────────────────┘
```

---

## Changelog

| Version | Date | Changes |
|---------|------|---------|
| 1.0.0 | 2024 | Initial release |

---

## Support

For issues or questions, contact:
- **Address**: 123 Book St, Readville, BK 45678
- **Phone**: (123) 456-7890
- **Email**: support@yourbookspace.com

---

*Documentation generated for Your Book Space - Bookstore Application*
