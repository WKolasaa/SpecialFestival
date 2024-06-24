function onSubmit() {
    var newPassword = document.getElementById('new-password').value;
    var confirmPassword = document.getElementById('confirm-password').value;
    var email = document.getElementById('email').value;

    if (newPassword != confirmPassword) {
        showMessage('Passwords do not match!', 'alert-danger');
    } else if (newPassword.length < 8) {
        showMessage('Password must be at least 8 characters long!', 'alert-danger');
    } else {
        const bodyData = {
            newPassword: newPassword,
            confirmPassword: confirmPassword,
            email: email
        };


        fetch('/api/changepassword/changePassword', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(bodyData),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Password has been successfully changed!', 'alert-success');
                    setTimeout(function () {
                        window.location.href = "/";
                    }, 2000);
                } else {
                    showMessage('Error changing password. Please try again later. TEST', 'alert-danger');
                }
            })
            .catch(() => {
                showMessage('Error changing password. Please try again later. NO TEST', 'alert-danger');
            });
    }
    return false;
}

function showMessage(message, alertClass) {
    var messageDiv = document.getElementById('message');
    messageDiv.innerHTML = '<div class="alert ' + alertClass + '">' + message + '</div>';
}
