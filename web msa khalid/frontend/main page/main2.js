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

function filterCategory(category) {
    // This reloads the page with the category in the URL
    // Your PHP script (above) will then pick it up and filter the results
    window.location.href = "main_page.php?category=" + category;
}

$(document).ready(function() {
    // 1. Show dropdown when clicking inside the search input
    $('#searchInput').on('focus', function() {
        $('#categoryDropdown').fadeIn(200);
    });

    // 2. Hide dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.search-container').length) {
            $('#categoryDropdown').fadeOut(200);
        }
    });

    // 3. When a category is clicked, put it in the search bar and hide list
    $('.category-item').on('click', function() {
        var categoryValue = $(this).data('value');
        $('#searchInput').val(categoryValue);
        $('#categoryDropdown').fadeOut(200);
        
        // Optional: Automatically submit the form or filter
        // $('.search').submit(); 
    });

    // 4. Filter categories as you type
    $('#searchInput').on('keyup', function() {
        var value = $(this).val().toLowerCase();
        $("#categoryDropdown li").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
});