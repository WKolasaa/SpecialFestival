window.onload = showRestaurants;

function showRestaurants() {
    hideAll();
    document.getElementById('restaurantsContainer').style.display = "block";
    updateButton('restaurant');
    displayRestaurants();
}

function showSessions() {
    hideAll();
    document.getElementById('sessionContainer').style.display = "block";
    updateButton('session');
    restaurantNamesToComboBox();

}

function showImages() {
    hideAll();
    document.getElementById('imagesContainer').style.display = "block";
    updateButton('image');
}

function showReservations() {
    hideAll();
    document.getElementById('reservationsContainer').style.display = "block";
    updateButton('reservation');
    fetchReservations();
}

function hideAll() {
    document.getElementById('restaurantsContainer').style.display = "none";
    document.getElementById('sessionContainer').style.display = "none";
    document.getElementById('imagesContainer').style.display = "none";
    document.getElementById('reservationsContainer').style.display = "none";
    document.getElementById('sessions').innerHTML = '';
}

function updateButton(action) {
    const sessionButton = document.getElementById('sessionButton');
    switch (action) {
        case 'restaurant':
            sessionButton.textContent = 'Add Restaurant';
            sessionButton.onclick = createAddRestaurantForm;
            break;
        case 'session':
            sessionButton.textContent = 'Add Session';
            sessionButton.onclick = createAddSessionForm;
            break;
        case 'image':
            sessionButton.textContent = 'Add Image';
            sessionButton.onclick = createAddRestaurantForm;
            break;
        case 'reservation':
            sessionButton.textContent = 'Add Reservation';
            sessionButton.onclick = createAddReservationForm;
            break;
        default:
            console.error('Invalid action');
    }
}

function fetchRestaurantsReturn() {
    return fetch('/api/YummyAdmin/getAllRestaurants')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            return data;
        })
        .catch(error => {
            console.error('Error fetching restaurants:', error);
            throw error; // Re-throw the error to be caught by the caller
        });
}

function displayRestaurants() {
    fetchRestaurantsReturn()
        .then(data => {
            // Clear previous data
            const restaurantsContainer = document.getElementById('restaurantsContainer');
            restaurantsContainer.innerHTML = ''; // Clear existing content
            restaurantsContainer.classList.add('container'); // Add Bootstrap container class

            const heading = document.createElement('h2');
            heading.textContent = 'Restaurants'; // Set the heading text
            heading.classList.add('my-3'); // Add Bootstrap margin class
            restaurantsContainer.appendChild(heading);

            // Populate the container with restaurant data
            data.forEach(restaurant => {
                const restaurantItem = document.createElement('div');
                restaurantItem.classList.add('restaurant', 'mb-3'); // Add Bootstrap classes

                restaurantItem.innerHTML = `
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title"><span contenteditable="false" id="restaurant-id-${restaurant.id}">Restaurant ID: ${restaurant.id}</span></h5>
                            <p class="card-text">
                                Restaurant Name: <span contenteditable="true" id="restaurant-name-${restaurant.id}">${restaurant.name}</span><br>
                                Restaurant Address: <span contenteditable="true" id="restaurant-address-${restaurant.id}">${restaurant.address}</span><br>
                                Restaurant Type: <span contenteditable="true" id="restaurant-type-${restaurant.id}">${restaurant.type}</span><br>
                                Restaurant Price: <span contenteditable="true" id="restaurant-price-${restaurant.id}">${restaurant.price}</span><br>
                                Restaurant Reduced Price: <span contenteditable="true" id="restaurant-reduced-${restaurant.id}">${restaurant.reduced}</span><br>
                                Restaurant Stars: <span contenteditable="true" id="restaurant-stars-${restaurant.id}">${restaurant.stars}</span> <br>
                                Restaurant Phone Number: <span contenteditable="true" id="restaurant-phone-${restaurant.id}">${restaurant.phoneNumber}</span><br>
                                Restaurant Email Address: <span contenteditable="true" id="restaurant-email-${restaurant.id}">${restaurant.email}</span><br>
                                Restaurant Website: <span contenteditable="true" id="restaurant-website-${restaurant.id}">${restaurant.website}</span><br>
                                Restaurant Chef: <span contenteditable="true" id="restaurant-chef-${restaurant.id}">${restaurant.chef}</span><br>
                            </p>
                            <button class="btn btn-success btnTicket" onclick="updateRestaurant(${restaurant.id})">Save</button>
                            <button class="btn btn-danger btnTicket" onclick="deleteRestaurant(${restaurant.id})">Delete</button>
                        </div>
                    </div>
                `;
                restaurantsContainer.appendChild(restaurantItem);
            });
        })
        .catch(error => console.error('Error while displaying restaurants:', error));
}

