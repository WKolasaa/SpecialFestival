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
    fetch('/api/restorepassword/checkEmailExistsAndSendToken', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({email: email}),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Email sent successfully. Please check your email for further instructions.', "green");
                // Add code to initiate the password restoration process
            } else {
                showToast('Email does not exist in the system. Please enter a valid email address.', "red");
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