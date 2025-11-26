document.addEventListener('DOMContentLoaded', () => {
  // Use embedded SVG data-URIs for quick local testing of page turning
  // These avoid needing separate image files and let you test navigation immediately.
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

  // Create per-chapter page arrays using the embedded SVGs
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

  const pageImage = document.getElementById('pageImage');
  const pageNumber = document.getElementById('pageNumber');
  const pageCount = document.getElementById('pageCount');
  const prevBtn = document.getElementById('prevPage');
  const nextBtn = document.getElementById('nextPage');
  const jumpInput = document.getElementById('jumpTo');
  const jumpBtn = document.getElementById('jumpBtn');
  const viewer = document.getElementById('viewer');
  const toggleSidebar = document.getElementById('toggleSidebar');
  const sidebar = document.getElementById('sidebar');
  const fullscreenBtn = document.getElementById('fullscreen');
  const nightModeBtn = document.getElementById('nightModeBtn');

  pageCount.textContent = pages.length;
  jumpInput.max = pages.length;
  loadPage(current);

  function loadPage(index) {
    index = Math.max(0, Math.min(index, pages.length - 1));
    current = index;
    pageImage.src = pages[current];
    pageImage.alt = `Page ${current + 1}`;
    pageNumber.textContent = current + 1;
    prevBtn.disabled = current === 0;
    nextBtn.disabled = current === pages.length - 1;
    jumpInput.value = current + 1;
  }

  prevBtn.addEventListener('click', () => loadPage(current - 1));
  nextBtn.addEventListener('click', () => loadPage(current + 1));
  jumpBtn.addEventListener('click', () => {
    const v = parseInt(jumpInput.value, 10);
    if (!isNaN(v)) loadPage(v - 1);
  });

  viewer.addEventListener('keydown', (e) => {
    if (e.key === 'ArrowLeft') loadPage(current - 1);
    if (e.key === 'ArrowRight') loadPage(current + 1);
  });

  pageImage.addEventListener('click', () => loadPage(current + 1));

  toggleSidebar.addEventListener('click', () => {
    const shown = sidebar.style.display !== 'none';
    sidebar.style.display = shown ? 'none' : '';
    toggleSidebar.setAttribute('aria-pressed', shown ? 'true' : 'false');
  });

  // Make the image itself go fullscreen (so the photo, not the whole page)
  fullscreenBtn.addEventListener('click', async () => {
    try {
      if (!document.fullscreenElement) {
        if (pageImage.requestFullscreen) await pageImage.requestFullscreen();
        else if (pageImage.webkitRequestFullscreen) await pageImage.webkitRequestFullscreen();
        else await document.documentElement.requestFullscreen();
      } else {
        await document.exitFullscreen();
      }
    } catch (err) {
      console.error('Fullscreen error:', err);
    }
  });

  // Night mode toggle: toggles a class on <body> so CSS can change colors
  if (nightModeBtn) {
    nightModeBtn.addEventListener('click', () => {
      document.body.classList.toggle('night-mode');
      nightModeBtn.classList.toggle('active');
    });
  }

  const chapterList = document.getElementById('chapterList');
  chapterList.addEventListener('click', (e) => {
    const a = e.target.closest('a[data-chapter]');
    if (!a) return;
    e.preventDefault();

    const ch = a.getAttribute('data-chapter');
    if (pagesByChapter[ch]) {
      pages = pagesByChapter[ch].slice();
    } else {
      pages = pagesByChapter['1'].slice();
    }

    pageCount.textContent = pages.length;
    jumpInput.max = pages.length;

    document.querySelectorAll('#chapterList a').forEach(x => x.classList.remove('active'));
    a.classList.add('active');

    loadPage(0);
  });

  // Activate chapter 1 visually and load its first page on open
  (function openDefaultChapter() {
    const first = chapterList.querySelector('a[data-chapter="1"]');
    if (first) {
      document.querySelectorAll('#chapterList a').forEach(x => x.classList.remove('active'));
      first.classList.add('active');
    }
    pages = pagesByChapter['1'].slice();
    pageCount.textContent = pages.length;
    jumpInput.max = pages.length;
    loadPage(0);
  })();

  // Read query params and update preview cover/title if provided
  const params = new URLSearchParams(window.location.search);
  const titleParam = params.get('title');
  const imgParam = params.get('img');

  if (titleParam) {
    const titleEl = document.querySelector('.book-meta .title');
    if (titleEl) titleEl.textContent = decodeURIComponent(titleParam);
    if (document.title) document.title = `${decodeURIComponent(titleParam)} — Book Preview`;
  }

  if (imgParam) {
    const coverEl = document.querySelector('.book-meta .cover');
    if (coverEl) {
      const imgPath = decodeURIComponent(imgParam);
      // Try the path as provided first
      coverEl.src = imgPath;

      // If it fails to load, try a fallback relative to the main page folder
      function tryAlt() {
        const altPath = `../main page/${imgPath}`;
        if (coverEl.src === altPath) return;
        coverEl.src = altPath;
        coverEl.removeEventListener('error', tryAlt);
      }
      coverEl.addEventListener('error', tryAlt);
    }
  }
});

const infoImage = document.getElementById('info');
            
            // Get the dropdown menu element by its ID
            const dropdownMenu = document.getElementById('dropdown-menu');
            
            // Function to show/hide the dropdown
            function toggleDropdown() {
                // Toggles the 'show' class on the dropdown menu
                // If the class is present, display:block is applied (show)
                // If the class is absent, display:none is applied (hide)
                dropdownMenu.classList.toggle('show');
            }
            
            // Add a click event listener to the image
            infoImage.addEventListener('click', toggleDropdown);
            
            // Optional: Close the dropdown if the user clicks anywhere outside of it
            window.onclick = function(event) {
                // Check if the click event did NOT originate from the image
                if (!event.target.matches('#info')) {
                    // Check if the menu is currently visible (has the 'show' class)
                    if (dropdownMenu.classList.contains('show')) {
                        // Hide the menu
                        dropdownMenu.classList.remove('show');
                    }
                }
            }