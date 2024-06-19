// waiting until the HTML doc is fully loaded before executing the script
document.addEventListener("DOMContentLoaded", function() {
    // Select all elements with the class 'timeslot'
    const timeslots = document.querySelectorAll('.timeslot');

    timeslots.forEach(timeslot => {
        // Find and store all ticket type and language options within this timeslot
        const ticketTypes = timeslot.querySelectorAll('.ticket-type');
        const languages = timeslot.querySelectorAll('.language');
        // Find and store the 'Add to Cart' button for this timeslot
        const addToCartBtn = timeslot.querySelector('.add-to-cart-btn');

        addToCartBtn.disabled = true;

        // update 'AddToCart' button's disabled state based on selection
        const updateButtonState = () => {
            const ticketTypeSelected = [...ticketTypes].some(radio => radio.checked);
            const languageSelected = [...languages].some(radio => radio.checked);
            //enable button if both type AND language are selected
            addToCartBtn.disabled = !(ticketTypeSelected && languageSelected);
        };
        // Attach change event listeners to all ticket type and language inputs to trigger the button state update
        [...ticketTypes, ...languages].forEach(input => {
            input.addEventListener('change', updateButtonState);
        });
    });
});

////////////////// handling 'Add to Cart' button click event //////////////////
document.addEventListener("DOMContentLoaded", function() {
    //select all timeslot elements 
    const timeslots = document.querySelectorAll('.timeslot');

    timeslots.forEach(timeslot => {
        const addToCartBtn = timeslot.querySelector('.add-to-cart-btn');
        // Attach an event listener for the click event on this button
        addToCartBtn.addEventListener('click', () => {

            checkUserSession().then(hasSession => {
                if (!hasSession) {
                    showToast("Please log in to add items to the cart.", "#FF0000");
                    return; // Stop further execution if the user is not logged in.
                }
            
                // Gather necessary data from the timeslot to send tco the server
                const price = timeslot.querySelector('.ticket-type:checked').value; // selected price
                const language = timeslot.querySelector('.language:checked').value; // selected language
                const timeslot_id = timeslot.dataset.timeslotId;
                // The start and end time text content
                const startTime = timeslot.querySelector('.start-time').textContent;
                const endTime = timeslot.querySelector('.end-time').textContent;
                // The date as text content.
                const day = timeslot.querySelector('.day').textContent;

                const date = day;
            
                const start_date = `${date} ${startTime}`;  
                const end_date = `${date} ${endTime}`;
            
                const selectedTicketType = timeslot.querySelector('.ticket-type:checked').getAttribute('data-ticket-type'); // Get ticket type
                let description; // Use 'let' for variables that will be reassigned.
                if(selectedTicketType == 'Family') {
                    description = language + ', Family ticket';
                } else {            
                    description = language+', Regular ticket';
                }

                const event_name = 'HISTORY EVENT';
                const ticket_name = 'Haarlem Tour';
                const location = 'Grote Markt 22, 2011 RD Haarlem';
                
                console.log(startTime, endTime, date,  start_date, end_date, price, description, event_name, ticket_name, location);
                // Send the collected data to the server via POST request.
                fetch('/api/HistoryAdmin/addToCart', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        timeslot_id,
                        price,
                        start_date,
                        end_date,
                        description,
                        event_name,
                        ticket_name,
                        location
                    }),
                })
                .then((response) => {
                    if (response.ok) {
                      console.log("Ticket added successfully");
                      showToast("Ticket added to cart!","#008000");
                      return response.text();
                    } else {
                      console.error("Error:", response.status, response.statusText);
                    }
                  })
            });
        });
    });
});

////////////////// function to check if the user is logged in //////////////////
function checkUserSession() {
    return fetch("/api/HistoryAdmin/checkUser")
      .then((response) => response.json())
      .then((data) => data.hasSession);
  }

