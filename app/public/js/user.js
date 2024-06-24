//manage user CRUD operations
function loadUserData() {
    fetch("/api/user")
        .then((response) => response.json())
        .then((data) => {
            console.log("API Response: ", data);
            if (data) {
                console.log("User:", data);
                displayUserInfo(data);
            } else {
                showMessage(
                    "Error loading user data. Please try again later.",
                    "alert-danger"
                );
            }
        })
        .catch((error) => {
            console.error("Error: ", error);
            showMessage(
                "Error loading user data. Please try again later.",
                "alert-danger"
            );
        });
}

function displayUserInfo(userData) {
    const userId = document.getElementById("userId");
    const userRole = document.getElementById("userRole");
    const username = document.getElementById("userName");
    const firstName = document.getElementById("firstName");
    const lastName = document.getElementById("lastName");
    const email = document.getElementById("email");
    const password = document.getElementById("password");
    const photo = document.getElementById("photo");
    const phoneNumber = document.getElementById("phoneNumber");

    const submitButton = document.getElementById("submitButton");

    if (userData) {
        userId.value = userData.id;
        userRole.value = userData.userRole;
        username.value = userData.username;
        firstName.value = userData.firstName;
        lastName.value = userData.lastName;
        email.value = userData.email;
        password.value = userData.password;
        photo.src = userData.photo;
        phoneNumber.value = userData.phoneNumber;


        if (userData.username != null) {
            // console.log("User is found");
            submitButton.textContent = "Update";
            submitButton.className = "btn btn-success";
        } else {
            // console.log("User not found");
            submitButton.textContent = "Submit";
        }
    } else {
        showMessage(
            "Error loading user data. Please try again later.",
            "alert-danger"
        );
    }
}

loadUserData();

///////////////Update User Data////////////////////
document.addEventListener("DOMContentLoaded", function () {
    const signupForm = document.getElementById("signupForm");
    signupForm.addEventListener("submit", function (event) {
        event.preventDefault();

        const formData = new FormData(signupForm);
        const formDataObject = {};
        formData.forEach((value, key) => {
            if (key !== 'g-recaptcha-response') {
                formDataObject[key] = value;
            }
        });

        const isUpdate =
            signupForm.querySelector("#submitButton").textContent === "Update";
        const apiEndpoint = isUpdate
            ? "/api/user/update"
            : "/signup/captcha";

        console.log(formDataObject);
        fetch(apiEndpoint, {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify(formDataObject),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.text();
            })
            .then((data) => {
                if (!data) {
                    throw new Error("No data received from server");
                }

                try {
                    const parsedData = JSON.parse(data);
                    if (isUpdate) {
                        showMessage("User updated successfully.", "alert-success");
                        loadUserData();
                    }
                } catch (error) {
                    console.error(error);
                    showMessage(
                        "Error updating user. Please try again later.",
                        "alert-danger"
                    );
                }
            })
            .catch((error) => {
                console.error(
                    "There has been a problem with your fetch operation:",
                    error
                );
            });
    });
});

function showMessage(message, alertClass) {
    const messageElement = document.getElementById('message');
    messageElement.textContent = message;
    messageElement.className = `alert ${alertClass}`;
}


document.addEventListener("DOMContentLoaded", function () {
    const deleteButton = document.getElementById("deleteButton");
    deleteButton.addEventListener("click", function (event) {
        event.preventDefault();

        const userId = document.getElementById("userId").value;
        console.log("User ID: ", userId);

        fetch(`/api/user/delete`, {
            method: "DELETE",
            headers: {
                "Content-Type": "application/json",
            },
            body: JSON.stringify({id: userId}),
        })
            .then((response) => {
                if (!response.ok) {
                    throw new Error("Network response was not ok");
                }
                return response.json();
            })
            .then((data) => {
                if (data.success) {
                    showMessage("User deleted successfully.", "alert-success");
                    window.location.href = "/";
                    // Optionally, clear the form or redirect the user
                } else {
                    showMessage("Error deleting user. Please try again later.", "alert-danger");
                }
            })
            .catch((error) => {
                console.error(
                    "There has been a problem with your fetch operation:",
                    error
                );
            });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const signupForm = document.getElementById("signupForm");
    signupForm.addEventListener("submit", function (event) {
        var recaptcha = grecaptcha.getResponse();
        if (recaptcha === "") { // if the reCAPTCHA is not completed
            event.preventDefault(); // prevent the form from being submitted
            alert("Please complete the reCAPTCHA.");
            // exit the event handler
        }

        // ... rest of your code ...
    });
});

