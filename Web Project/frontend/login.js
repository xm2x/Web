function toggleForms(e) {
    // Stop the link (<a> tag) from trying to navigate
    e.preventDefault(); 
    
    const loginForm = document.getElementById('login-form');
    const signupForm = document.getElementById('signup-form');
    
    if (loginForm.style.display === 'none') {
        loginForm.style.display = 'block';
        signupForm.style.display = 'none';
    } else {
        loginForm.style.display = 'none';
        signupForm.style.display = 'block';
    }
}

function handleLogin(e) {
    // Stop the form from reloading the page on submit
    e.preventDefault(); 
    
    const email = document.getElementById('login-email').value;
    const password = document.getElementById('login-password').value;
    
    alert(`Login attempt with:\nEmail: ${email}\nPassword: ${password}`);
    console.log('Login:', { email, password });
}

function handleSignup(e) {
    // Stop the form from reloading the page on submit
    e.preventDefault(); 
    
    const name = document.getElementById('signup-name').value;
    const email = document.getElementById('signup-email').value;
    const password = document.getElementById('signup-password').value;
    
    alert(`Sign up attempt with:\nName: ${name}\nEmail: ${email}\nPassword: ${password}`);
    console.log('Signup:', { name, email, password });
}