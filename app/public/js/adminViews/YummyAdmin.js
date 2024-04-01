window.onload = showRestaurants;

// Initial fetch of restaurant data when the page loads
function showRestaurants(){
    document.getElementById('restaurantsContainer').style.display = "block";
    document.getElementById('sessionContainer').style.display = "none";
    document.getElementById('imagesContainer').style.display = "none";
    document.getElementById('sessions').innerHTML = '';
    updateButton('restaurant');
    fetchRestaurants();
}

function showSessions(){
    document.getElementById('restaurantsContainer').style.display = "none";
    document.getElementById('sessionContainer').style.display = "none";
    document.getElementById('sessionContainer').style.display = "block";
    document.getElementById('imagesContainer').style.display = "none";
    updateButton('session');
    fetchRestaurantsNames(); //TODO: change those methods

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

function fetchRestaurants() {
    fetch('http://localhost/api/yummyadmin/getAllRestaurants')
        .then(response => response.json())
        .then(data => {
            // Clear previous data
            document.getElementById('restaurantList').innerHTML = '';

            // Populate the table with new data
            data.forEach(restaurant => {
                const row = `
                    <tr>
                        <td>${restaurant.id}</td>
                        <td>${restaurant.name}</td>
                        <td>${restaurant.address}</td>
                        <td>${restaurant.type}</td>
                        <td>${restaurant.price}</td>
                        <td>${restaurant.reduced}</td>
                        <td>${restaurant.stars}</td>
                        <!-- Actions -->
                        <td>
                            <button class="btn btn-sm btn-info" onclick="editRestaurant(${restaurant.id})">Edit</button>
                            <button class="btn btn-sm btn-danger" onclick="deleteRestaurant(${restaurant.id})">Delete</button>
                        </td>
                    </tr>
                `;
                document.getElementById('restaurantList').innerHTML += row;
            });
        })
        .catch(error => console.error('Error fetching restaurants:', error));
}

function editRestaurant(restaurantId) {
    fetch('http://localhost/api/yummyadmin/getRestaurantById', {
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
            createEditRestaurantForm(data);
        })
        .catch(error => console.error('Error fetching sessions:', error));
}

function createEditRestaurantForm(restaurantData) {
    console.log(restaurantData);
    document.getElementById('restaurantsContainer').style.display = 'none';
    const editRestaurantContainer = document.getElementById('editRestaurantContainer');
    editRestaurantContainer.style.display = 'block';
    editRestaurantContainer.innerHTML = `
        <div class="card-container">
            <div class="card">
                <div class="card-body">
                    <h2 class="card-title">Edit Restaurant</h2>
                    <form id="editRestaurantForm">
                        <div class="form-group">
                            <label for="name">Name:</label>
                            <input type="text" class="form-control" id="name" name="name" value="${restaurantData.name}" required>
                        </div>
                        <div class="form-group">
                            <label for="address">Address:</label>
                            <input type="text" class="form-control" id="address" name="address" value="${restaurantData.address}" required>
                        </div>
                        <div class="form-group">
                            <label for="type">Type:</label>
                            <input type="text" class="form-control" id="type" name="type" value="${restaurantData.type}" required>
                        </div>
                        <div class="form-group">
                            <label for="price">Price:</label>
                            <input type="number" class="form-control" id="price" name="price" value="${restaurantData.price}" required>
                        </div>
                        <div class="form-group">
                            <label for="reduced">Reduced Price:</label>
                            <input type="number" class="form-control" id="reduced" name="reduced" value="${restaurantData.reduced}" required>
                        </div>
                        <div class="form-group">
                            <label for="stars">Stars:</label>
                            <input type="number" class="form-control" id="stars" name="stars" value="${restaurantData.stars}" required>
                        </div>
                        <div class="form-group">
                            <label for="phoneNumber">Phone Number:</label>
                            <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" value="${restaurantData.phoneNumber}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email Address:</label>
                            <input type="text" class="form-control" id="email" name="email" value="${restaurantData.email}" required>
                        </div>
                        <div class="form-group">
                            <label for="website">Website:</label>
                            <input type="text" class="form-control" id="website" name="website" value="${restaurantData.website}" required>
                        </div>
                        <div class="form-group">
                            <label for="chef">Chef:</label>
                            <input type="text" class="form-control" id="chef" name="chef" value="${restaurantData.chef}" required>
                        </div>
                        
                        <input type="hidden" id="restaurantId" name="restaurantId" value="${restaurantData.id}">
    
                        <button type="button" class="btn btn-primary" onclick="updateRestaurant()">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    `;
}

function updateRestaurant() {
    const restaurant = {
        id: document.getElementById('restaurantId').value,
        name: document.getElementById('name').value,
        address: document.getElementById('address').value,
        type: document.getElementById('type').value,
        price: document.getElementById('price').value,
        reduced: document.getElementById('reduced').value,
        stars: document.getElementById('stars').value,
        phoneNumber: document.getElementById('phoneNumber').value,
        email: document.getElementById('email').value,
        website: document.getElementById('website').value,
        chef: document.getElementById('chef').value
    };
    fetch('http://localhost/api/yummyadmin/updateRestaurant', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(restaurant)
    })
        .then(response => {
            if (response.ok) {
                alert('Restaurant updated successfully');
                document.getElementById('restaurantsContainer').style.display = 'block';
                document.getElementById('editRestaurantContainer').style.display = 'none';
                fetchRestaurants();
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
                    // Refresh the restaurant list after deletion
                    fetchRestaurants();
                } else {
                    console.error('Error deleting restaurant:', response.statusText);
                }
            })
            .catch(error => console.error('Error deleting restaurant:', error));
    }
}


