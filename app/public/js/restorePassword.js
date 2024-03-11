function submitForm() {
    var email = document.getElementById('email').value;

    if (!isValidEmail(email)) {
        showMessage('Please enter a valid email address.', 'alert-danger');
        return;
    }

    checkEmailExists(email);
}

function isValidEmail(email) {
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

function checkEmailExists(email) {
    fetch('http://localhost/api/restorepassword/checkEmailExistsAndSendToken', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ email: email }),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('Email has been sent!', 'alert-success');
                // Add code to initiate the password restoration process
            } else {
                showMessage('Email does not exist. Please check your email address.', 'alert-danger');
            }
        })
        .catch(() => {
            showMessage('Error checking email existence. Please try again later.', 'alert-danger');
        });
}

function showMessage(message, alertClass) {
    var messageDiv = document.getElementById('message');
    messageDiv.innerHTML = '<div class="alert ' + alertClass + '">' + message + '</div>';
}