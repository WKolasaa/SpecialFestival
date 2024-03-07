function onSubmit(){
    var username = document.getElementById('username').value;
    var password = document.getElementById('password').value;
    var email = document.getElementById('email').value;
    var data = {
        username: username,
        password: password,
        email: email
    }
    fetch('/signup', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(data => {
        if(data.success){
            window.location.href = '/login';
        } else {
            alert(data.message);
        }
    });
    return false;
}