function updateRestaurant(restaurantId) {
    const restaurant = {
        id: restaurantId,
        name: document.getElementById(`restaurant-name-${restaurantId}`).textContent,
        address: document.getElementById(`restaurant-address-${restaurantId}`).textContent,
        type: document.getElementById(`restaurant-type-${restaurantId}`).textContent,
        price: document.getElementById(`restaurant-price-${restaurantId}`).textContent,
        reduced: document.getElementById(`restaurant-reduced-${restaurantId}`).textContent,
        stars: document.getElementById(`restaurant-stars-${restaurantId}`).textContent,
        phoneNumber: document.getElementById(`restaurant-phone-${restaurantId}`).textContent,
        email: document.getElementById(`restaurant-email-${restaurantId}`).textContent,
        website: document.getElementById(`restaurant-website-${restaurantId}`).textContent,
        chef: document.getElementById(`restaurant-chef-${restaurantId}`).textContent
    };
    console.log(restaurant);
    fetch('/api/YummyAdmin/updateRestaurant', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(restaurant)
    })
        .then(response => {
            if (response.ok) {
                showToast('Restaurant updated successfully', 'green');
                showRestaurants();
            } else {
                showToast('Error updating restaurant:', 'red');
            }
        })
        .catch(error => alert('Error updating restaurant:', error));

}


function deleteRestaurant(restaurantId) { //TODO: Finish it (only url here was pasted). Do it when add works properly
    if (confirm('Are you sure you want to delete this restaurant?')) {
        fetch('/api/YummyAdmin/deleteRestaurant', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({restaurantId: restaurantId})
        })
            .then(response => {
                if (response.ok) {
                    showToast('Restaurant deleted successfully', 'green');
                    showRestaurants();
                } else {
                    console.error('Error deleting restaurant:', response.statusText);
                }
            })
            .catch(error => console.error('Error deleting restaurant:', error));
    }
}


let nameArray = [];
let selectedRestaurantId = 0;

// metod to add restaurant names to combobox in session
function restaurantNamesToComboBox() {
    fetchRestaurantsReturn()
        .then(restaurants => {
            const restaurantSelect = document.getElementById('restaurantList');
            restaurantSelect.innerHTML = '';
            console.log(restaurants);
            nameArray = restaurants;
            restaurants.forEach(restaurant => {
                const optionText = `<option value="${restaurant.id}">${restaurant.name}</option>`;
                restaurantSelect.innerHTML += optionText
            });

            // Get the selected restaurant ID
            selectedRestaurantId = restaurantSelect.value;

            // Call fetchRestaurantDays with the selected restaurant ID
            //fetchRestaurantDays(selectedRestaurantId);
            fetchRestaurantSessions(1);
        })
        .catch(error => console.error('Error fetching restaurants:', error));
}

function fetchRestaurantSessions(restaurantId) {
    let apiUrl = '';

    // Check if restaurantId is null or undefined
    if (restaurantId === null || restaurantId === undefined) {
        // If restaurantId is null or undefined, fetch data from a different API endpoint
        apiUrl = '/api/YummyAdmin/getAllRestaurantsEvents';
    } else {
        // If restaurantId is set, fetch data from the specified API endpoint
        apiUrl = '/api/YummyAdmin/getRestaurantsEventsById';
    }

    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({restaurantId: restaurantId})
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            displayEditSessionForm(data);
        })
        .catch(error => console.error('Error fetching sessions:', error));
}

