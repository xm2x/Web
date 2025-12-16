

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






$(document).ready(function() {
    // Get the modal element
    var modal = $("#bookModal");
    
    // Get the element that closes the modal
    var span = $(".close-button");
    
    // 1. Handle Card Click
    $(".card").on("click", function() {
        // Retrieve data from the clicked card using the 'data()' method
        var title = $(this).data("title");
        var author = $(this).data("author");
        var description = $(this).data("description");
        var previewLink = $(this).data("preview");
        var imageSource = $(this).find("img").attr("src"); // Get the image src from the <img> inside the card

        // Populate the modal with the book data
        $("#modalBookTitle").text(title);
        $("#modalBookAuthor").text(author);
        $("#modalBookDescription").text(description);
        $("#modalPreviewButton").attr("href", previewLink);
        $("#modalBookImage").attr("src", imageSource);

        // Display the modal
        modal.css("display", "block");
    });
    
    // 2. Handle Close Button Click (X)
    span.on("click", function() {
        modal.css("display", "none");
    });
    
    // 3. Handle Click Outside Modal
    $(window).on("click", function(event) {
        // Check if the click target is the modal itself
        if ($(event.target).is(modal)) {
            modal.css("display", "none");
        }
    });

    // Optional: Existing user-menu dropdown logic (from your original HTML)
    $("#info").on("click", function() {
        $("#dropdown-menu").toggleClass("show");
    });

    // Close the dropdown if the user clicks outside of it
    $(window).on("click", function(event) {
        if (!$(event.target).closest('.user-menu-wrapper').length) {
            if ($("#dropdown-menu").hasClass('show')) {
                $("#dropdown-menu").removeClass('show');
            }
        }
    });
});