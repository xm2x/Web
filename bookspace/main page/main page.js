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
// // 2. LOGOUT POPUP LOGIC
// // ====================================
//     $(document).ready(function () {
//         // Create the popup element
//         const $popup = $("<div>", { id: "logout-popup" }).css({
//             "position": "fixed",
//             "top": 0, "left": 0,
//             "width": "100%", "height": "100%",
//             "background": "rgba(0,0,0,0.6)",
//             "display": "none", 
//             "justify-content": "center",
//             "align-items": "center",
//             "z-index": 9999
//         });

//         $popup.html(`
//             <div style="background: white; padding: 25px; width: 300px; border-radius: 12px; text-align: center; box-shadow: 0 5px 15px rgba(0,0,0,0.3);">
//                 <h3 style="color: black; margin-bottom: 20px;">Are you sure you want to logout?</h3>
//                 <button id="logout-yes" style="font-weight: bold; font-size: 16px; padding:10px 20px; margin:10px; border-radius:10px; border: none; background-color: #ff0000; color: white; cursor: pointer;">Yes</button>
//                 <button id="logout-no" style="font-weight: bold; padding:10px 20px; margin:10px; border-radius:10px; border: none; cursor: pointer;">Cancel</button>
//             </div>
//         `);

//         // Append to the body
//         $("body").append($popup);

//         // Show popup ONLY when the logout link is clicked 
//         // Note: Using the specific text or href to target only the Logout button
//         $(document).on("click", 'a[href="../log-in form/login.php"]:contains("Logout")', function (e) {
//             e.preventDefault();
//             $popup.css("display", "flex").hide().fadeIn(200);
//         });

//         // Handle button clicks inside the popup
//         $(document).on("click", "#logout-yes", function () {
//             window.location.href = "../log-in form/login.php";
//         });

//         $(document).on("click", "#logout-no", function () {
//             $popup.fadeOut(200);
//         });
//     });
