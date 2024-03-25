// Function to fetch restaurant data from the server
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
                        <td>${restaurant.phoneNumber}</td>
                        <td>${restaurant.email}</td>
                        <td>${restaurant.website}</td>
                        <td>${restaurant.chef}</td>
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

// Function to delete a restaurant record
function deleteRestaurant(restaurantId) {
    if (confirm('Are you sure you want to delete this restaurant?')) {
        fetch(`api/delete_restaurant.php?id=${restaurantId}`, { method: 'DELETE' })
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

// Initial fetch of restaurant data when the page loads
window.onload = fetchRestaurants;

function showRestaurants(){
    document.getElementById('restaurantsTable').style.display = "block";
    fetchRestaurants();
}

function showSessions(){
    document.getElementById('restaurantsTable').style.display = "none";
}
