# Quick Start Guide - Updated System

## What Changed ✨

### Before
- Drag & drop file uploads
- Combined PHP and HTML in one file

### Now ✅
- **Manual book entry**: Type in book name and author
- **Separated files**: HTML and PHP are separate
- **Dynamic content**: Books pulled from database
- **Smooth workflow**: Add books → appears on main page → select to add chapters

---

## How to Use

### Step 1: Add a Book (Admin)
1. Go to: `http://localhost/xampp/htdocs/Web/web msa khalid/backend/admin.html`
2. Fill in:
   - **Book Name**: e.g., "The Great Gatsby"
   - **Author/Title**: e.g., "F. Scott Fitzgerald"
   - **Description**: (optional) Brief description
3. Click **"Add Book"**
4. ✅ Book appears in the "All Books" list

### Step 2: View Books (Main Page)
1. Go to: `http://localhost/xampp/htdocs/Web/web msa khalid/frontend/main page/main_page.html`
2. See all books displayed as cards
3. Search or filter books (future feature)

### Step 3: Add Chapters (Two Ways)

**Way 1: From Main Page**
1. Click on any book card on the main page
2. Automatically redirected to admin panel
3. Book is pre-selected ✓
4. Chapter management section appears

**Way 2: From Admin Panel**
1. Click on a book in the "All Books" list
2. Chapter section appears
3. Add chapters

### Step 4: Manage Chapters
1. Enter **Chapter Number**: 1, 2, 3, etc.
2. Enter **Chapter Title**: "The Beginning", etc.
3. Click **"Add Chapter"**
4. See chapters in the list
5. Delete chapters with the delete button

---

## File Locations

```
Main Page (Public):
📁 frontend/main page/
   ├── 📄 main_page.html          ← Open this in browser
   ├── 📄 main_page.php           ← Fetches books from database
   └── 📄 main page.css & js      ← Styling and interactions

Admin Panel (Admin Only):
📁 backend/
   ├── 📄 admin.html              ← Open this to manage books & chapters
   ├── 📄 config.php              ← Database settings
   └── 📁 api/
       ├── 📄 get_books.php       ← Get all books
       ├── 📄 get_book.php        ← Get single book with chapters
       └── 📁 admin/
           ├── 📄 add_book.php    ← Add book to database
           ├── 📄 add_chapter.php ← Add chapter to book
           └── 📄 delete_chapter.php ← Delete chapter
```

---

## Complete User Journey

```
MAIN PAGE (main_page.html)
        ↓
    [User Views Books]
        ↓
    [User Clicks Book]
        ↓
    [Redirect to Admin with book_id]
        ↓
ADMIN PAGE (admin.html?book_id=X)
        ↓
    [Book Auto-Selected]
        ↓
    [Add Chapters Section Shows]
        ↓
    [User Adds Chapters]
        ↓
    [Chapters Saved to Database]
        ↓
    [Back to Main Page]
        ↓
    [User Sees Updated Book with Chapters]
```

---

## Database Tables

### books
```
id | title          | author           | description         | cover_image_path
1  | The Great... | F. Scott F.    | A classic novel... | (empty)
2  | Harry Potter | J.K. Rowling   | Wizarding world... | (empty)
```

### chapters
```
id | book_id | chapter_number | title
1  | 1       | 1              | Chapter 1 - Gatsby Appears
2  | 1       | 2              | Chapter 2 - The Party
3  | 2       | 1              | Chapter 1 - The Boy Who Lived
```

---

## Troubleshooting

| Issue | Solution |
|-------|----------|
| Books not showing on main page | Check `main_page.php` - ensure database connection is correct |
| Can't add books | Verify database is running and `config.php` is configured |
| Chapters not appearing | Check book was selected before adding chapter |
| Book not pre-selected from main page | Clear URL after selection - it's supposed to disappear |

---

## Important Notes

- 📌 **Database Required**: Make sure your `bookstore_db` database is created
- 📌 **SQL Schema**: Run `backend/book_preview.sql` if tables don't exist
- 📌 **PHP Pages**: These are API endpoints, not meant to be viewed directly
- 📌 **HTML Pages**: These are the user-facing interfaces

---

## What's Working Now ✅

- ✅ Add books manually (name + author)
- ✅ Books appear on main page automatically
- ✅ Select books from main page to add chapters
- ✅ Add/delete chapters in admin panel
- ✅ Real-time updates
- ✅ Separated HTML and PHP files
- ✅ Database-driven content

---

## Need Help?

Check these files for detailed documentation:
- `SYSTEM_ARCHITECTURE.md` - System design and workflows
- `admin.html` - Admin interface code comments
- `main_page.html` - Main page code comments
- `main_page.php` - PHP backend code comments

---

**Your new system is ready! Start by adding books in the admin panel and viewing them on the main page.** 🚀
