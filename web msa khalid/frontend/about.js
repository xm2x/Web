// about.js

// === 1. Update Copyright Year ===
function updateCopyrightYear() {
    // Get the current year
    const currentYear = new Date().getFullYear();
    // Find the footer paragraph
    const footerText = document.querySelector('footer p');
    
    // Safety check to ensure the element exists
    if (footerText) {
        // Replace the static year in the HTML (&copy; 2025) with the current year
        footerText.innerHTML = footerText.innerHTML.replace(/&copy; \d{4}/, '&copy; ' + currentYear);
    }
}


// === 2. Simple Scroll-to-Top Button Functionality ===
function setupScrollToTopButton() {
    // 1. Create the button element
    const scrollButton = document.createElement('button');
    scrollButton.innerText = '⬆️ Top';
    scrollButton.id = 'scrollToTopBtn';
    document.body.appendChild(scrollButton);

    // 2. Add minimal style to the button (consider moving this to CSS)
    scrollButton.style.cssText = `
        display: none; 
        position: fixed;
        bottom: 20px;
        right: 30px;
        z-index: 99;
        border: none;
        outline: none;
        background-color: #8d6e63; /* Matches your header color */
        color: white;
        cursor: pointer;
        padding: 15px;
        border-radius: 10px;
        font-size: 14px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    `;

    // 3. Show/Hide button based on scroll position
    window.onscroll = function() {
        // Show button if user scrolls more than 200px down
        if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) {
            scrollButton.style.display = "block";
        } else {
            scrollButton.style.display = "none";
        }
    };

    // 4. Scroll to top function
    scrollButton.onclick = function() {
        window.scrollTo({
            top: 0,
            behavior: 'smooth' // Smooth scrolling effect
        });
    };
}


// === Run All Functions When Page Loads ===
document.addEventListener('DOMContentLoaded', () => {
    updateCopyrightYear();
    setupScrollToTopButton();
});