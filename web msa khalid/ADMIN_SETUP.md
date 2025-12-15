# Complete Admin Panel Setup Guide

## ✨ What You Now Have

### 1. **Drag & Drop Books** (Database Storage Only)
- Drag book files (PDF, EPUB, TXT) directly onto the upload area
- Enter book title and author
- File content saved in database (not on disk)
- All data persists forever

### 2. **Drag & Drop Chapters** (Database Storage Only)
- Select a book first
- Drag chapter files (PDF, EPUB) onto the chapter upload area
- Auto-detects chapter number from filename
- Fill in chapter title
- File saved in database

### 3. **Full Book Management**
- ✅ View all books from database
- ✅ Click any book to select it
- ✅ Edit book title, author, description
- ✅ Delete entire book (removes all chapters too)
- ✅ Delete individual chapters

---

## 🗄️ Database Changes Required

**You MUST run this SQL to update your database:**

```sql
-- Alter books table to store file content
ALTER TABLE books ADD COLUMN file_content LONGBLOB DEFAULT NULL;
ALTER TABLE books ADD COLUMN file_name VARCHAR(255) DEFAULT NULL;
ALTER TABLE books ADD COLUMN file_extension VARCHAR(10) DEFAULT NULL;
ALTER TABLE books ADD COLUMN file_size INT DEFAULT NULL;

-- Alter chapters table to store file content
ALTER TABLE chapters ADD COLUMN file_content LONGBLOB DEFAULT NULL;
ALTER TABLE chapters ADD COLUMN file_name VARCHAR(255) DEFAULT NULL;
ALTER TABLE chapters ADD COLUMN file_extension VARCHAR(10) DEFAULT NULL;
ALTER TABLE chapters ADD COLUMN file_size INT DEFAULT NULL;
```

**How to run it:**
1. Open phpMyAdmin
2. Select your `bookstore_db` database
3. Go to "SQL" tab
4. Paste the SQL above
5. Click "Go"

---

## 📁 What Gets Saved Where (Database Only)

```
books TABLE:
├── id (auto-increment)
├── title
├── author
├── description
├── cover_image_path (optional)
├── file_content ← ✨ NEW - Binary file data
├── file_name ← ✨ NEW - Original filename
├── file_extension ← ✨ NEW - File type (pdf, epub, txt)
├── file_size ← ✨ NEW - File size in bytes
└── created_at (timestamp)

chapters TABLE:
├── id (auto-increment)
├── book_id (foreign key)
├── chapter_number
├── title
├── file_content ← ✨ NEW - Binary file data
├── file_name ← ✨ NEW - Original filename
├── file_extension ← ✨ NEW - File type (pdf, epub)
├── file_size ← ✨ NEW - File size in bytes
└── created_at (timestamp)
```

**No more `/uploads/chapters/` folder!** Everything is in the database.

---

## 🚀 How to Use

### Step 1: Go to Admin Panel
```
http://localhost/xampp/htdocs/Web/web%20msa%20khalid/backend/admin.html
```

### Step 2: Add Books
1. **Drag & drop** a book file (PDF, EPUB, or TXT) onto the "📤 Add Books" area
2. Edit the suggested title and enter the author name
3. Progress bar shows upload completion
4. ✓ Book appears in "📚 Your Books" section on the right

### Step 3: Manage Book
1. **Click a book** in the right panel to select it
2. **Left side** shows "✏️ Edit Book & Manage Chapters"
3. Edit title, author, description
4. Click "💾 Save Changes"

### Step 4: Add Chapters
1. **With a book selected**, drag chapter files onto the "📖 Add Chapters" area
2. Filename like "Ch_1_Beginning.pdf" auto-fills chapter number
3. Enter chapter title
4. ✓ Chapter appears in the list below

### Step 5: Delete
- **Delete Book:** Click "🗑️ Delete Book" button (removes all chapters too)
- **Delete Chapter:** Click "Delete" next to chapter name

---

## 🔄 Workflow Example

```
STEP 1: Open admin.html
        ↓
STEP 2: Drag "MyBook.pdf" to upload area
        ↓
STEP 3: Edit title "My Awesome Book", author "John Doe"
        ↓
STEP 4: Click "Add Book" button
        ↓ (File content encoded to base64)
        ↓ (Sent to add_book.php)
        ↓ (Stored in books.file_content as BLOB)
        ↓
STEP 5: Book appears in "Your Books" list
        ↓
STEP 6: Click book to select it
        ↓
STEP 7: Drag "Chapter1.pdf" to chapter upload area
        ↓
STEP 8: Enter chapter 1, title "The Beginning"
        ↓
STEP 9: Click "Add Chapter"
        ↓ (File content encoded to base64)
        ↓ (Sent to add_chapter.php)
        ↓ (Stored in chapters.file_content as BLOB)
        ↓
STEP 10: Chapter appears in "Chapters in this Book"
         ↓
STEP 11: Reload page → Everything still there!
```

---

## 📝 File Formats Supported

| Type | Books | Chapters |
|------|-------|----------|
| PDF | ✓ Yes | ✓ Yes |
| EPUB | ✓ Yes | ✓ Yes |
| TXT | ✓ Yes | ✗ No |

Max file size: **100MB for books, 100MB for chapters**

---

## API Endpoints Used

| Endpoint | Method | Purpose |
|----------|--------|---------|
| `/api/get_books.php` | GET | Get all books from database |
| `/api/get_book.php?id=X` | GET | Get single book with chapters |
| `/api/admin/add_book.php` | POST | Create book with file in database |
| `/api/admin/update_book.php` | POST | Edit book details |
| `/api/admin/delete_book.php` | POST | Delete book and chapters |
| `/api/admin/add_chapter.php` | POST | Create chapter with file in database |
| `/api/admin/delete_chapter.php` | POST | Delete chapter |
| `/api/admin/upload_book.php` | POST | Upload file and convert to base64 |

---

## ⚠️ Important Notes

1. **Run the SQL first!** The new columns must exist in the database
2. **File content is base64 encoded** when sent to the server (handles binary data)
3. **All files stored in database** - no disk storage needed
4. **Automatic deletion** - delete book = delete all chapters
5. **Progress bars** show upload progress in real-time

---

## 🆘 Troubleshooting

**Books not showing up?**
- Check if database update was applied
- Check browser console for errors (F12)
- Check if get_books.php returns data

**Can't upload files?**
- Check file size (max 100MB)
- Check file type (PDF, EPUB, TXT for books / PDF, EPUB for chapters)
- Check if upload_book.php exists

**File upload fails?**
- Check if add_book.php or add_chapter.php has errors
- Check database columns exist
- Check file size limit in php.ini

---

**You're all set! Start uploading books! 📚✨**
