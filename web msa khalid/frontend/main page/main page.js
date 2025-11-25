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
        <button id="logout-yes" style=" font-weight: bold;font-size: 16px;padding:10px 20px; margin:10px;border-radius:10px; border: none; background-color: #ff0000ff;">Yes</button>
        <button id="logout-no" style="font-weight: bold; padding:10px 20px; margin:10px;border-radius:10px;  border: none;">Cancel</button>
    </div>
`;
document.body.appendChild(popup);


// Find the logout link
const logoutLink = document.querySelector('a[href="../log-in form/login.html"]');

if (logoutLink) {
    logoutLink.addEventListener("click", function (e) {
        e.preventDefault(); // stop navigation
        popup.style.display = "flex"; // show popup
    });
}

// Handle YES and NO buttons
document.addEventListener("click", function (e) {
    if (e.target.id === "logout-yes") {
        window.location.href = "../log-in form/login.html"; // redirect
    }
    if (e.target.id === "logout-no") {
        popup.style.display = "none"; // close popup
    }
});



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
