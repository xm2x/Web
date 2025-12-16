function handleCredentialResponse(response) {
    // Create a hidden form and submit it to your PHP
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = 'auth.php';

    const actionInput = document.createElement('input');
    actionInput.type = 'hidden';
    actionInput.name = 'action';
    actionInput.value = 'google_login';

    const tokenInput = document.createElement('input');
    tokenInput.type = 'hidden';
    tokenInput.name = 'id_token';
    tokenInput.value = response.credential;

    form.appendChild(actionInput);
    form.appendChild(tokenInput);
    document.body.appendChild(form);
    form.submit();
}