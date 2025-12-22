<?php
session_start();

// === AUTO-LOGIN (COOKIE CHECK) ===
// If user is NOT logged in (Session is empty) BUT has a "Remember Me" cookie...
if (!isset($_SESSION['user_id']) && isset($_COOKIE['user_login'])) {
    
    // Connect to Database
    $conn = new mysqli("localhost", "root", "", "bookstore_db");
    
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Check if the Cookie ID exists in database
    $cookie_id = $_COOKIE['user_login'];
    // Prevent SQL Injection
    $safe_cookie_id = $conn->real_escape_string($cookie_id);
    
    $sql = "SELECT * FROM users WHERE id='$safe_cookie_id'";
    $result = $conn->query($sql);

    // If found, log them in automatically
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['user_name'] = $row['full_name'];
    }
    $conn->close();
}
?>
<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Book Preview — Ebook Store</title>
  <link rel="stylesheet" href="book_preview.css">
</head>
<body>
  
  <header class="site-header">
    <div class="container">
      <section class="nav">
        <div class="logo">
            <h1>Your Book Space</h1>
        </div> 
        

        <div class="user-menu-wrapper">
            <img 
                src="download (17).jpg" 
                alt="User Info" 
                style="border-radius: 50%; width: 50px; height: 50px;" 
                id="info"
            >
            <div id="dropdown-menu" class="dropdown-content">
                <a href="../main page/main_page.php" class="home">Home</a>
                <a href="../about/about_us.html" class="about">About</a>
                <a href="../contact/contact.html" class="contcat">Contact</a>
                <a href="../cart.php">🛒 View Cart</a>
                <a href="../plans/plan.php">Upgrade</a>
            </div>
        </div>
      </section>
    </div>
  </header>

  <main class="container layout">
    <aside class="sidebar" id="sidebar">
      <div class="book-meta">
        <img src="images/cover.jpg" alt="Book Cover" class="cover">
        <h1 class="title">Book Title</h1>
        <p class="author">Author: Unknown</p>
        <p class="desc">Description of the book goes here...</p>
      </div>

      <div class="chapters">
        <h2>Chapters</h2>
        <ul id="chapterList">
          <li><a href="#" data-chapter="1">Chapter 1 — New Life</a></li>
          <li><a href="#" data-chapter="2">Chapter 2 — Training</a></li>
          <li><a href="#" data-chapter="3">Chapter 3 — Return</a></li>
        </ul>
      </div>
    </aside>

    <section class="viewer-area">
      <div class="controls">
        <button id="toggleSidebar" aria-pressed="false" title="Toggle sidebar">☰</button>
        <button id="prevPage" title="Previous page">◀ Prev</button>
        <span id="pageInfo">Page <strong id="pageNumber">1</strong> / <span id="pageCount">—</span></span>
        <button id="nextPage" title="Next page">Next ▶</button>
        <button id="fullscreen" title="Fullscreen">⤢</button>
        <button id="nightModeBtn" title="Night mode">🌙</button>
      </div>

      <div class="viewer" id="viewer" tabindex="0" aria-live="polite">
        <img id="pageImage" src="" alt="Page 1" loading="lazy">
      </div>

      <div class="jump">
        <label for="jumpTo">Jump to page</label>
        <input id="jumpTo" type="number" min="1" />
        <button id="jumpBtn">Go</button>
      </div>
    </section>
  </main>

  <footer class="site-footer container">
    <small>© <?php echo date("Y"); ?> EbookStore — Demo</small>
  </footer>

  <script src="book_preview.js" defer></script>
</body>
</html>