# 📚 Your Book Space - Website Documentation

## Table of Contents
1. [Introduction](#1-introduction)
2. [Website Objective](#2-website-objective)
3. [Used Tools and Platforms](#3-used-tools-and-platforms)
4. [Main Pages of the Website](#4-main-pages-of-the-website)
5. [Team Members](#5-team-members)

---

## 1. Introduction

**Your Book Space** is an online bookstore built to let readers browse, preview, and purchase books through a clean, responsive web experience. The site combines a product catalog, interactive book previews, a shopping cart, and an admin area for managing inventory.

---

## 2. Website Objective

**Primary Goal:** Provide a convenient digital storefront where users can discover books, preview content, and complete purchases securely.

**Key Services**
- Book catalog browsing by category
- Book preview (page-by-page reader)
- User authentication and profiles
- Shopping cart and checkout flow
- Admin book management (CRUD)
- Subscription plans overview

---

## 3. Used Tools and Platforms

### Programming Languages and Implementation Platform
| Language | Implementation Platform/Usage |
|----------|--------------------------------|
| PHP | Server-side logic, sessions, DB queries (runs on Apache via XAMPP/WAMP) |
| SQL | MySQL schema and data manipulation |
| HTML5 | Page structure and forms |
| CSS3 | Layout, styling, responsiveness |
| JavaScript | Client interactivity (DOM events, viewer controls) |

### Supporting Libraries and Tools
| Tool | Purpose |
|------|---------|
| jQuery 3.6.0 | DOM utilities (About page) |
| Font Awesome 5.15.3 | Icons |
| XAMPP/WAMP | Local web+DB stack (Apache, MySQL, PHP) |
| phpMyAdmin | DB administration |
| VS Code | Development/editor |

---

## 4. Main Pages of the Website

> Screenshots: capture each page in the browser and place the image files in a `screenshots/` folder, then link them in the slots below.

### 4.1 Main Page (Storefront)
- **File:** `main page/main_page.php`
- **Description:** Landing page listing all books from the database with cover, title, price, and Add to Cart. Includes search bar, category sidebar, and user menu.
- **Screenshot:** _Add: `screenshots/main_page.png`_

### 4.2 Login / Registration
- **File:** `log-in form/login.php`
- **Description:** Dual-view form for user login and sign-up with email/password, toggle between forms, and password visibility control.
- **Screenshot:** _Add: `screenshots/login.png`_

### 4.3 Shopping Cart
- **File:** `cart.php`
- **Description:** Displays items added to the cart with quantity, price, subtotal/total, remove option, and checkout (requires login).
- **Screenshot:** _Add: `screenshots/cart.png`_

### 4.4 Book Preview (Reader)
- **File:** `book_preview/book_preview.php`
- **Description:** Page-by-page reader with chapter list, next/prev, jump-to-page, fullscreen, night mode, and dynamic cover/title from URL params.
- **Screenshot:** _Add: `screenshots/book_preview.png`_

### 4.5 Admin - Manage Books
- **File:** `admin/manage_books.php`
- **Description:** Admin dashboard to add books (drag/drop image upload), list all books, edit, and delete entries.
- **Screenshot:** _Add: `screenshots/admin_manage_books.png`_

### 4.6 Admin - Edit Book
- **File:** `admin/edit_book.php`
- **Description:** Edit form for an existing book (title, image filename, price, category) with update and cancel options.
- **Screenshot:** _Add: `screenshots/admin_edit_book.png`_

### 4.7 About Us
- **File:** `about/about_us.html`
- **Description:** Story, mission/vision, community focus, and curation philosophy with alternating text-image sections.
- **Screenshot:** _Add: `screenshots/about.png`_

### 4.8 Contact
- **File:** `contact/contact.html`
- **Description:** Contact form (name, email, message) plus address, phone, email, and social links.
- **Screenshot:** _Add: `screenshots/contact.png`_

### 4.9 User Profile
- **File:** `info/info.html`
- **Description:** Shows user avatar, name, email, phone with Save/Edit/Subscribe actions.
- **Screenshot:** _Add: `screenshots/profile.png`_

### 4.10 Subscription Plans
- **File:** `plans/plan.html`
- **Description:** Pricing page with Basic, Premium, and Premium-Plus tiers and feature lists.
- **Screenshot:** _Add: `screenshots/plans.png`_

---

## 5. Team Members

| # | Name | Role | Responsibilities |
|---|------|------|------------------|
| 1 | **Team Leader Name** | Team Leader / Full-Stack Dev | Coordination, architecture, DB design, code review, integrations |
| 2 | Member 2 | Frontend Developer | HTML/CSS, responsive layouts, UI polish |
| 3 | Member 3 | Backend Developer | PHP logic, authentication, cart/checkout, DB queries |
| 4 | Member 4 | Frontend Developer | JavaScript interactions, book preview features |
| 5 | Member 5 | UI/UX Designer | Visual design, page layouts, icons/images, usability |

**Team Leader:** Team Leader Name

---

*Last updated: December 2025*
