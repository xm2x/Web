// This ensures all code runs only after the entire HTML document is ready.
$(document).ready(function() {

    // --- 1. Dropdown Menu Toggle Logic ---
    const $infoImage = $('#info');
    const $dropdownMenu = $('#dropdown-menu');
    
    // Toggle the 'show' class when the info image is clicked
    $infoImage.on('click', function(e) {
        e.stopPropagation(); // Stop the event from bubbling up to the document click handler
        $dropdownMenu.toggleClass('show'); 
    });

    // Close the dropdown if the user clicks anywhere else on the page (document)
    $(document).on('click', function() {
        // If the menu is currently visible, hide it.
        if ($dropdownMenu.hasClass('show')) {
            $dropdownMenu.removeClass('show');
        }
    });

    // --- 2. Update Copyright Year ---
    const currentYear = new Date().getFullYear();
    const $footerText = $('footer p');
    
    // Check if the element exists and update its HTML content using .html()
    if ($footerText.length) {
        $footerText.html($footerText.html().replace(/&copy; \d{4}/, '&copy; ' + currentYear));
    }

    // --- 3. Scroll to Top Button Logic ---
    
    // Create the button, add it to the body, and hide it immediately
    const $scrollButton = $('<button>', {
        id: 'scrollToTopBtn',
        text: '⬆️ Top'
    }).appendTo('body').hide(); 

    // Show/Hide button on scroll
    $(window).on('scroll', function() {
        // Use jQuery's .scrollTop() to get the scroll position
        if ($(this).scrollTop() > 200) {
            $scrollButton.fadeIn(); // Smoothly show the button
        } else {
            $scrollButton.fadeOut(); // Smoothly hide the button
        }
    });

    // Handle button click for smooth scrolling
    $scrollButton.on('click', function() {
        // Use jQuery's .animate() on 'html, body' for a smooth scroll back to the top (0)
        $('html, body').animate({ scrollTop: 0 }, 600); // 600ms duration
    });
});