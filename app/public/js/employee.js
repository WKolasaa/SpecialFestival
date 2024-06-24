let scanned = false;

document.getElementById('startButton').addEventListener('click', () => {
    const codeReader = new ZXing.BrowserQRCodeReader();
    console.log('ZXing code reader initialized');

    codeReader.getVideoInputDevices()
        .then((videoInputDevices) => {
            const firstDeviceId = videoInputDevices[0].deviceId
            codeReader.decodeFromVideoDevice(firstDeviceId, 'video', (result, err) => {
                if (result) {
                    console.log(result)
                    codeReader.reset();
                    fetch('/api/employee/handleQRData', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({qrData: result.text})
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.error) {
                                // Handle error case
                                console.error('Error:', data.error);
                                alert('Error: ' + data.error);
                            } else {
                                if (data.scanned) {
                                    // Ticket already scanned
                                    scanned = true;
                                } else {
                                    // Ticket scanned for the first time
                                    scanned = false;
                                }
                                displayTicketInformation();
                            }
                        })
                        .catch(error => {
                            // Handle fetch or parsing errors
                            console.error('Fetch error:', error);
                            alert('Fetch error: ' + error.message);
                        });
                }
                if (err && !(err instanceof ZXing.NotFoundException)) {
                    if(err !== 'undefined'){
                        console.error(err)
                        //alert('Error scanning QR Code 111: ' + err.message)
                    }
                }
            })
        })
        .catch((err) => {
            console.error(err);
            alert('Error initializing camera: ' + err.message);
        })
});

function displayTicketInformation() {
    fetch('/api/employee/getTicketInformation', {
        method: 'GET',
        headers: {
            'Content-Type': 'application/json'
        }

    })
        .then(response => response.json())
        .then(data => {
            if (data.error) {
                // Handle error case
                console.error('Error:', data.error);
                alert('Error: ' + data.error);
            } else {
                populateForm(data);
            }
        })
        .catch(error => {
            // Handle fetch or parsing errors
            console.error('Fetch error:', error);
            alert('Fetch error: ' + error.message);
        });
}

function populateForm(data) {
    const ticketInfoCard = document.getElementById('ticketInfoCard');
    ticketInfoCard.innerHTML = ''; // Clear existing content
    ticketInfoCard.classList.add('container'); // Add Bootstrap container class

    const heading = document.createElement('h2');
    heading.textContent = 'Ticket Details'; // Set the heading text
    heading.classList.add('my-3'); // Add Bootstrap margin class
    ticketInfoCard.appendChild(heading);

    console.log(data);
    // Assuming there's only one reservation in the data array
    const ticket = data[0];

    const reservationDetails = document.createElement('div');
    reservationDetails.classList.add('card', 'mb-3'); // Use the same custom class as for tickets

    if(data.ticket_Type === 2){
        var partsOfDescription = data.description.split('/');
        reservationDetails.innerHTML = `
            <div class="card-body">
                <h5 class="card-title">${data.ticket_name} (Ticket ID: ${data.ticketId})</h5>
                <p class="card-text">
                    Event Name: ${data.event_name}<br>
                    Location: ${data.location}<br>
                    Normal tickets: ${partsOfDescription[0]}<br>
                    Kids tickets: ${partsOfDescription[1]}<br>
                    Special Requests: ${partsOfDescription[2]}<br>
                    Price: ${data.price}<br>
                    Start Date: ${new Date(data.start_date.date).toLocaleString()}<br>
                    End Date: ${new Date(data.end_date.date).toLocaleString()}<br>
                    Ticket Type: ${data.ticket_Type}<br>
                    Scanned: ${scanned ? 'Yes' : 'No'} <br>
                </p>
            </div>
        `;
    } else {
        reservationDetails.innerHTML = `
            <div class="card-body">
                <h5 class="card-title">${data.ticket_name} (Ticket ID: ${data.ticketId})</h5>
                <p class="card-text">
                    Event Name: ${data.event_name}<br>
                    Location: ${data.location}<br>
                    Description: ${data.description}<br>
                    Price: ${data.price}<br>
                    Start Date: ${new Date(data.start_date.date).toLocaleString()}<br>
                    End Date: ${new Date(data.end_date.date).toLocaleString()}<br>
                    Ticket Type: ${data.ticket_Type}<br>
                    Scanned: ${scanned ? 'Yes' : 'No'} <br>
                </p>
            </div>
        `;
    }

    ticketInfoCard.appendChild(reservationDetails);
}
