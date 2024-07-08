function showForgotPassword() {
    document.querySelector('.login-container').style.display = 'none';
    document.getElementById('resetContainer').style.display = 'block';
}

function showRegister() {
    document.querySelector('.login-container').style.display = 'none';
    document.getElementById('registerContainer').style.display = 'block';
}

function showLogin() {
    document.querySelector('.login-container').style.display = 'block';
    document.getElementById('registerContainer').style.display = 'none';
    document.getElementById('resetContainer').style.display = 'none';
}

async function login(event) {
    event.preventDefault();
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    try {
        const response = await fetch('php/login.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                username: username,
                password: password
            })
        });

        const text = await response.text(); // Get raw response text
        console.log('Raw response:', text); // Log raw response

        // Ensure response is JSON
        let data;
        try {
            data = JSON.parse(text); // Parse the response as JSON
        } catch (error) {
            console.error('Error parsing JSON:', error);
            console.log('Response text that caused JSON parse error:', text);
            return;
        }

        if (data.status === 'success') {
            alert(data.message);
            localStorage.setItem('username', username); // Store username in localStorage
            window.location.href = data.redirect; // Redirect to the appropriate page
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

document.getElementById('loginForm').addEventListener('submit', login);

async function register(event) {
    event.preventDefault();
    const username = document.getElementById('reg_username').value;
    const password = document.getElementById('reg_password').value;

    try {
        const response = await fetch('php/register.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                username: username,
                password: password
            })
        });

        const data = await response.json();

        if (data.status === 'success') {
            alert(data.message);
            showLogin();
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

async function resetPassword(event) {
    event.preventDefault();
    const username = document.getElementById('reset_username').value;

    try {
        const response = await fetch('php/reset_password.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: new URLSearchParams({
                username: username
            })
        });

        const data = await response.json();

        if (data.status === 'success') {
            alert(data.message);
            showLogin();
        } else {
            alert(data.message);
        }
    } catch (error) {
        console.error('Error:', error);
    }
}

