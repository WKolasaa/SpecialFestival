document.addEventListener("DOMContentLoaded", function() {
    const timeslots = document.querySelectorAll('.timeslot');

    timeslots.forEach(timeslot => {
        const ticketTypes = timeslot.querySelectorAll('.ticket-type');
        const languages = timeslot.querySelectorAll('.language');
        const addToCartBtn = timeslot.querySelector('.add-to-cart-btn');

        const updateButtonState = () => {
            const ticketTypeSelected = [...ticketTypes].some(radio => radio.checked);
            const languageSelected = [...languages].some(radio => radio.checked);

            addToCartBtn.disabled = !(ticketTypeSelected && languageSelected);
        };

        [...ticketTypes, ...languages].forEach(input => {
            input.addEventListener('change', updateButtonState);
        });
    });
});

document.addEventListener("DOMContentLoaded", function() {
    const timeslots = document.querySelectorAll('.timeslot');

    timeslots.forEach(timeslot => {
        const addToCartBtn = timeslot.querySelector('.add-to-cart-btn');
        addToCartBtn.addEventListener('click', () => {
            const ticketType = timeslot.querySelector('.ticket-type:checked').value;
            const language = timeslot.querySelector('.language:checked').value;
            const timeslotId = timeslot.dataset.timeslotId; // Assuming you add data-timeslot-id attribute to each .timeslot div

            //console.log({ ticketType, language, timeslotId }); // Add this line before fetch
            fetch('/historyadmin/addToCart', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({ ticketType, language, timeslotId }),
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if(data.success) {
                    alert('Ticket added to cart successfully!');
                } else {
                    alert('Failed to add ticket to cart.');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error adding ticket to cart.');
            });
        });
    });
});