document.getElementById('restaurantImages').addEventListener('change', function () {
    selectedRestaurantId = this.value;
    console.log("Works");
    displayImages(this.value);
});


// Add event listener for selection change
document.getElementById('restaurantList').addEventListener('change', function () {
    console.log("Works");
    selectedRestaurantId = this.value;
    const selectedRestaurant = nameArray.find(restaurant => restaurant.id == selectedRestaurantId);
    if (selectedRestaurant) {
        fetchRestaurantSessions(selectedRestaurantId);
    } else {
        console.error('Selected restaurant not found');
    }
});

function displayEditSessionForm(events) {
    const sessionContainer = document.getElementById('sessions');
    sessionContainer.innerHTML = ''; // Clear existing content
    sessionContainer.classList.add('container'); // Add Bootstrap container class

    const heading = document.createElement('h2');
    heading.textContent = 'Sessions'; // Set the heading text
    heading.classList.add('my-3'); // Add Bootstrap margin class
    sessionContainer.appendChild(heading);

    console.log(events);
    events.forEach(event => {
        const eventItem = document.createElement('div');
        eventItem.classList.add('session', 'mb-3'); // Use the same custom class as for tickets

        eventItem.innerHTML = `
            <div class="card-body">
            <h5 class="card-title"><span contenteditable="false" id="event-id-${event.id}">Session ID: ${event.id}</span></h5>
            <p class="card-text">
                Restaurant ID: <span contenteditable="true" id="restaurant-id-${event.id}">${event.restaurant_id}</span><br>
                Event Date: <input type="date" id="event-date-${event.id}" value="${event.event_date}"><br>
                Event day: <span contenteditable="true" id="event-day-${event.id}">${event.event_day}</span><br>
                Event Start Time: <input type="time" id="event-time-start-${event.id}" value="${event.event_time_start}"><br>
                Event End Time: <input type="time" id="event-time-end-${event.id}" value="${event.event_time_end}"><br>
                Event seats: <span contenteditable="true" id="event-seats-total-${event.id}">${event.seats_total}</span> <br>
                Event seats left: <span contenteditable="true" id="event-seats-left-${event.id}">${event.seats_left}</span><br><br>
            </p>
            <button class="btn btn-success btnTicket" onclick="saveSession(${event.id})">Save</button>
            <button class="btn btn-danger btnTicket" onclick="removeSession(${event.id})">Delete</button>
            </div>
        `;


        sessionContainer.appendChild(eventItem);
    });
}

function saveSession(eventId) {
    const restaurantIdElement = document.getElementById(`restaurant-id-${eventId}`);
    let restaurantId = restaurantIdElement.textContent.trim();
    if (restaurantId.startsWith("Restaurant ID: ")) {
        restaurantId = restaurantId.replace("Restaurant ID: ", "");
    }
    //console.log('Restaurant ID:', restaurantId);

    const event = {
        id: eventId,
        restaurant_id: restaurantId,
        event_date: document.getElementById(`event-date-${eventId}`).value,
        event_day: document.getElementById(`event-day-${eventId}`).textContent,
        event_time_start: document.getElementById(`event-time-start-${eventId}`).value,
        event_time_end: document.getElementById(`event-time-end-${eventId}`).value,
        seats_total: document.getElementById(`event-seats-total-${eventId}`).textContent,
        seats_left: document.getElementById(`event-seats-left-${eventId}`).textContent
    };

    fetch('/api/YummyAdmin/updateEvent', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(event)
    })
        .then(response => {
            if (response.ok) {
                showToast('Session updated successfully', 'green');
                showSessions();
            } else {
                showToast('Error updating session:', 'red');
            }
        })
        .catch(error => alert('Error updating session:', error));
}

