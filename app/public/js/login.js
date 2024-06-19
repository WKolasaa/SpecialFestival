//import { showToast } from './Toast.js';

function login() {
    const loginInput = document.getElementById('username').value;
    const password = document.getElementById('password').value;

    fetch('/api/User/login', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({loginInput: loginInput, password: password}),
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                //console.log(data.success);
                //showToast(data.success, 'green');
                switch (data.success){
                    case "Admin":
                        window.location.href = '/AdminView';
                        break;

                    case "Employee":
                        window.location.href = '/employee';
                        break;

                    default:
                        window.location.href = '/';
                        break;
                }
            } else {
                //console.log(data.error);
                showToast(data.error, 'red');
            }
        })
        .catch((error) => {
            //console.log('Error:', error);
            showToast(error, 'red');
        });
}
