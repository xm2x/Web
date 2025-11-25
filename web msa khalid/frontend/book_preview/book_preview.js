document.addEventListener('DOMContentLoaded', () => {
  const pages = [
    'images/page1.jpg',
    'images/page2.jpg',
    'images/page3.jpg'
  ];

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

  fullscreenBtn.addEventListener('click', async () => {
    if (!document.fullscreenElement) {
      await document.documentElement.requestFullscreen();
    } else {
      await document.exitFullscreen();
    }
  });

  document.getElementById('chapterList').addEventListener('click', (e) => {
    const a = e.target.closest('a[data-chapter]');
    if (!a) return;
    e.preventDefault();

    const ch = a.getAttribute('data-chapter');
    pages.length = 0;

    if (ch === '1') pages.push('images/page1.jpg', 'images/page2.jpg', 'images/page3.jpg');
    else if (ch === '2') pages.push('images/ch2page1.jpg', 'images/ch2page2.jpg');
    else pages.push('images/page1.jpg');

    pageCount.textContent = pages.length;
    jumpInput.max = pages.length;

    document.querySelectorAll('#chapterList a').forEach(x => x.classList.remove('active'));
    a.classList.add('active');

    loadPage(0);
  });
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