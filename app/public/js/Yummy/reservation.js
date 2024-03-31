function updateSessions(selectedDay) {
    console.log("TEST");
    const restaurantID = document.getElementById('restaurant').textContent;
    fetch('http://localhost/api/yummyreservation/getRestaurantEvents', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ restaurantID: restaurantID }) // Sending restaurantID as an object
    })
        .then(response => response.json())
        .then(data => {
            const sessionSelect = document.getElementById('sessionSelect');
            sessionSelect.innerHTML = '';

            Object.entries(data).forEach(([date, eventData]) => {
                if (eventData.event_day === selectedDay) {
                    eventData.sessions.forEach(session => {
                        const optionText = `${session.event_time_start} - ${session.event_time_end} (${session.seats_left} seats left)`;
                        const option = new Option(optionText, session.event_time_start);
                        option.setAttribute('data-seats-left', session.seats_left);
                        sessionSelect.add(option);
                    });
                }
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
    const totalTickets = regularTickets + reducedTickets;
    const seatsLeft = parseInt(selectedSessionOption.getAttribute('data-seats-left'), 10);

    if (daySelect === "" || sessionSelect.value === "") {
        showMessage("Please select both a day and a session.", 'alert-danger');
        return false;
    }

    if (totalTickets > seatsLeft) {
        showMessage(`Only ${seatsLeft} seats left for the selected session. You have requested ${totalTickets} tickets.`, 'alert-danger');
        return false;
    }

    showMessage('Reservation successful!', 'alert-success')
    return false;
}

function showMessage(message, alertClass) {
    var messageDiv = document.getElementById('message');
    messageDiv.innerHTML = '<div class="alert ' + alertClass + '">' + message + '</div>';
}