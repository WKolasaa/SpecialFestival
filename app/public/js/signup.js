function onSubmit(){ // TODO: Finish this
    var captchaResponse = document.querySelector('.g-recaptcha-response').value;
    
    fetch("/api/singup/captcha", {
        method: 'POST',
        body: JSON.stringify({captchaResponse: captchaResponse}),
    })
    .then(response => response.json)
    .then(data => {
        if(data.success){
            alert("Captcha verified!");
        }
        else{
            alert("Capthca not verified")
        }
    })
    .catch(error => {
        alert("Error");
    })
}

// function onSubmit() {
//   if (checkFields()) {
//      var username = document.getElementById("username").value;
//      var firstName = document.getElementById("firstName").value;
//      var lastName = document.getElementById("lastName").value;
//      var password = document.getElementById("password").value;
//      var email = document.getElementById("email").value;
//      var data = {
//        username: username,
//        firstName: firstName,
//        lastName: lastName,
//        password: password,
//        email: email,
//      };
//      fetch("http://localhost/api/signup", {
//        method: "POST",
//       headers: {
//          "Content-Type": "application/json",
//        },
//        body: JSON.stringify(data),
//      })
//        .then((response) => response.json())
//        .then((data) => {
//          if (data.success) {
//            showMessage("User created successfully!", "alert-success");
//          } else {
//            showMessage(
//              "Error creating user. Please try again later.",
//              "alert-danger"
//            );
//          }
//       })
//        .catch(() => {
//          showMessage(
//            "Error creating user. Please try again later.",
//            "alert-danger"
//          );
//        });
//    }
//  }

 function checkFields() {
    var username = document.getElementById("username").value;
    var firstName = document.getElementById("firstName").value;
    var lastName = document.getElementById("lastName").value;
    var password = document.getElementById("password").value;
    var email = document.getElementById("email").value;

    if (
        username == "" ||
        firstName == "" ||
        lastName == "" ||
        password == "" ||
        email == ""
    ) {
        showMessage("All fields must be field!", "alert-danger");
        return false;
   }

   return true;
 }
 
function showMessage(message, alertClass) {
    var messageDiv = document.getElementById("message");
    messageDiv.innerHTML =
    '<div class="alert ' + alertClass + '">' + message + "</div>";
}
 