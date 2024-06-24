document.querySelectorAll('.quantity-increase').forEach(function (button) {
    button.addEventListener('click', function () {
        const row = button.parentElement.parentElement;
        const quantityElement = row.querySelector('.quantity');
        const priceElement = row.querySelector('.price');
        const quantity = parseInt(quantityElement.textContent, 10);
        quantityElement.textContent = quantity + 1;
        increaseTicketQuantity(row.dataset.ticketId);
    });
});

document.querySelectorAll('.quantity-decrease').forEach(function (button) {
    button.addEventListener('click', function () {
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

document.querySelectorAll('.delete-ticket').forEach(function (button) {
    button.addEventListener('click', function () {
        const row = button.parentElement.parentElement;
        row.parentElement.removeChild(row);
        deleteTicket(row.dataset.ticketId);
    });
});

document.querySelector('.share-btn').addEventListener('click', function () {
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
        .catch((error) => {
            console.error('Error:', error);
        });
}

function generateShareToken() {
    // Check if the user is logged in
    if (userId === -1) {
        showToast('Please login to share your FestPlan!');
        return;
    }

    fetch('/api/FestPlan/generateShareToken', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({
            userId: userId,
        }),
    })
        .then(response => response.json())
        .then(data => {
            const shareUrl = `${window.location.origin}/FestPlan?token=${data.token}`;

            // Copy the share link to the clipboard
            copyToClipboard(shareUrl).then(function () {
                showToast('Share link copied to clipboard!');
            }, function (err) {
                console.error('Could not copy text: ', err);
            });
        })
        .catch((error) => {
            console.error('Error:', error);
        });
}

async function copyToClipboard(textToCopy) {
    // Navigator clipboard api needs a secure context (https)
    if (navigator.clipboard && window.isSecureContext) {
        await navigator.clipboard.writeText(textToCopy);
    } else {
        // Use the 'out of viewport hidden text area' trick
        const textArea = document.createElement("textarea");
        textArea.value = textToCopy;

        // Move textarea out of the viewport, so it's not visible
        textArea.style.position = "absolute";
        textArea.style.left = "-999999px";

        document.body.prepend(textArea);
        textArea.select();

        try {
            document.execCommand('copy');
        } catch (error) {
            console.error(error);
        } finally {
            textArea.remove();
        }
    }
}
