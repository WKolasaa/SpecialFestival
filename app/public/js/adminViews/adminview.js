// Initiate the admin dashboard view
//In the adminViews folder, we will create every api request to change the content and manage everything we needs to do in the admin.

document.addEventListener("DOMContentLoaded", function(event) {
   
  const showNavbar = (toggleId, navId, bodyId, headerId) =>{
  const toggle = document.getElementById(toggleId),
  nav = document.getElementById(navId),
  bodypd = document.getElementById(bodyId),
  headerpd = document.getElementById(headerId)
  
  // Validate that all variables exist
  if(toggle && nav && bodypd && headerpd){
  toggle.addEventListener('click', ()=>{
  // show navbar
  nav.classList.toggle('show')
  // change icon
  toggle.classList.toggle('bx-x')
  // add padding to body
  bodypd.classList.toggle('body-pd')
  // add padding to header
  headerpd.classList.toggle('body-pd')
  })
  }
  }
  
  showNavbar('header-toggle','nav-bar','body-pd','header')
  
  /*===== LINK ACTIVE =====*/
  const linkColor = document.querySelectorAll('.nav_link')
  
  function colorLink(){
  if(linkColor){
  linkColor.forEach(l=> l.classList.remove('active'))
  this.classList.add('active')
  }
  }
  linkColor.forEach(l=> l.addEventListener('click', colorLink))
  
   // Your code to run since DOM is loaded and ready
  });
  
  // Function to fetch data from the API
function loadData() {
  fetch("http://localhost/api/danceevent")
      .then(response => {
          if (!response.ok) {
              throw new Error('Network response was not ok');
          }
          return response.json();
      })
      .then(data => {
        displayEvents(data); // Display all users by default
      })
      .catch(error => {
          console.error('Error fetching items:', error);
      });
}

// Function to display users based on the provided list
// Function to display events based on the provided list
function displayEvents(events) {
  const eventList = document.getElementById('eventList');
  eventList.innerHTML = ''; // Clear existing list items

  events.forEach(event => { 
      const listItem = document.createElement('li');

      // Add data to the list item
      listItem.innerHTML = `
      <div class="event-block">
        <span class="event-day">${event.day}</span>
        <div class="event-details">
          <span contenteditable="true" data-key="event_date">Date: ${event.event_date}</span><br>
          <span contenteditable="true" data-key="performers">Performer(s): ${event.performers}</span><br>
          <span contenteditable="true" data-key="event_type">Event Type: ${event.event_type}</span><br>
          <span contenteditable="true" data-key="location">Location: ${event.location}</span><br>
          <span contenteditable="true" data-key="capacity">Capacity: ${event.capacity}</span><br>
          <span contenteditable="true" data-key="tickets_available">Tickets Available: ${event.tickets_available}</span><br>
          <span contenteditable="true" data-key="ticket_price">Ticket Price: ${event.ticket_price}</span><br>
          <span contenteditable="true" data-key="additional_info">Additional Info: ${event.additional_info}</span><br>
          <span contenteditable="true" data-key="artist_styles">Artist Styles: ${event.artist_styles}</span><br>
          <span contenteditable="true" data-key="venue_address">Venue Address: ${event.venue_address}</span><br>
        </div>
      </div>
    `;
    

      // Append list item to the list
      eventList.appendChild(listItem);
  });

  // Add event listeners to save edited data
  eventList.querySelectorAll('[contenteditable="true"]').forEach(editable => {
      editable.addEventListener('blur', saveEvent);
  });
}

// Function to handle saving edited event data
function saveEvent(event) {
    const key = event.target.dataset.key;
    const value = event.target.textContent;
    // Send a PUT request to update the event data in the backend
    // You need to implement the backend API endpoint to handle this
    // Example: fetch(`http://localhost/api/danceevent/${eventId}`, {
    //             method: 'PUT',
    //             headers: {
    //                 'Content-Type': 'application/json'
    //             },
    //             body: JSON.stringify({ [key]: value })
    //         })
    //         .then(response => {
    //             if (!response.ok) {
    //                 throw new Error('Failed to save event data');
    //             }
    //         })
    //         .catch(error => {
    //             console.error('Error saving event data:', error);
    //         });
}

loadData();



// Load data when the page is loaded
// document.addEventListener('DOMContentLoaded', loadData);