let nameArray = [];
let selectedRestaurantId = 0;

function fetchRestaurantsNames() {
    fetch('http://localhost/api/yummyadmin/getAllRestaurants')
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
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

async function returnfetchRestaurantsNames() {
    try {
        const response = await fetch('http://localhost/api/yummyadmin/getAllRestaurants');
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return await response.json();
    } catch (error) {
        console.error('Error fetching restaurants:', error);
        return []; // Return an empty array in case of error
    }
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
    updateImages(this.value);
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
            <h5 class="card-title"><span contenteditable="false" id="agenda-Artist-${event.id}">Session ID: ${event.id}</span></h5>
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
             } else {
                 alert('Error updating session:', response.statusText);
             }
         })
         .catch(error => alert('Error updating session:', error));
 }

 function removeSession(eventId) {
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
                        fetchRestaurantSessions(selectedRestaurantId);
                    } else {
                        console.error('Error deleting session:', response.statusText);
                    }
                })
                .catch(error => console.error('Error deleting session:', error));
        }

 }

function addRestaurant(){ //TODO: Find here is a problem here
    const restaurant = {
        name: document.getElementById('name').value,
        address: document.getElementById('address').value,
        type: document.getElementById('type').value,
        price: document.getElementById('price').value,
        reduced: document.getElementById('reducedPrice').value,
        stars: document.getElementById('stars').value,
        phoneNumber: document.getElementById('phoneNumber').value,
        email: document.getElementById('email').value,
        website: document.getElementById('website').value,
        chef: document.getElementById('Chef').value
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
                fetchRestaurants();
            } else {
                alert('Error adding restaurant:', response.statusText);
            }
        })
        .catch(error => alert('Error adding restaurant:', error));
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
                                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter restaurant name">
                                </div>
                                <div class="form-group">
                                    <label for="address">Address</label>
                                    <input type="text" class="form-control" id="address" name="address" placeholder="Enter address">
                                </div>
                                <div class="form-group">
                                    <label for="type">Type</label>
                                    <input type="text" class="form-control" id="type" name="type" placeholder="Enter type">
                                </div>
                                <div class="form-group">
                                    <label for="price">Price</label>
                                    <input type="text" class="form-control" id="price" name="price" pattern="[0-9]*" inputmode="numeric" placeholder="0.00">
                                </div>
                                <div class="form-group">
                                    <label for="reducedPrice">Reduced Price</label>
                                    <input type="text" class="form-control" id="reducedPrice" name="reducedPrice" pattern="[0-9]*" inputmode="numeric" placeholder="0.00">
                                </div>
                                <div class="form-group">
                                    <label for="stars">Stars</label>
                                    <input type="number" class="form-control" id="stars" name="stars" placeholder="Enter stars">
                                </div>
                                <div class="form-group">
                                    <label for="phoneNumber">Phone number</label>
                                    <input type="text" class="form-control" id="phoneNumber" name="phoneNumber" placeholder="Enter Phone Number">
                                </div>
                                <div class="form-group">
                                    <label for="email">Email</label>
                                    <input type="text" class="form-control" id="email" name="email" placeholder="Enter Phone Number">
                                </div>
                                <div class="form-group">
                                    <label for="website">Website</label>
                                    <input type="text" class="form-control" id="website" name="website" placeholder="Enter Website">
                                </div>
                                <div class="form-group">
                                    <label for="Chef">Chef</label>
                                    <input type="text" class="form-control" id="Chef" name="Chef" placeholder="Enter Chef's Name">
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

