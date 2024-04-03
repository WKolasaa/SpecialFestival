window.onload = showRestaurants;

function showRestaurants(){
    document.getElementById('restaurantsContainer').style.display = "block";
    document.getElementById('sessionContainer').style.display = "none";
    document.getElementById('imagesContainer').style.display = "none";
    document.getElementById('sessions').innerHTML = '';
    updateButton('restaurant');
    displayRestaurants();
}

function showSessions(){
    document.getElementById('restaurantsContainer').style.display = "none";
    document.getElementById('sessionContainer').style.display = "block";
    document.getElementById('imagesContainer').style.display = "none";
    updateButton('session');
    restaurantNamesToComboBox();

}

function showImages(){
    document.getElementById('restaurantsContainer').style.display = "none";
    document.getElementById('sessionContainer').style.display = "none";
    document.getElementById('sessions').innerHTML = '';
    document.getElementById('imagesContainer').style.display = "block";
    updateButton('image');
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
        default:
            console.error('Invalid action');
    }
}

function fetchRestaurantsReturn() {
    return fetch('http://localhost/api/yummyadmin/getAllRestaurants')
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
    fetch('http://localhost/api/yummyadmin/updateRestaurant', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(restaurant)
    })
        .then(response => {
            if (response.ok) {
                alert('Restaurant updated! successfully');
                showRestaurants();
            } else {
                alert('Error updating restaurant:', response.statusText);
            }
        })
        .catch(error => alert('Error updating restaurant:', error));

}


function deleteRestaurant(restaurantId) { //TODO: Finish it (only url here was pasted). Do it when add works properly
    if (confirm('Are you sure you want to delete this restaurant?')) {
        fetch('http://localhost/api/yummyadmin/deleteRestaurant', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ restaurantId: restaurantId })
        })
            .then(response => {
                if (response.ok) {
                    alert('Restaurant deleted successfully');
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
        apiUrl = 'http://localhost/api/yummyadmin/getAllRestaurantsEvents';
    } else {
        // If restaurantId is set, fetch data from the specified API endpoint
        apiUrl = 'http://localhost/api/yummyadmin/getRestaurantsEventsById';
    }

    fetch(apiUrl, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ restaurantId: restaurantId })
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

document.getElementById('restaurantImages').addEventListener('change', function() {
    selectedRestaurantId = this.value;
    console.log("Works");
    displayImages(this.value);
});


// Add event listener for selection change
document.getElementById('restaurantList').addEventListener('change', function() {
    console.log("Works");
    selectedRestaurantId = this.value;
    const selectedRestaurant = nameArray.find(restaurant => restaurant.id == selectedRestaurantId);
    if (selectedRestaurant) {
        fetchRestaurantSessions(selectedRestaurantId);
    } else {
        console.error('Selected restaurant not found');
    }
});

function displayEditSessionForm(events){
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
                Event Date: <span contenteditable="true" id="event-date-${event.id}">${event.event_date}</span><br>
                Event day: <span contenteditable="true" id="event-day-${event.id}">${event.event_day}</span><br>
                Event start time: <span contenteditable="true" id="event-time-start-${event.id}">${event.event_time_start}</span><br>
                Event end time: <span contenteditable="true" id="event-time-end-${event.id}">${event.event_time_end}</span><br>
                Event seats total: <span contenteditable="true" id="event-seats-total-${event.id}">${event.seats_total}</span> <br>
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
     const event= {
         id: eventId,
         restaurant_id: document.getElementById(`restaurant-id-${eventId}`).textContent,
         event_date: document.getElementById(`event-date-${eventId}`).textContent,
         event_day: document.getElementById(`event-day-${eventId}`).textContent,
         event_time_start: document.getElementById(`event-time-start-${eventId}`).textContent,
         event_time_end: document.getElementById(`event-time-end-${eventId}`).textContent,
         seats_total: document.getElementById(`event-seats-total-${eventId}`).textContent,
         seats_left: document.getElementById(`event-seats-left-${eventId}`).textContent
     };

     fetch('http://localhost/api/yummyadmin/updateEvent', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify(event)
        })
         .then(response => {
             if (response.ok) {
                 alert('Session updated successfully');
                 showSessions();
             } else {
                 alert('Error updating session:', response.statusText);
             }
         })
         .catch(error => alert('Error updating session:', error));
 }

 function removeSession(eventId) { //TODO: Change method to remove
        if (confirm('Are you sure you want to delete this session?')) {
            fetch('http://localhost/api/yummyadmin/deleteSession', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ eventId: eventId })
            })
                .then(response => {
                    if (response.ok) {
                        // Refresh the session list after deletion
                        alert('Session removed successfully');
                        showSessions();
                    } else {
                        console.error('Error deleting session:', response.statusText);
                    }
                })
                .catch(error => console.error('Error deleting session:', error));
        }

 }