function removeSession(eventId) { //TODO: Change method to remove
    if (confirm('Are you sure you want to delete this session?')) {
        fetch('/api/YummyAdmin/deleteSession', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({eventId: eventId})
        })
            .then(response => {
                if (response.ok) {
                    // Refresh the session list after deletion
                    showToast('Session deleted successfully', 'green');
                    showSessions();
                } else {
                    console.error('Error deleting session:', response.statusText);
                }
            })
            .catch(error => console.error('Error deleting session:', error));
    }

}

function createAddRestaurantForm() {
    document.getElementById('restaurantsContainer').innerHTML = `
        <div class="container">
            <div class="row">
                <div class="col-md-6 offset-md-3">
                    <div class="card center-card">
                        <div class="card-body">
                            <h2 class="card-title text-center">Add Restaurant</h2>
                            <form>
                                <div class="form-group">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name-addRestaurant" name="name" placeholder="Enter restaurant name">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address-addRestaurant" name="address" placeholder="Enter address">
                                </div>
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <input type="text" class="form-control" id="type-addRestaurant" name="type" placeholder="Enter type">
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="text" class="form-control" id="price-addRestaurant" name="price" pattern="[0-9]*" inputmode="numeric" placeholder="0.00">
                                </div>
                                <div class="form-group">
                                    <label for="reducedPrice">Reduced Price</label>
                                    <input type="text" class="form-control" id="reducedPrice-addRestaurant" name="reducedPrice" pattern="[0-9]*" inputmode="numeric" placeholder="0.00">
                                </div>
                                <div class="form-group">
                                    <label for="stars">Stars</label>
                                    <input type="number" class="form-control" id="stars-addRestaurant" name="stars" placeholder="Enter stars">
                                </div>
                                <div class="form-group">
                                    <label for="phoneNumber">Phone number</label>
                                    <input type="text" class="form-control" id="phoneNumber-addRestaurant" name="phoneNumber" placeholder="Enter Phone Number">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email-addRestaurant" name="email" placeholder="Enter Phone Number">
                                </div>
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input type="text" class="form-control" id="website-addRestaurant" name="website" placeholder="Enter Website">
                                </div>
                                <div class="form-group">
                                    <label for="Chef">Chef</label>
                                    <input type="text" class="form-control" id="Chef-addRestaurant" name="Chef" placeholder="Enter Chef's Name">
                                </div>
                                <br>
                                <button type="button" name="addRestaurant" class="btn btn-primary btn-block" onclick="addingRestaurant()">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function addingRestaurant() { //TODO: Find here is a problem here (console says that this method doesnt exist)
    const restaurant = {
        name: document.getElementById('name-addRestaurant').textContent,
        address: document.getElementById('address-addRestaurant').textContent,
        type: document.getElementById('type-addRestaurant').textContent,
        price: document.getElementById('price-addRestaurant').textContent,
        reduced: document.getElementById('reducedPrice-addRestaurant').textContent,
        stars: document.getElementById('stars-addRestaurant').textContent,
        phoneNumber: document.getElementById('phoneNumber-addRestaurant').textContent,
        email: document.getElementById('email-addRestaurant').textContent,
        website: document.getElementById('website-addRestaurant').textContent,
        chef: document.getElementById('Chef-addRestaurant').textContent
    };

    fetch('/api/YummyAdmin/addRestaurant', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(restaurant)
    })
        .then(response => {
            if (response.ok) {
                showToast('Restaurant added successfully', 'green');
                showRestaurants();
            } else {
                alert('Error adding restaurant:', response.statusText);
            }
        })
        .catch(error => alert('Error adding restaurant:', error));
}

function createAddSessionForm() {
    // Get the container element where the form will be appended
    const sessionContainer = document.getElementById('sessionContainer');
    document.getElementById('sessions').innerHTML = '';

    // Clear previous content
    sessionContainer.innerHTML = '';

    // Fetch restaurants
    fetchRestaurantsReturn()
        .then(restaurants => {
            // Create a Bootstrap card element
            const card = document.createElement('div');
            card.classList.add('card');

            // Create a card body
            const cardBody = document.createElement('div');
            cardBody.classList.add('card-body');

            // Create the form element
            const form = document.createElement('form');

            // Create restaurant select dropdown
            const restaurantLabel = document.createElement('label');
            restaurantLabel.textContent = 'Select Restaurant:';
            form.appendChild(restaurantLabel);

            const restaurantSelect = document.createElement('select');
            restaurantSelect.classList.add('form-control');
            restaurantSelect.setAttribute('name', 'restaurant');
            restaurants.forEach(restaurant => {
                const option = document.createElement('option');
                option.value = restaurant.id;
                option.textContent = restaurant.name;
                restaurantSelect.appendChild(option);
            });
            form.appendChild(restaurantSelect);

            // Create input fields for event date, event day, event start time, event end time, event seats total, and event seats available
            const fields = [
                {label: 'Event Date (DD/MM/YYYY):', type: 'text', name: 'eventDate', id: 'eventDate-addSession'},
                {label: 'Event Day:', type: 'text', name: 'eventDay', id: 'eventDay-addSession'},
                {label: 'Event Start Time (24h):', type: 'text', name: 'eventStartTime', id: 'eventStartTime-addSession'},
                {label: 'Event End Time (24h):', type: 'text', name: 'eventEndTime', id: 'eventEndTime-addSession'},
                {label: 'Event Seats Total:', type: 'number', name: 'eventSeatsTotal', id: 'eventSeatsTotal-addSession'},
                {label: 'Event Seats Available:', type: 'number', name: 'eventSeatsAvailable', id: 'eventSeatsAvailable-addSession'}
            ];

            fields.forEach(field => {
                const div = document.createElement('div');
                div.classList.add('form-group');

                const fieldLabel = document.createElement('label');
                fieldLabel.textContent = field.label;
                div.appendChild(fieldLabel);

                const input = document.createElement('input');
                input.classList.add('form-control');
                input.setAttribute('type', field.type);
                input.setAttribute('name', field.name);
                input.setAttribute('id', field.id); // Ensure the id is set
                // Additional attributes for custom date and time formats
                if (field.name === 'eventDate') {
                    input.setAttribute('placeholder', 'DD/MM/YYYY');
                } else if (field.type === 'text') {
                    input.setAttribute('placeholder', 'HH:mm');
                }
                div.appendChild(input);

                form.appendChild(div);
            });

            // Create a submit button
            const submitButton = document.createElement('button');
            submitButton.setAttribute('type', 'button');
            submitButton.classList.add('btn', 'btn-primary', 'mt-3');
            submitButton.textContent = 'Submit';
            form.appendChild(submitButton);

            // Add event listener to the submit button
            submitButton.addEventListener('click', () => {
                // Collect form data
                const sessionData = {
                    restaurantId: document.querySelector('[name="restaurant"]').value,
                    eventDate: document.getElementById('eventDate-addSession').value,
                    eventDay: document.getElementById('eventDay-addSession').value,
                    eventStartTime: document.getElementById('eventStartTime-addSession').value,
                    eventEndTime: document.getElementById('eventEndTime-addSession').value,
                    eventSeatsTotal: document.getElementById('eventSeatsTotal-addSession').value,
                    eventSeatsAvailable: document.getElementById('eventSeatsAvailable-addSession').value
                };

                // Call addSession method with the collected data
                addSession(sessionData);
            });

            // Append the form to the card body
            cardBody.appendChild(form);

            // Append the card body to the card
            card.appendChild(cardBody);

            // Append the card to the container
            sessionContainer.appendChild(card);
        })
        .catch(error => {
            console.error('Error fetching restaurants:', error);
        });
}


function addSession(session) {
    if(checkSessionData(session)) {
        fetch('/api/YummyAdmin/addSession', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(session)
        })
            .then(response => {
                if (response.ok) {
                    showToast('Session added successfully', 'green');
                    showRestaurants();
                } else {
                    throw new Error('Error adding session:', response.statusText);
                }
            })
            .catch(error => showToast(error, 'red'));
    }
}

function checkSessionData(session) {
    var checked = true;
    for (let key in session) {
        if (session[key] === '' || session[key] === null) {
            showToast(`Please fill in the ${key.replace(/([A-Z])/g, ' $1').toLowerCase()}.`, "red");
            return;
            checked = false;
        }
    }

    // Validate that seats are not negative
    if (session.eventSeatsTotal < 0) {
        showToast('Event Seats Total cannot be a negative value.', 'red');
        return;
        checked = false;
    }
    if (session.eventSeatsAvailable < 0) {
        showToast('Event Seats Available cannot be a negative value.', 'red');
        return;
        checked = false;
    }
    if(session.eventSeatsAvailable > session.eventSeatsTotal) {
        showToast('Event Seats Available cannot be greater than Event Seats Total.', 'red');
        return;
        checked = false;
    }

    return checked;
}

function displayImages(restaurantID) {
    fetch('/api/YummyAdmin/getAllImagesByRestaurantId', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({restaurantId: restaurantID})
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(images => {
            console.log(images);
            const imagesContainer = document.getElementById('imageContainer');
            imagesContainer.innerHTML = '';

            imagesContainer.style.display = 'flex';
            imagesContainer.style.flexDirection = 'column';
            imagesContainer.style.justifyContent = 'center';
            imagesContainer.style.alignItems = 'center';

            // Define an object to store images by type
            const imageTypes = {};

            // Group images by type
            images.forEach(image => {
                if (!imageTypes.hasOwnProperty(image.imageType)) {
                    imageTypes[image.imageType] = [];
                }
                imageTypes[image.imageType].push({id: image.id, path: image.imagePath});
            });

            // Create image containers for each type
            for (const imageType in imageTypes) {
                if (imageTypes.hasOwnProperty(imageType)) {
                    const imagePaths = imageTypes[imageType];
                    let imageContainer;
                    if (imageType === 'gallery') {
                        const galleryImages = imagePaths.slice(0, 5); // Display up to 5 gallery images
                        for (let i = 0; i < 5; i++) {
                            const imageData = galleryImages[i] || {id: '', path: ''}; // Use empty object if no image at index i
                            imageContainer = createImageInputContainer(`Gallery ${i + 1}`, imageData.path, imageData.id);
                            imagesContainer.appendChild(imageContainer);
                        }
                    } else {
                        // For map and chef images, display only one image
                        const imageData = imagePaths.length > 0 ? imagePaths[0] : {id: '', path: ''};
                        imageContainer = createImageInputContainer(imageType, imageData.path, imageData.id);
                        imagesContainer.appendChild(imageContainer);
                    }
                }
            }
        })
        .catch(error => console.error('Error updating images:', error));
}

function createImageInputContainer(type, imageUrl, id) {
    const container = document.createElement('div');
    container.classList.add('image-container');

    const inputWrapper = document.createElement('div');
    inputWrapper.classList.add('input-wrapper');

    // Display the ID along with the type
    const label = document.createElement('label');
    label.textContent = `ID: ${id} | Type: ${type}`;
    inputWrapper.appendChild(label);

    const imageInput = document.createElement('input');
    imageInput.setAttribute('type', 'file');
    imageInput.setAttribute('accept', 'image/*');
    imageInput.setAttribute('data-type', type);
    imageInput.setAttribute('id', `image-input-${id}`); // Set the input's id attribute with the image ID

    inputWrapper.appendChild(imageInput);

    const imagePreview = document.createElement('img');
    imagePreview.classList.add('image-preview');
    imagePreview.setAttribute('src', imageUrl);

    // Apply CSS styles to make the images smaller
    imagePreview.style.maxWidth = '200px'; // Adjust the maximum width as needed
    imagePreview.style.maxHeight = '200px'; // Adjust the maximum height as needed
    imagePreview.style.paddingBottom = '10px'; // Add padding to separate images

    inputWrapper.appendChild(imagePreview);

    // Create an "Update" button
    const updateButton = document.createElement('button');
    updateButton.textContent = 'Update';
    updateButton.classList.add('btn', 'btn-primary');
    // Use a closure to pass the ID to the update method
    updateButton.onclick = function () {
        const imageInput = document.getElementById(`image-input-${id}`); // Get the input box using the stored ID
        updateImages(id, imageInput); // Call the update method with the ID and the input element
    };
    inputWrapper.appendChild(updateButton);

    container.appendChild(inputWrapper);

    return container;
}


function updateImages(id, imageInput) {
    if (imageInput.files.length > 0) {
        const imageFile = imageInput.files[0];

        // Create a FormData object to send the image file
        const formData = new FormData();
        formData.append('image', imageFile);
        formData.append('id', id);

        console.log(formData.get('id'), formData.get('image'));

        fetch(`/api/YummyAdmin/updateImage`, {
            method: 'POST',
            body: formData,
        })
            .then((response) => {
                if (response.ok) {
                    console.log("Overview deleted successfully");
                    //  loadOverviews(); // Reload overviews to reflect changes
                } else {
                    throw new Error("Failed to delete overview");
                }
            })
            .catch(error => alert('Error updating image:', error));
    } else {
        alert('Please select an image to update');
    }
}

function fetchReservations() {
    fetch('/api/YummyAdmin/getAllReservations')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            displayReservations(data);
        })
        .catch(error => console.error('Error fetching reservations:', error));
}

function displayReservations(data) {
    const reservationContainer = document.getElementById('reservationsContainer');
    reservationContainer.innerHTML = ''; // Clear existing content
    reservationContainer.classList.add('container'); // Add Bootstrap container class

    const heading = document.createElement('h2');
    heading.textContent = 'Reservations'; // Set the heading text
    heading.classList.add('my-3'); // Add Bootstrap margin class
    reservationContainer.appendChild(heading);

    console.log(data);
    data.forEach(reservation => {
        const eventItem = document.createElement('div');
        eventItem.classList.add('reservation', 'mb-3'); // Use the same custom class as for tickets

        eventItem.innerHTML = `
           <div class="card-body">
           <h5 class="card-title"><span contenteditable="false" id="reservation-id-${reservation.id}">Reservation ID: ${reservation.id}</span></h5>
           <p class="card-text">
                Restaurant ID: <span contenteditable="true" id="reservation-restaurant-id-${reservation.id}">${reservation.restaurantId}</span><br>
                Event ID: <span contenteditable="true" id="reservation-event-ID-${reservation.id}">${reservation.eventID}</span><br>
                Date: <input type="date" id="reservation-date-${reservation.id}" value="${reservation.date}"><br>
                Start Time: <input type="time" id="reservation-start-time-${reservation.id}" value="${reservation.startTime}"><br>
                End Time: <input type="time" id="reservation-end-time-${reservation.id}" value="${reservation.endTime}"><br>
                Reqular Tickets: <span contenteditable="true" id="reservation-regular-tickets-${reservation.id}">${reservation.regularTickets}</span><br>
                Reduced Tickets: <span contenteditable="true" id="reservation-reduced-tickets-${reservation.id}">${reservation.reducedTickets}</span> <br>
                Special Requests: <span contenteditable="true" id="reservation-special-requests-${reservation.id}">${reservation.specialRequests}</span><br>
                Enabled: <input type="checkbox" id="reservation-enabled-${reservation.id}" ${reservation.enabled ? 'checked' : ''}><br><br>
           </p>
           <button class="btn btn-success btnTicket" onclick="saveReservation(${reservation.id})">Save</button>
           <button class="btn btn-danger btnTicket" onclick="removeReservation(${reservation.id})">Delete</button>
           </div>
        `;


        reservationContainer.appendChild(eventItem);
    });
}

function saveReservation(id) {
    const reservation = {
        id: id,
        restaurantId: document.getElementById(`reservation-restaurant-id-${id}`).textContent,
        eventId: document.getElementById(`reservation-event-ID-${id}`).textContent,
        date: document.getElementById(`reservation-date-${id}`).textContent,
        startTime: document.getElementById(`reservation-start-time-${id}`).textContent,
        endTime: document.getElementById(`reservation-end-time-${id}`).textContent,
        regularTickets: document.getElementById(`reservation-regular-tickets-${id}`).textContent,
        reducedTickets: document.getElementById(`reservation-reduced-tickets-${id}`).textContent,
        specialRequests: document.getElementById(`reservation-special-requests-${id}`).textContent,
        enabled: document.getElementById(`reservation-enabled-${id}`).checked
    };

    console.log(reservation);

    fetch('/api/YummyAdmin/updateReservation', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(reservation)
    })
        .then(response => {
            if (response.ok) {
                showToast('Reservation updated successfully', 'green');
                showReservations();
            } else {
                alert('Error updating reservation:', response.statusText);
            }
        })
        .catch(error => alert('Error updating reservation:', error));
}

function removeReservation(id) { //TODO: Finish this method
    if (confirm('Are you sure you want to delete this reservation?')) {
        fetch('/api/YummyAdmin/deleteReservation', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({reservationId: id})
        })
            .then(response => {
                if (response.ok) {
                    showToast('Reservation deleted successfully', 'green');
                    showReservations();
                } else {
                    console.error('Error deleting reservation:', response.statusText);
                }
            })
            .catch(error => console.error('Error deleting reservation:', error));
    }
}

function createAddReservationForm() {
    hideAll();
    document.getElementById('addReservationContainer').style.display = "block";
    document.getElementById('addReservationContainer').innerHTML = `
        <form>
            <div class="form-group">
                <label for="restaurantId-Reservation">Restaurant ID:</label>
                <input type="number" class="form-control" id="restaurantId-Reservation" name="restaurantId-Reservation" required>
            </div>
            <div class="form-group">
                <label for="eventID-Reservation">Event ID:</label>
                <input type="number" class="form-control" id="eventID-Reservation" name="eventID-Reservation" required>
            </div>
            <div class="form-group">
                <label for="regularTickets-Reservation">Regular Tickets:</label>
                <input type="number" class="form-control" id="regularTickets-Reservation" name="regularTickets-Reservation" required>
            </div>
            <div class="form-group">
                 <label for="reducedTickets-Reservation">Reduced Tickets:</label>
                 <input type="number" class="form-control" id="reducedTickets-Reservation" name="reducedTickets-Reservation">
            </div>
            <div class="form-group">
                 <label for="specialRequests-Reservation">Special Requests:</label>
                 <textarea class="form-control" id="specialRequests-Reservation" name="specialRequests-Reservation"></textarea>
            </div>
            <button type="button" class="btn btn-primary" onclick="addReservation()">Submit</button>
        </form>
    `;
}

function addReservation() {
    const reservation = {
        restaurantId: document.getElementById('restaurantId-Reservation').value,
        eventID: document.getElementById('eventID-Reservation').value,
        regularTickets: document.getElementById('regularTickets-Reservation').value,
        reducedTickets: document.getElementById('reducedTickets-Reservation').value,
        specialRequests: document.getElementById('specialRequests-Reservation').value
    };

    fetch('/api/YummyAdmin/addReservation', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(reservation)
    })
        .then(response => {
            if (response.ok) {
                showToast('Reservation added successfully', 'green');
                showReservations();
            } else {
                alert('Error adding reservation:', response.statusText);
            }
            document.getElementById('addReservationContainer').style.display = "none";
        })
        .catch(error => alert('Error adding reservation:', error));
}