function createAddSessionForm() {
    // Get the container element where the form will be appended
    const sessionContainer = document.getElementById('sessionContainer');

    // Clear previous content
    sessionContainer.innerHTML = '';

    // Fetch restaurants
    returnfetchRestaurantsNames()
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
                { label: 'Event Date (DD/MM/YYYY):', type: 'text', name: 'eventDate' },
                { label: 'Event Day:', type: 'text', name: 'eventDay' },
                { label: 'Event Start Time (24h):', type: 'text', name: 'eventStartTime' },
                { label: 'Event End Time (24h):', type: 'text', name: 'eventEndTime' },
                { label: 'Event Seats Total:', type: 'number', name: 'eventSeatsTotal' },
                { label: 'Event Seats Available:', type: 'number', name: 'eventSeatsAvailable' }
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


function addSession(){ //TODO: finish this method
const session = {
        restaurant_id: document.getElementById('restaurantList').value,
        event_date: document.getElementById('eventDate').value,
        event_day: document.getElementById('eventDay').value,
        event_time_start: document.getElementById('eventStartTime').value,
        event_time_end: document.getElementById('eventEndTime').value,
        seats_total: document.getElementById('eventSeatsTotal').value,
        seats_left: document.getElementById('eventSeatsAvailable').value
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
                fetchRestaurantSessions(session.restaurant_id);
            } else {
                alert('Error adding session:', response.statusText);
            }
        })
        .catch(error => alert('Error adding session:', error));
}

function updateImages(restaurantID) {
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

            // Iterate over each property in the images object
            for (const key in images) {
                if (images.hasOwnProperty(key)) {
                    // Create a div to contain each image type and its input box
                    const div = document.createElement('div');
                    div.className = 'form-group';

                    // Create a label for the image type
                    const label = document.createElement('label');
                    label.textContent = `${key}: `;
                    div.appendChild(label);

                    // Create a container div for the image inputs and URLs
                    const containerDiv = document.createElement('div');
                    div.appendChild(containerDiv);

                    // Check if the value associated with the key is an array
                    if (Array.isArray(images[key])) {
                        // Iterate over each image URL in the array
                        images[key].forEach(imageUrl => {
                            // Create a div for each image item
                            const itemDiv = document.createElement('div');
                            containerDiv.appendChild(itemDiv);

                            // Create an input for the image file
                            const fileInput = document.createElement('input');
                            fileInput.type = 'file';
                            fileInput.className = 'form-control-file mt-2';
                            fileInput.setAttribute('accept', 'image/*');
                            itemDiv.appendChild(fileInput);

                            // Create a span to display the URL of the chosen image or "Choose a photo" if not set
                            const urlSpan = document.createElement('span');
                            urlSpan.textContent = imageUrl ? imageUrl : 'Choose a photo';
                            itemDiv.appendChild(urlSpan);

                            // Add event listener to file input to update URL when file is chosen
                            fileInput.addEventListener('change', function(event) {
                                const file = event.target.files[0];
                                if (file) {
                                    // Display the name of the chosen image
                                    urlSpan.textContent = file.name;
                                }
                            });
                        });
                    } else {
                        // Create an input for the single image file
                        const fileInput = document.createElement('input');
                        fileInput.type = 'file';
                        fileInput.className = 'form-control-file mt-2';
                        fileInput.setAttribute('accept', 'image/*');
                        containerDiv.appendChild(fileInput);

                        // Create a span to display the URL of the single image or "Choose a photo" if not set
                        const urlSpan = document.createElement('span');
                        urlSpan.textContent = images[key] ? images[key] : 'Choose a photo';
                        containerDiv.appendChild(urlSpan);

                        // Add event listener to file input to update URL when file is chosen
                        fileInput.addEventListener('change', function(event) {
                            const file = event.target.files[0];
                            if (file) {
                                // Display the name of the chosen image
                                urlSpan.textContent = file.name;
                            }
                        });
                    }

                    // Append the div to the imagesContainer
                    imagesContainer.appendChild(div);
                }
            }
        })
        .catch(error => console.error('Error updating images:', error));
}








