function updateSessions(selectedDay) {
    const restaurantID = document.getElementById('restaurant').textContent;
    fetch('/api/YummyReservation/getRestaurantEvents', {
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
            showToast('Error fetching restaurant data', 'red');
            //showMessage('Error fetching restaurant data', 'alert-danger');
        });
}

function isLoggedIn(){
    fetch('/api/User/userLoggedIn')
        .then(response => response.json())
        .then(data => {
            //console.log(data);
            if (data.success) {
                validateForm();
            } else {
                showToast('Please log in to make a reservation', 'red');
                //showMessage('Please log in to make a reservation', 'alert-danger')
            }
        })
        .catch((error) => {
            showToast('Something went wrong', 'red');
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
        showToast('Please enter a valid number of tickets.', 'red');
        //showMessage("Please enter a valid number of tickets.", 'alert-danger');
        return false;
    }

    if (daySelect === "" || sessionSelect.value === "") {
        showToast('Please select both a day and a session.', 'red');
        //showMessage("Please select both a day and a session.", 'alert-danger');
        return false;
    }

    if (totalTickets > seatsLeft) {
        showToast(`Only ${seatsLeft} seats left for the selected session. You have requested ${totalTickets} tickets.`, 'red');
        //showMessage(`Only ${seatsLeft} seats left for the selected session. You have requested ${totalTickets} tickets.`, 'alert-danger');
        return false;
    }

    if(regularTickets === 0 && reducedTickets === 0){
        showToast('Please select at least one ticket.', 'red');
        return false;
    }

    fetch('/api/YummyReservation/reserve', {
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
                showToast('Error reserving seats', 'red');
                //showMessage('Error reserving seats', 'alert-danger');
            }
        })
        .catch(error => {
            console.log('Error:', error);
            showToast('Error reserving seats', 'red');
            //showMessage('Error reserving seats', 'alert-danger');
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

    //console.log(array);

    fetch('/api/YummyReservation/addTicket', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(array)
    })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                showToast('Reservation successful', 'green');
                //showMessage('Reservation successful', 'alert-success');
                setTimeout(() => {
                    updateSessions(daySelect);
                }, 1000);
            } else {
                showToast('Error reserving seats', 'red');
                //showMessage('Error reserving seats ADD TICKET', 'alert-danger');
            }
        })
        .catch(error => {
            //console.log('Error:', error);
            showToast('Error reserving seats', 'red');
            //showMessage('Error reserving seats', 'alert-danger');
        });
}

function showMessage(message, alertClass) {
    var messageDiv = document.getElementById('message');
    messageDiv.innerHTML = '<div class="alert ' + alertClass + '">' + message + '</div>';
}