$(document).ready(function() {

    // === 1. Simple Scroll-to-Top Button Functionality ===
    function setupScrollToTopButton() {
        // Create the button element using jQuery syntax
        const $scrollButton = $('<button>', {
            text: '⬆️ Top',
            id: 'scrollToTopBtn'
        });

        // Append to body
        $('body').append($scrollButton);

        // Show/Hide button based on scroll position
        $(window).scroll(function() {
            // Check if scroll distance is greater than 200px
            if ($(this).scrollTop() > 200) {
                $scrollButton.fadeIn(); 
            } else {
                $scrollButton.fadeOut(); 
            }
        });

        // Scroll to top function
        $scrollButton.click(function() {
            // Animate the scroll to top
            $('html, body').animate({ scrollTop: 0 }, 'slow');
        });
    }

    // === 2. Dropdown Menu Functionality ===
    function setupDropdown() {
        const $infoImage = $('#info');
        const $dropdownMenu = $('#dropdown-menu');

        // Toggle dropdown on image click
        $infoImage.click(function(event) {
            // Prevent the click from bubbling up to the window immediately
            event.stopPropagation();
            $dropdownMenu.toggleClass('show');
        });

        // Close the dropdown if user clicks outside
        $(window).click(function(event) {
            // Check if the click target is NOT the image
            if (!$(event.target).is('#info')) {
                // If menu is visible, remove the class
                if ($dropdownMenu.hasClass('show')) {
                    $dropdownMenu.removeClass('show');
                }
            }
        });
    }

    // === Run Functions ===
    setupScrollToTopButton();
    setupDropdown();
});