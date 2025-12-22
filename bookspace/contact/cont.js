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
