function showSignup() {
    document.getElementById('login-form').classList.add('hidden');
    document.getElementById('signup-form').classList.remove('hidden');
    document.getElementById('message').innerText = "";
}

function showLogin() {
    document.getElementById('signup-form').classList.add('hidden');
    document.getElementById('login-form').classList.remove('hidden');
    document.getElementById('message').innerText = "";
}

function togglePassword(fieldId) {
    const field = document.getElementById(fieldId);
    if (field.type === "password") {
        field.type = "text";
    } else {
        field.type = "password";
    }
}

function login() {
    document.getElementById('message').innerText = "Logging you in...";
    document.getElementById('message').style.color = "green";

    // Redirect to main page after 1 second
    setTimeout(() => {
        window.location.href = "../main page/main page.html"; // change to your real file name
    }, 1000);
}

function signup() {
    document.getElementById('message').innerText = "Account created!";
    document.getElementById('message').style.color = "green";
    setTimeout(showLogin, 1500);
}