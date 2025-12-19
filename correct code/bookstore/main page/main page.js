// ====================================
// 1. DROPDOWN MENU LOGIC
// ====================================
const infoImage = document.getElementById('info');
const dropdownMenu = document.getElementById('dropdown-menu');

// Function to show/hide the dropdown
function toggleDropdown() {
    dropdownMenu.classList.toggle('show');
}

// Add a click event listener to the image
infoImage.addEventListener('click', toggleDropdown);

// Close the dropdown if the user clicks anywhere outside of it
window.onclick = function(event) {
    // Check if the click event did NOT originate from the image
    if (!event.target.matches('#info')) {
        // Check if the menu is currently visible (has the 'show' class)
        if (dropdownMenu.classList.contains('show')) {
            dropdownMenu.classList.remove('show');
        }
    }
}

// ====================================
// 2. LOGOUT POPUP LOGIC
// ====================================

// Create popup elements dynamically
const popup = document.createElement("div");
popup.id = "logout-popup";

popup.style.cssText = `
    position: fixed;
    top: 0; left: 0;
    width: 100%; height: 100%;
    background: rgba(0,0,0,0.6);
    display: none;
    justify-content: center;
    align-items: center;
    z-index: 9999;
`;

popup.innerHTML = `
    <div style="
        background: white;
        padding: 25px;
        width: 300px;
        border-radius: 12px;
        text-align: center;
        box-shadow: 0 5px 15px rgba(0,0,0,0.3);
    ">
        <h3>Are you sure you want to logout?</h3>
        <button id="logout-yes" style="font-weight: bold; font-size: 16px; padding:10px 20px; margin:10px; border-radius:10px; border: none; background-color: #ff0000; color: white; cursor: pointer;">Yes</button>
        <button id="logout-no" style="font-weight: bold; padding:10px 20px; margin:10px; border-radius:10px; border: none; cursor: pointer;">Cancel</button>
    </div>
`;
document.body.appendChild(popup);

// Find the logout link
// Note: We look for the PHP link now since we updated the navbar
const logoutLink = document.querySelector('a[href="../login/logout.php"]');

if (logoutLink) {
    logoutLink.addEventListener("click", function (e) {
        e.preventDefault(); // stop navigation
        popup.style.display = "flex"; // show popup
    });
}

// Handle YES and NO buttons inside the popup
document.addEventListener("click", function (e) {
    if (e.target.id === "logout-yes") {
        window.location.href = "../login/logout.php"; // Redirect to PHP logout
    }
    if (e.target.id === "logout-no") {
        popup.style.display = "none"; // Close popup
    }
});

// ====================================
// 3. BOOK CARD LOGIC (REMOVED)
// ====================================
// We removed the JS click listener here because we added 
// onclick="..." directly to the HTML in main_page.php.
// This ensures clicking "Add to Cart" doesn't trigger a redirect.