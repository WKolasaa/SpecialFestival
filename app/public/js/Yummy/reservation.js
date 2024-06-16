function updateSessions(selectedDay) {
    const restaurantID = document.getElementById('restaurant').textContent;
    fetch('http://localhost/api/yummyreservation/getRestaurantEvents', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({restaurantID: restaurantID})
    })
        .then(response => response.json())
        .then(data => {
            // Filter events based on the selected day
            const filteredEvents = data.filter(event => event.event_day === selectedDay);

            // Clear sessionSelect and populate with filtered events
            const sessionSelect = document.getElementById('sessionSelect');
            sessionSelect.innerHTML = '';
            filteredEvents.forEach(event => {
                const optionText = `${event.event_time_start} - ${event.event_time_end} (${event.seats_left} seats left)`;
                const option = new Option(optionText, event.id); // Use event ID as value
                option.setAttribute('data-seats-left', event.seats_left);
                sessionSelect.add(option);
            });
        })
        .catch(error => {
            console.log('Error:', error);
            showMessage('Error fetching restaurant data', 'alert-danger');
        });
}

function validateForm() {
    const daySelect = document.getElementById('daySelect').value;
    const sessionSelect = document.getElementById('sessionSelect');
    const selectedSessionOption = sessionSelect.options[sessionSelect.selectedIndex];
    const regularTickets = parseInt(document.getElementById('regularTickets').value, 10);
    const reducedTickets = parseInt(document.getElementById('reducedTickets').value, 10);
    const totalTickets = regularTickets + reducedTickets; //
    const seatsLeft = parseInt(selectedSessionOption.getAttribute('data-seats-left'), 10);
    const restaurantId = document.getElementById('restaurant').textContent;
    const eventID = sessionSelect.value;
    const specialRequests = document.getElementById('specialRequests').value;

    if (regularTickets < 0 || reducedTickets < 0) {
        showMessage("Please enter a valid number of tickets.", 'alert-danger');
        return false;
    }

    if (daySelect === "" || sessionSelect.value === "") {
        showMessage("Please select both a day and a session.", 'alert-danger');
        return false;
    }

    if (totalTickets > seatsLeft) {
        showMessage(`Only ${seatsLeft} seats left for the selected session. You have requested ${totalTickets} tickets.`, 'alert-danger');
        return false;
    }

    fetch('http://localhost/api/yummyreservation/reserve', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            restaurantID: restaurantId,
            eventID: eventID,
            regularTickets: regularTickets,
            reducedTickets: reducedTickets,
            specialRequests: specialRequests
        })
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                reserve(restaurantId, eventID, regularTickets, reducedTickets, specialRequests, daySelect);
            } else {
                showMessage('Error reserving seats', 'alert-danger');
            }
        })
        .catch(error => {
            console.log('Error:', error);
            showMessage('Error reserving seats', 'alert-danger');
        });

}

function reserve(restaurantID, eventID, regularTickets, reducedTickets, specialRequests, daySelect) {
    const form = document.getElementById('reservationForm');

    const array = {
        restaurantID: restaurantID,
        eventID: eventID,
        regularTickets: regularTickets,
        reducedTickets: reducedTickets,
        specialRequests: specialRequests
    };

    console.log(array);

    fetch('http://localhost/api/yummyreservation/addTicket', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(array)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showMessage('Reservation successful', 'alert-success');
                setTimeout(() => {
                    updateSessions(daySelect);
                }, 1000);
            } else {
                showMessage('Error reserving seats ADD TICKET', 'alert-danger');
            }
        })
        .catch(error => {
            console.log('Error:', error);
            showMessage('Error reserving seats CATCH ADD TICKET', 'alert-danger');
        });
}

function showMessage(message, alertClass) {
    var messageDiv = document.getElementById('message');
    messageDiv.innerHTML = '<div class="alert ' + alertClass + '">' + message + '</div>';
}