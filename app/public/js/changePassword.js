function onSubmit() {
    var newPassword = document.getElementById('new-password').value;
    var confirmPassword = document.getElementById('confirm-password').value;

    if (newPassword != confirmPassword) {
        showMessage('Passwords do not match!', 'alert-danger');
    } else {
        var urlParams = new URLSearchParams(window.location.search);
        var token = urlParams.get('token');

        fetch('http://localhost/api/changepassword/changePassword', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Authorization': 'Bearer ' + token,
            },
            body: JSON.stringify({ newPassword: newPassword, confirmPassword: confirmPassword }),
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    showMessage('Password has been successfully changed!', 'alert-success');
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
