function updateCopyrightYear() 
{
    
    const currentYear = new Date().getFullYear();

    const footerText = document.querySelector('footer p');
    
    if (footerText) 
        {
        footerText.innerHTML = footerText.innerHTML.replace(/&copy; \d{4}/, '&copy; ' + currentYear);
    }
}



function setupScrollToTopButton() 
{
   
    const scrollButton = document.createElement('button');
    scrollButton.innerText = '⬆️ Top';
    scrollButton.id = 'scrollToTopBtn';
    document.body.appendChild(scrollButton);

    
    window.onscroll = function() {
       

        if (document.body.scrollTop > 200 || document.documentElement.scrollTop > 200) 
            {
            scrollButton.style.display = "block";
        } else {
            scrollButton.style.display = "none";
        }
    };

    scrollButton.onclick = function() 
    {
        window.scrollTo({
            top: 0,
            behavior: 'smooth' 
        });
    };
}

document.addEventListener('DOMContentLoaded', () =>{
    updateCopyrightYear();
    setupScrollToTopButton();
});

const infoImage = document.getElementById('info');
            
    
            const dropdownMenu = document.getElementById('dropdown-menu');
            
            
            function toggleDropdown() 
            {
               
                dropdownMenu.classList.toggle('show');
            }
            
            
            infoImage.addEventListener('click', toggleDropdown);
            
            
            window.onclick = function(event) 
            {
               
                if (!event.target.matches('#info')) 
                    {
                   
                    if (dropdownMenu.classList.contains('show'))
                         {
                       
                        dropdownMenu.classList.remove('show');
                    }
                }
            }