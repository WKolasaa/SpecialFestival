document.querySelectorAll('.quantity-increase').forEach(function(button) {
    button.addEventListener('click', function() {
        const row = button.parentElement.parentElement;
        const quantityElement = row.querySelector('.quantity');
        const priceElement = row.querySelector('.price');
        const quantity = parseInt(quantityElement.textContent, 10);
        quantityElement.textContent = quantity + 1;
        priceElement
        increaseTicketQuantity(row.dataset.ticketId);
    });
});

document.querySelectorAll('.quantity-decrease').forEach(function(button) {
    button.addEventListener('click', function() {
        const row = button.parentElement.parentElement;
        const quantityElement = row.querySelector('.quantity');
        const quantity = parseInt(quantityElement.textContent, 10);
        if (quantity > 1) {
            quantityElement.textContent = quantity - 1;
            decreaseTicketQuantity(row.dataset.ticketId);
        } else {
            const ticketId = row.dataset.ticketId;
            row.parentElement.removeChild(row);
            deleteTicket(ticketId);
        }
    });
});

document.querySelectorAll('.delete-ticket').forEach(function(button) {
    button.addEventListener('click', function() {
        const row = button.parentElement.parentElement;
        row.parentElement.removeChild(row);
        deleteTicket(row.dataset.ticketId);
    });
});

document.querySelector('.share-btn').addEventListener('click', function() {
    generateShareToken();
});

function increaseTicketQuantity(ticketId) {
    fetch('/api/FestPlan/increaseTicketQuantity', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            ticketId: ticketId,
            userId: userId
        }),
    })
        .then(response => response.json())
        .then(data => console.log(data))
        .catch((error) => {
            console.error('Error:', error);
        });
}

function decreaseTicketQuantity(ticketId) {
    fetch('/api/FestPlan/decreaseTicketQuantity', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            ticketId: ticketId,
            userId: userId
        }),
    })
        .then(response => response.json())
        .then(data => console.log(data))
        .catch((error) => {
            console.error('Error:', error);
        });
}

function deleteTicket(ticketId) {
    // Make an AJAX request to delete the ticket on the server
    fetch('/api/FestPlan/deleteTicket', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            ticketId: ticketId,
            userId: userId,
        }),
    })
        .then(response => response.json())
        .then(data => console.log(data))
        .catch((error) => {
            console.error('Error:', error);
        });
}

function generateShareToken() {
    fetch('/api/FestPlan/generateShareToken', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            userId: userId,
        }),
    })
        .then(response => response.text())  // Get the response text
        .then(text => {
            console.log('Raw response:', text);  // Print the raw response
            return JSON.parse(text);  // Parse the text as JSON
        })
        .then(data => {
            console.log('Data:', data);
            const shareUrl = `${window.location.origin}/FestPlan?token=${data.token}`;

            // Copy the share link to the clipboard
            navigator.clipboard.writeText(shareUrl).then(function() {
                alert('Share link copied to clipboard!');
            }, function(err) {
                console.error('Could not copy text: ', err);
            });
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}