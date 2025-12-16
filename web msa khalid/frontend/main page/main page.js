// ====================================
// 1. DROPDOWN MENU LOGIC
// ====================================
const infoImage = document.getElementById('info');
const dropdownMenu = document.getElementById('dropdown-menu');

// Function to show/hide the dropdown
function toggleDropdown() {
    if (dropdownMenu) {
        dropdownMenu.classList.toggle('show');
    }
}

// Add a click event listener to the image
if (infoImage) {
    infoImage.addEventListener('click', toggleDropdown);
}

// Close the dropdown if the user clicks anywhere outside of it
window.onclick = function(event) {
    if (infoImage && !event.target.matches('#info')) {
        if (dropdownMenu && dropdownMenu.classList.contains('show')) {
            dropdownMenu.classList.remove('show');
        }
    }
}

// ====================================
// 2. BOOK CARD CLICK LOGIC
// ====================================
// Select all book cards
const cards = document.querySelectorAll(".card");

cards.forEach(card => {
    card.addEventListener("click", () => {
        // Get title and image source
        const title = card.querySelector("h3").textContent;
        const imgSrc = card.querySelector("img").getAttribute("src");

        // Redirect to preview page with book data
        window.location.href = `../book_preview/book_preview.html?title=${encodeURIComponent(title)}&img=${encodeURIComponent(imgSrc)}`;
    });
});