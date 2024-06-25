function onSubmit() {
    var newPassword = document.getElementById('new-password').value;
    var confirmPassword = document.getElementById('confirm-password').value;
    var email = document.getElementById('email').value;

    if (newPassword != confirmPassword) {
        showToast('Passwords do not match!', 'red');
    } else if (newPassword.length < 8) {
        showToast('Password must be at least 8 characters long!', 'red');
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
                    showToast('Password has been successfully changed!', 'green');
                    setTimeout(function () {
                        window.location.href = "/";
                    }, 2000);
                } else {
                    showToast('Error changing password. Please try again later. TEST', 'red');
                }
            })
            .catch(() => {
                showToast('Error changing password. Please try again later. NO TEST', 'red');
            });
    }
    return false;
}
