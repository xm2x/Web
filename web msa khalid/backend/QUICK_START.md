# Quick Start Guide - Admin Panel

## What's New ✨

Your admin panel has been completely redesigned with a focus on simplicity and user experience.

### Key Features:
1. **Drag & Drop Upload** - Simply drag book files from your computer
2. **Single Interface** - No more switching between tabs
3. **Real-time Management** - Instantly add/delete chapters
4. **Progress Tracking** - Visual upload progress for each file

## Getting Started

### Step 1: Access the Admin Panel
```
Navigate to: http://localhost/xampp/htdocs/Web/web msa khalid/backend/admin.html
```

### Step 2: Upload Your First Book
```
1. Look for the "Upload Book File" section
2. Drag a PDF, JPG, PNG, or EPUB file onto the upload area
   (or click to browse from your computer)
3. Watch the progress bar as your file uploads
4. Your book will automatically appear in the "All Books" list
```

### Step 3: Add Chapters
```
1. Click on a book in the "All Books" list
2. The chapter management section will appear
3. Enter Chapter Number (e.g., 1, 2, 3)
4. Enter Chapter Title (e.g., "The Beginning")
5. Click "Add Chapter"
6. See your chapters listed below with delete options
```

## Supported File Types
- **PDF** (.pdf) - Portable Document Format
- **Images** (.jpg, .jpeg, .png) - For manga/comic style books
- **E-books** (.epub) - Electronic Publication format

## File Size Limit
Maximum file size per upload: **500 MB**

## Database Structure

Your books are organized as:
```
Book
├── Chapter 1
│   ├── Page 1 (image)
│   ├── Page 2 (image)
│   └── ...
├── Chapter 2
│   ├── Page 1 (image)
│   └── ...
└── ...
```

## Troubleshooting

### Files Not Uploading?
- ✓ Check file format (PDF, JPG, PNG, EPUB only)
- ✓ Check file size (must be under 500MB)
- ✓ Ensure `/backend/uploads/` directory exists and is writable
- ✓ Check XAMPP is running and MySQL is connected

### Book Not Appearing?
- ✓ Refresh the page after upload
- ✓ Check browser console for error messages
- ✓ Verify database connection in `config.php`

### Can't Add Chapters?
- ✓ Make sure you've selected a book first
- ✓ Fill in both Chapter Number and Chapter Title
- ✓ Chapter Number should be a positive number

## API Endpoints (For Developers)

```
GET  /api/get_books.php              - List all books
GET  /api/get_book.php?id=X          - Get book with chapters
POST /api/admin/upload_file.php      - Upload book file
POST /api/admin/add_chapter.php      - Add chapter to book
POST /api/admin/delete_chapter.php   - Delete chapter
```

## File Organization

```
web msa khalid/
├── backend/
│   ├── admin.html             ← Admin Interface (you are here)
│   ├── admin.php              ← Admin Backend
│   ├── config.php             ← Database Config
│   ├── uploads/               ← Your uploaded files go here
│   └── api/
│       ├── get_books.php
│       ├── get_book.php
│       └── admin/
│           ├── upload_file.php
│           ├── add_chapter.php
│           └── delete_chapter.php
└── frontend/
    └── ... (your frontend files)
```

## Tips & Tricks 💡

1. **Batch Upload**: You can drag multiple files at once!
2. **Book Names**: Files are automatically named using the filename
3. **Organization**: Create chapters logically (Chapter 1, 2, 3...)
4. **Deletion**: Deleted chapters can't be recovered, so be careful!

## Next Steps

Once you've added books and chapters, you can:
- View them in the frontend
- Add pages/images to chapters via API
- Track reading progress for users
- Generate reports and statistics

---

**Questions or Issues?** Check the `ADMIN_UPDATES.md` file for detailed documentation.
