$(document).ready(function() {
  // API Base URL - adjust based on your server setup
  const API_URL = '../../backend/api';

  // Fallback SVG data for offline testing
  const makeDataSvg = (bg1, bg2, text) => {
    const svg = `
      <svg xmlns='http://www.w3.org/2000/svg' width='1200' height='1600' viewBox='0 0 1200 1600'>
        <defs>
          <linearGradient id='g' x1='0' x2='1' y1='0' y2='1'>
            <stop offset='0' stop-color='${bg1}' />
            <stop offset='1' stop-color='${bg2}' />
          </linearGradient>
        </defs>
        <rect width='100%' height='100%' fill='url(#g)' />
        <text x='50%' y='50%' dominant-baseline='middle' text-anchor='middle' font-family='Arial, Helvetica, sans-serif' font-size='56' fill='rgba(255,255,255,0.95)'>${text}</text>
      </svg>`;
    return 'data:image/svg+xml;utf8,' + encodeURIComponent(svg);
  };

  // Default fallback pages if API fails
  const pagesByChapter = {
    '1': [
      makeDataSvg('#f3b562', '#e86f6f', 'Chapter 1 — Page 1'),
      makeDataSvg('#f1c27a', '#e69797', 'Chapter 1 — Page 2'),
      makeDataSvg('#f7d9b0', '#e8b1b1', 'Chapter 1 — Page 3')
    ],
    '2': [
      makeDataSvg('#2bb7b7', '#2b9bd7', 'Chapter 2 — Page 1'),
      makeDataSvg('#57c6c6', '#4aa0d0', 'Chapter 2 — Page 2')
    ],
    '3': [
      makeDataSvg('#d69bd7', '#f3b1c1', 'Chapter 3 — Page 1')
    ]
  };

  // Start with chapter 1 by default
  let pages = pagesByChapter['1'].slice();
  let current = 0;
  let currentBookId = null;
  let chapters = [];

  // jQuery selectors for DOM elements
  const $pageImage = $('#pageImage');
  const $pageNumber = $('#pageNumber');
  const $pageCount = $('#pageCount');
  const $prevBtn = $('#prevPage');
  const $nextBtn = $('#nextPage');
  const $jumpInput = $('#jumpTo');
  const $jumpBtn = $('#jumpBtn');
  const $viewer = $('#viewer');
  const $toggleSidebar = $('#toggleSidebar');
  const $sidebar = $('#sidebar');
  const $fullscreenBtn = $('#fullscreen');
  const $nightModeBtn = $('#nightModeBtn');
  const $chapterList = $('#chapterList');

  $pageCount.text(pages.length);
  $jumpInput.attr('max', pages.length);
  loadPage(current);

  function loadPage(index) {
    index = Math.max(0, Math.min(index, pages.length - 1));
    current = index;
    $pageImage.attr('src', pages[current]).attr('alt', `Page ${current + 1}`);
    $pageNumber.text(current + 1);
    $prevBtn.prop('disabled', current === 0);
    $nextBtn.prop('disabled', current === pages.length - 1);
    $jumpInput.val(current + 1);
  }

  $prevBtn.on('click', () => loadPage(current - 1));
  $nextBtn.on('click', () => loadPage(current + 1));
  $jumpBtn.on('click', () => {
    const v = parseInt($jumpInput.val(), 10);
    if (!isNaN(v)) loadPage(v - 1);
  });

  $viewer.on('keydown', (e) => {
    if (e.key === 'ArrowLeft') loadPage(current - 1);
    if (e.key === 'ArrowRight') loadPage(current + 1);
  });

  $pageImage.on('click', () => loadPage(current + 1));

  $toggleSidebar.on('click', () => {
    const shown = $sidebar.css('display') !== 'none';
    $sidebar.toggle();
    $toggleSidebar.attr('aria-pressed', shown ? 'true' : 'false');
  });

  // Make the image itself go fullscreen (so the photo, not the whole page)
  $fullscreenBtn.on('click', async () => {
    try {
      const imageElement = $pageImage[0];
      if (!document.fullscreenElement) {
        if (imageElement.requestFullscreen) await imageElement.requestFullscreen();
        else if (imageElement.webkitRequestFullscreen) await imageElement.webkitRequestFullscreen();
        else await document.documentElement.requestFullscreen();
      } else {
        await document.exitFullscreen();
      }
    } catch (err) {
      console.error('Fullscreen error:', err);
    }
  });

  // Night mode toggle: toggles a class on <body> so CSS can change colors
  $nightModeBtn.on('click', () => {
    $('body').toggleClass('night-mode');
    $nightModeBtn.toggleClass('active');
  });

  // Function to fetch chapter pages from API
  function fetchChapterPages(chapterId) {
    $.ajax({
      url: `${API_URL}/get_chapter_pages.php?chapter_id=${chapterId}`,
      method: 'GET',
      dataType: 'json',
      success: function(response) {
        if (response.success && response.data.length > 0) {
          pages = response.data.map(p => p.image_path);
          $pageCount.text(pages.length);
          $jumpInput.attr('max', pages.length);
          loadPage(0);
        } else {
          console.log('No pages found, using fallback');
        }
      },
      error: function(err) {
        console.error('Error fetching pages:', err);
      }
    });
  }

  // Function to fetch and load chapters from API
  function fetchChaptersForBook(bookId) {
    $.ajax({
      url: `${API_URL}/get_book.php?id=${bookId}`,
      method: 'GET',
      dataType: 'json',
      success: function(response) {
        if (response.success && response.data.chapters) {
          chapters = response.data.chapters;
          $chapterList.empty();
          chapters.forEach(ch => {
            $chapterList.append(`<li><a href="#" data-chapter="${ch.id}">${ch.title}</a></li>`);
          });
          // Load first chapter
          if (chapters.length > 0) {
            fetchChapterPages(chapters[0].id);
            $chapterList.find('a').first().addClass('active');
          }
        }
      },
      error: function(err) {
        console.error('Error fetching book chapters:', err);
      }
    });
  }

  // Chapter click handler
  $chapterList.on('click', 'a[data-chapter]', function(e) {
    e.preventDefault();
    const chapterId = $(this).attr('data-chapter');
    
    $('#chapterList a').removeClass('active');
    $(this).addClass('active');
    
    // Fetch pages from database for this chapter
    fetchChapterPages(chapterId);
  });

  // Read query params and update preview cover/title if provided
  const params = new URLSearchParams(window.location.search);
  const titleParam = params.get('title');
  const imgParam = params.get('img');
  const bookIdParam = params.get('book_id');

  if (bookIdParam) {
    // Load book from database
    currentBookId = bookIdParam;
    fetchChaptersForBook(bookIdParam);
  }

  if (titleParam) {
    const decodedTitle = decodeURIComponent(titleParam);
    $('.book-meta .title').text(decodedTitle);
    document.title = `${decodedTitle} — Book Preview`;
  }

  if (imgParam) {
    const $coverEl = $('.book-meta .cover');
    if ($coverEl.length) {
      const imgPath = decodeURIComponent(imgParam);
      // Try the path as provided first
      $coverEl.attr('src', imgPath);

      // If it fails to load, try a fallback relative to the main page folder
      $coverEl.on('error', function() {
        const altPath = `../main page/${imgPath}`;
        if ($(this).attr('src') !== altPath) {
          $(this).attr('src', altPath);
        }
      });
    }
  }

  // Dropdown menu functionality using jQuery
  const $infoImage = $('#info');
  const $dropdownMenu = $('#dropdown-menu');

  function toggleDropdown() {
    $dropdownMenu.toggleClass('show');
  }

  $infoImage.on('click', toggleDropdown);

  // Close the dropdown if the user clicks anywhere outside of it
  $(window).on('click', function(event) {
    if (!$(event.target).is('#info')) {
      if ($dropdownMenu.hasClass('show')) {
        $dropdownMenu.removeClass('show');
      }
    }
  });
});