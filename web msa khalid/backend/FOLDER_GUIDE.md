# Folder Structure Guide

## 📂 Backend Folder Structure

```
backend/
├── config.php                          ← Database connection settings
├── admin.html                          ← Admin panel HTML (interface for managing books/chapters)
├── admin.php                           ← Legacy file (not currently used)
│
├── api/                                ← API ENDPOINTS (where requests go)
│   ├── get_books.php                  ← Gets all books from database
│   ├── get_book.php                   ← Gets single book with chapters
│   ├── get_chapter_pages.php          ← Gets pages in a chapter
│   │
│   └── admin/                         ← Admin operations
│       ├── add_book.php               ← Creates new book
│       ├── add_chapter.php            ← Creates new chapter
│       ├── delete_chapter.php         ← Deletes chapter
│       └── upload_chapter.php         ← Handles file uploads ⭐ (THIS WAS BROKEN!)
│
└── uploads/                            ← FILE STORAGE (where files are saved)
    └── chapters/                       ← Chapter files stored here
        ├── book_1_1702345600_abc123.pdf
        ├── book_5_1734253800_507ae9f.pdf
        └── book_5_1734254100_608bf1g.jpg
```

---

## What Each Folder Does

### 🔧 `/api` Folder
**Purpose:** API endpoints - these are the "connection points" that handle requests from the admin panel

**How it works:**
```
Admin Panel (admin.html)
    ↓ (Makes requests)
API Endpoints (/api/)
    ↓ (Query database)
MySQL Database
```

**Example:**
- When you click "Add Book" → admin.html sends request to `/api/admin/add_book.php`
- When you drag a chapter file → admin.html sends request to `/api/admin/upload_chapter.php`
- When you load books list → admin.html requests `/api/get_books.php`

**Files in `/api/admin/`:**
| File | What it does |
|------|------------|
| `add_book.php` | Creates new book in database |
| `add_chapter.php` | Creates new chapter in database |
| `delete_chapter.php` | Removes chapter from database |
| `upload_chapter.php` | Handles file uploads to disk + database |

---

### 💾 `/uploads/chapters` Folder
**Purpose:** Stores actual chapter files (PDFs, images) on disk

**How files get there:**
```
1. You drag chapter file onto admin panel
2. File uploaded to upload_chapter.php
3. PHP validates file (type, size)
4. File saved to /uploads/chapters/
5. File path stored in database
```

**Example file path:**
```
/backend/uploads/chapters/book_5_1734253800_507ae9f.pdf
                          ↑    ↑    ↑              ↑
                        book  id  timestamp       ext
```

**What's stored:**
- PDF files (book chapters)
- JPG/PNG images (page images)
- Max file size: 500MB per file

---

## Complete Data Flow

### When You Upload a Chapter File:

```
STEP 1: Browser (admin.html)
├─ You drag file: "Chapter_1.pdf"
├─ JavaScript validates: PDF? ✓ Size? ✓
└─ Sends to: /api/admin/upload_chapter.php

STEP 2: Server (/api/admin/upload_chapter.php)
├─ Receives file
├─ Validates again: Type? ✓ Size? ✓
├─ Generates unique name: "book_5_1734253800_abc123.pdf"
├─ SAVES FILE TO DISK: /backend/uploads/chapters/book_5_1734253800_abc123.pdf
├─ Returns: { success: true, file_path: "uploads/chapters/book_5_1734253800_abc123.pdf" }
└─ Closes database connection

STEP 3: Browser receives response
├─ Shows upload success message ✓
├─ Auto-fills chapter number (if found in filename)
└─ You can edit chapter title

STEP 4: You click "Add Chapter"
├─ Browser sends to: /api/admin/add_chapter.php
└─ Creates database entry with file path

STEP 5: Database (MySQL)
├─ Inserts into chapters table:
│  ├─ book_id: 5
│  ├─ chapter_number: 1
│  ├─ title: "The Beginning"
│  └─ created_at: timestamp
└─ Chapter now permanently saved

RESULT:
✓ File on disk: /backend/uploads/chapters/book_5_1734253800_abc123.pdf
✓ Reference in database: chapters table
✓ Data persists forever (unless deleted)
```

---

## Why We Need Both Storage Systems

### Database (MySQL)
```
Stores:
✓ Book names, authors
✓ Chapter numbers, titles
✓ File paths (reference to disk)
✓ Relationships (which book owns which chapter)

Why:
- Searchable (find books by title)
- Structured (organized relationships)
- Fast queries (billions of entries)
```

### Disk Storage (/uploads/chapters/)
```
Stores:
✓ Actual files (PDF, JPG, PNG)

Why:
- Database not ideal for large files
- Can serve files directly to users
- Separate backup strategy possible
- Can delete files independently
```

### They Work Together
```
Database Entry:
{
  id: 12,
  book_id: 5,
  chapter_number: 1,
  title: "The Beginning",
  file_path: "uploads/chapters/book_5_1734253800_abc123.pdf"  ← Points to disk
}

When you view chapter:
1. Database finds chapter record
2. Gets file_path: "uploads/chapters/book_5_1734253800_abc123.pdf"
3. Serves file to user
```

---

## What Was The Problem?

**File:** `upload_chapter.php`
**Error:** Wrong path to config.php

```php
// ❌ WRONG (what was there):
require_once '../config.php';

// When file is at: /backend/api/admin/upload_chapter.php
// '../config.php' looks for: /backend/api/config.php ← DOESN'T EXIST!

// ✅ CORRECT (fixed now):
require_once '../../config.php';

// Now it looks for: /backend/config.php ← CORRECT!
```

**Result:**
- Upload script couldn't connect to database
- File validation failed silently
- Drag-drop appeared to work but files never saved

---

## Testing Drag & Drop Now

1. **Go to admin panel:** `http://localhost/xampp/htdocs/Web/web msa khalid/backend/admin.html`
2. **Add a book:**
   - Name: "Test Book"
   - Author: "Test Author"
   - Click "Add Book"
3. **Click the book** in left sidebar
4. **Drag a PDF or image** onto the dashed upload area
5. **Watch progress bar** fill up ✓
6. **Add chapter details:**
   - Chapter number: 1
   - Chapter title: "The Beginning"
7. **Check:**
   - Message appears: "Chapter added successfully!" ✓
   - Chapter appears in list ✓
   - File exists in `/backend/uploads/chapters/` ✓
   - Database entry created ✓

---

## Quick Reference

| Location | Purpose | Example |
|----------|---------|---------|
| `/api/` | Request handlers | `add_book.php` processes book creation |
| `/api/admin/` | Admin operations | `upload_chapter.php` handles file upload |
| `/uploads/chapters/` | File storage | `book_5_1734253800_abc123.pdf` |
| `config.php` | DB connection | Connects to MySQL bookstore_db |
| `admin.html` | Admin interface | Where you add/manage books |

---

## File Upload Summary

```
Type of File    Allowed?    Max Size    Where Saved
─────────────────────────────────────────────────────
PDF             ✓ Yes       500MB       /uploads/chapters/
JPG/JPEG        ✓ Yes       500MB       /uploads/chapters/
PNG             ✓ Yes       500MB       /uploads/chapters/
Word/Excel      ✗ No        -           Not saved
Text            ✗ No        -           Not saved
```

---

**Now try uploading a chapter file - it should work! 🚀**