function createAddRestaurantForm(){
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
                                <button type="button" name="addRestaurant" class="btn btn-primary btn-block" onclick="addRestaurant()">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function addRestaurant(){ //TODO: Find here is a problem here (console says that this method doesnt exist)
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

    fetch('http://localhost/api/yummyadmin/addRestaurant', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(restaurant)
    })
        .then(response => {
            if (response.ok) {
                alert('Restaurant added successfully');
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
            form.setAttribute('method', 'POST');
            form.setAttribute('action', '/add/session'); // Adjust the action attribute as needed

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
                { label: 'Event Date (DD/MM/YYYY):', type: 'text', name: 'eventDate', id: 'eventDate-addSession' },
                { label: 'Event Day:', type: 'text', name: 'eventDay', id: 'eventDay-addSession'},
                { label: 'Event Start Time (24h):', type: 'text', name: 'eventStartTime', id: 'eventStartTime-addSession' },
                { label: 'Event End Time (24h):', type: 'text', name: 'eventEndTime', id: 'eventEndTime-addSession'},
                { label: 'Event Seats Total:', type: 'number', name: 'eventSeatsTotal', id: 'eventSeatsTotal-addSession'},
                { label: 'Event Seats Available:', type: 'number', name: 'eventSeatsAvailable', id: 'eventSeatsAvailable-addSession'}
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
            submitButton.setAttribute('type', 'submit');
            submitButton.classList.add('btn', 'btn-primary', 'mt-3');
            submitButton.textContent = 'Submit';
            form.appendChild(submitButton);

            // Add event listener to the submit button
            submitButton.addEventListener('click', addSession);

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


function addSession(){ //TODO: finish this method cos it goes to weird page
const session = {
        restaurant_id: document.getElementById('restaurantList').value,
        event_date: document.getElementById('eventDate-addSession').textContent,
        event_day: document.getElementById('eventDay-addSession').textContent,
        event_time_start: document.getElementById('eventStartTime-addSession').textContent,
        event_time_end: document.getElementById('eventEndTime-addSession').textContent,
        seats_total: document.getElementById('eventSeatsTotal-addSession').textContent,
        seats_left: document.getElementById('eventSeatsAvailable-addSession').textContent
    };

    fetch('http://localhost/api/yummyadmin/addSession', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(session)
    })
        .then(response => {
            if (response.ok) {
                alert('Session added successfully');
                showSessions();
            } else {
                alert('Error adding session:', response.statusText);
            }
        })
        .catch(error => alert('Error adding session:', error));
}

function displayImages(restaurantID) {
    fetch('http://localhost/api/yummyadmin/getAllImagesByRestaurantId', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ restaurantId: restaurantID })
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

            // Map image
            const mapImageContainer = createImageInputContainer('Map', images.map);
            imagesContainer.appendChild(mapImageContainer);

            // Chef image
            const chefImageContainer = createImageInputContainer('Chef', images.chef);
            imagesContainer.appendChild(chefImageContainer);

            // Gallery images
            const galleryImages = images.gallery.slice(0, 5);
            for (let i = 0; i < 5; i++) {
                const imageUrl = galleryImages[i] || ''; // Use empty string if no image at index i
                const galleryImageContainer = createImageInputContainer(`Gallery ${i + 1}`, imageUrl);
                imagesContainer.appendChild(galleryImageContainer);
            }
        })
        .catch(error => console.error('Error updating images:', error));
}

function createImageInputContainer(type, imageUrl) {
    const container = document.createElement('div');
    container.classList.add('image-container');

    const typeName = document.createElement('div');
    typeName.textContent = type;
    typeName.classList.add('type-name');
    container.appendChild(typeName);

    const inputWrapper = document.createElement('div');
    inputWrapper.classList.add('input-wrapper');

    const imageInput = document.createElement('input');
    imageInput.setAttribute('type', 'file');
    imageInput.setAttribute('accept', 'image/*');
    imageInput.setAttribute('data-type', type);

    inputWrapper.appendChild(imageInput);

    const imagePreview = document.createElement('img');
    imagePreview.classList.add('image-preview');
    imagePreview.setAttribute('src', imageUrl);

    imagePreview.style.maxWidth = '200px';
    imagePreview.style.maxHeight = '200px';

    inputWrapper.appendChild(imagePreview);

    container.appendChild(inputWrapper);

    return container;
}

function updateImages(restaurantId){
    const images = {
        map: document.querySelector('.image-container[data-type="Map"] .image-preview').src,
        chef: document.querySelector('.image-container[data-type="Chef"] .image-preview').src,
        gallery: []
    };

    const galleryContainers = document.querySelectorAll('.image-container[data-type^="Gallery"]');
    galleryContainers.forEach(container => {
        images.gallery.push(container.querySelector('.image-preview').src);
    });

    fetch('http://localhost/api/yummyadmin/updateImages', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ restaurantId: restaurantId, images: images })
    })
        .then(response => {
            if (response.ok) {
                alert('Images updated successfully');
                showImages();
            } else {
                alert('Error updating images:', response.statusText);
            }
        })
        .catch(error => alert('Error updating images:', error));
}
