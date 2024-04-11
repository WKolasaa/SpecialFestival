document.querySelectorAll('.quantity-increase').forEach(function(button) {
    button.addEventListener('click', function() {
        const row = button.parentElement.parentElement;
        const quantityElement = row.querySelector('.quantity');
        const quantity = parseInt(quantityElement.textContent, 10);
        quantityElement.textContent = quantity + 1;
        increaseTicketQuantity(row.dataset.ticketId);
    });
});

document.querySelectorAll('.quantity-decrease').forEach(function(button) {
    button.addEventListener('click', function() {
        const row = button.parentElement.parentElement;
        const quantityElement = row.querySelector('.quantity');
        const quantity = parseInt(quantityElement.textContent, 10);
        if (quantity > 0) {
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
        .then(response => {
            // Log the raw response text
            response.text().then(text => console.log(text));
            return response.json();
        })
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