const form = document.querySelector('.sign-up-form');

form.addEventListener('submit', function(event) {
    const password = document.querySelector('#password').value;
    const confirmPassword = document.querySelector('#confirm-password').value;
    const errorMessage = document.querySelector('.error-message');
    
    if (password !== confirmPassword) {
        errorMessage.style.display = 'block';
        event.preventDefault(); 
    } else {
        errorMessage.style.display = 'none';
    }
});