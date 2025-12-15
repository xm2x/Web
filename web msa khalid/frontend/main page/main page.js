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