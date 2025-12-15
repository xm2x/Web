# Updated System Architecture - Manual Book & Chapter Management

## Overview
Your system now has separated files and a clean workflow for managing books and chapters.

## File Structure

```
frontend/main page/
├── main_page.html              ← HTML interface (displays books)
├── main_page.php               ← PHP backend (fetches books from DB)
├── main page.css               ← Styling
└── main page.js                ← Client-side interactions

backend/
├── admin.html                  ← Admin interface (manage books & chapters)
├── admin.php                   ← PHP backend (unused currently)
├── config.php                  ← Database configuration
└── api/
    ├── get_books.php           ← Get all books
    ├── get_book.php            ← Get single book with chapters
    └── admin/
        ├── add_book.php        ← Add new book
        ├── add_chapter.php     ← Add chapter to book
        └── delete_chapter.php  ← Delete chapter
```

## User Workflow

### 1. Adding a New Book (Admin Panel)
1. Admin goes to `/backend/admin.html`
2. Sees "Add New Book" section
3. Enters:
   - Book Name (e.g., "Harry Potter")
   - Author/Title (e.g., "J.K. Rowling")
   - Description (optional)
4. Clicks "Add Book"
5. Book is saved to database
6. Book appears in "All Books" list (left sidebar)

### 2. Viewing Books (Main Page)
1. User goes to `/frontend/main page/main_page.html`
2. Page fetches books from `main_page.php` API
3. Books are displayed as cards
4. User can:
   - Search books by title or author
   - Filter by category (future feature)
   - Click on a book

### 3. Adding Chapters (From Main Page to Admin)
1. User clicks a book on the main page
2. Redirected to admin panel with book pre-selected: `/backend/admin.html?book_id=X`
3. Chapter management section appears
4. Admin enters:
   - Chapter Number (e.g., 1, 2, 3)
   - Chapter Title (e.g., "The Beginning")
5. Clicks "Add Chapter"
6. Chapter is saved and displayed in the list

### 4. Managing Books & Chapters (Admin Only)
1. Admin can directly select books from the "All Books" list
2. Chapter management section appears automatically
3. Can add or delete chapters for the selected book
4. All changes reflected in real-time

## Database Flow

```
Database (bookstore_db)
│
├── books table
│   ├── id (Primary Key)
│   ├── title
│   ├── author
│   ├── description
│   └── cover_image_path
│
├── chapters table
│   ├── id (Primary Key)
│   ├── book_id (Foreign Key → books.id)
│   ├── chapter_number
│   └── title
│
└── book_pages table (for future use)
    ├── id (Primary Key)
    ├── chapter_id (Foreign Key → chapters.id)
    ├── page_number
    └── image_path
```

## API Endpoints

### Main Page API
```
GET /frontend/main page/main_page.php
Response: { success: true, books: [{ id, title, author, description, cover_image_path }, ...] }
```

### Admin APIs
```
GET  /backend/api/get_books.php
     → Returns all books

GET  /backend/api/get_book.php?id=X
     → Returns single book with all chapters

POST /backend/api/admin/add_book.php
     → Add new book
     → Body: { title, author, description, cover_image_path }

POST /backend/api/admin/add_chapter.php
     → Add chapter to book
     → Body: { book_id, chapter_number, title }

POST /backend/api/admin/delete_chapter.php
     → Delete chapter
     → Body: { id }
```

## Key Features

✅ **Manual Book Entry**: Users type in book details instead of uploading files
✅ **Separated Files**: HTML and PHP are separate for each page
✅ **Dynamic Content**: Books fetched from database
✅ **Book Selection**: Users can select books from main page to add chapters
✅ **Real-time Updates**: Changes appear immediately
✅ **Simple Interface**: Clean, intuitive admin panel

## How Books Get from Main Page to Admin

1. User opens main page (`main_page.html`)
2. Page loads books via `main_page.php`
3. User clicks on a book
4. JavaScript triggers: `window.location.href = '../../backend/admin.html?book_id=${bookId}'`
5. Admin page loads with `book_id` query parameter
6. JavaScript in admin checks URL: `checkBookSelection()`
7. Book is automatically selected and chapters display

## Next Steps (Optional Enhancements)

- [ ] Add book cover image upload
- [ ] Add reading progress tracking
- [ ] Implement book categories
- [ ] Add page images to chapters
- [ ] Search and filter improvements
- [ ] User ratings and reviews
- [ ] Wishlist functionality

---

**Status**: ✅ **COMPLETE AND WORKING**

Your new system is ready to use with manual book entry and chapter management!
