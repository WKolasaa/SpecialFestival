////////////sidebar/////////////////////
function showArtists() {
  document.getElementById('artists-container').style.display = 'block';
  document.getElementById('agenda-container').style.display = 'none';
  document.getElementById('tickets-container').style.display = 'none';
  const addButton=document.getElementById('add-btn');
  addButton.innerText = `Add Artist`;
  addButton.onclick = showAddArtistForm; // Assign the onclick handler here

  loadArtists();
}
loadArtists();
loadAgenda();
loadTickets();

// Function to display agenda
function showAgenda() {
  document.getElementById('artists-container').style.display = 'none';
  document.getElementById('agenda-container').style.display = 'block';
  document.getElementById('tickets-container').style.display = 'none';
  const addButton=document.getElementById('add-btn');
  addButton.innerText = `Add Event`;
  addButton.onclick = showAddAgendaForm; // Assign the onclick handler here

  loadAgenda();
}

// Function to display tickets
function showTickets() {
  document.getElementById('artists-container').style.display = 'none';
  document.getElementById('agenda-container').style.display = 'none';
  document.getElementById('tickets-container').style.display = 'block';
  const addButton=document.getElementById('add-btn');
  addButton.innerText = `Add Ticket`;
  addButton.onclick = showAddTicketForm; // Assign the onclick handler here

  loadTickets();
}

///////////////////finish sidebar////////////////////

//////////////////////Adjusting the Form///////////////////////

function showAddArtistForm() {
  document.getElementById('add-artist-form').style.display = 'block';
  document.getElementById('add-agenda-form').style.display = 'none';
  document.getElementById('add-ticket-form').style.display = 'none';


}

function showAddAgendaForm() {
  document.getElementById('add-artist-form').style.display = 'none';
  document.getElementById('add-agenda-form').style.display = 'block';
  document.getElementById('add-ticket-form').style.display = 'none';
}

function showAddTicketForm() {
  document.getElementById('add-artist-form').style.display = 'none';
  document.getElementById('add-agenda-form').style.display = 'none';
  document.getElementById('add-ticket-form').style.display = 'block';
}

// const addButton = document.getElementById('add-btn');
// // When showing artists
// addButton.onclick = showAddArtistForm;
// addButton.innerText = 'Add Artist';

// // When showing agenda/events
// addButton.onclick = showAddAgendaForm;
// addButton.innerText = 'Add Event';

// // When showing tickets
// addButton.onclick = showAddTicketForm;
// addButton.innerText = 'Add Ticket';




//////////////////////fetch data///////////////////////

let allArtists = [];
function loadArtists() {
  fetch("http://localhost/api/danceevent/Artists")
      .then(response => response.json())
      .then(data => {
          allArtists = data; // Store all users in the array
          displayArtists(allArtists); // Display all users by default
      })
      .catch(error => {
          console.error('Error fetching items:', error);
      });
}

let allAgenda = [];
function loadAgenda() {
  console.log('loadAgenda called'); // Add this
  fetch("http://localhost/api/danceevent/Agenda")
      .then(response => {
        console.log('Response:', response); // And this
        return response.json();
      })
      .then(data => {
        console.log('Data:', data); // And this
        allAgenda = data;
        displayAgenda(allAgenda);
      })
      .catch(error => {
        console.error('Error fetching items:', error);
      });
}

let allTickets = [];
function loadTickets() {
  fetch("http://localhost/api/danceevent/Tickets")
      .then(response => response.json())
      .then(data => {
          allTickets = data; // Store all users in the array
          displayTickets(allTickets); // Display all users by default
      })
      .catch(error => {
          console.error('Error fetching items:', error);
      });
}

//////////////////////finish fetch data///////////////////////



//////////////////////display data///////////////////////

///////////////////////update data///////////////////////
function displayArtists(artists) {
  const artistContainer = document.getElementById('artists-container');
  artistContainer.innerHTML = ''; // Clear existing content

  const heading = document.createElement('h2');
  heading.textContent = 'Artists'; // Set the heading text
  artistContainer.appendChild(heading);
  const artistList = document.createElement('ul');

  artists.forEach(artist => {
    const artistItem = document.createElement('li');
    artistItem.innerHTML = `
      Name: <span contenteditable="true" id="artist-name-${artist.artistId}">${artist.artistName}</span>, 
      Style: <span contenteditable="true" id="artist-style-${artist.artistId}">${artist.style}</span>, 
      Participation Date: <span contenteditable="true" id="artist-date-${artist.artistId}">${artist.participationDate}</span>
      <button onclick="saveArtist(${artist.artistId})">Save</button>
      <button onclick="deleteArtist(${artist.artistId})">Delete</button>
    `;
    artistList.appendChild(artistItem);
  });

  artistContainer.appendChild(artistList);
}

function saveArtist(artistId) {
  // Collect the updated artist details from the content-editable elements
  const artistNameElement = document.getElementById(`artist-name-${artistId}`);
  const artistStyleElement = document.getElementById(`artist-style-${artistId}`);
  const artistDateElement = document.getElementById(`artist-date-${artistId}`);

  const updatedArtist = {
    artistId: artistId,
    artistName: artistNameElement.textContent,
    style: artistStyleElement.textContent,
    participationDate: artistDateElement.textContent,
  };

  // Send POST request with the updated content of the updatedArtist
  fetch('http://localhost/api/danceevent/updateArtist', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(updatedArtist),
  })
  .then(response => {
    if (response.ok) {
      console.log('Artist updated successfully');
    } else {
      throw new Error('Failed to update artist');
    }
  })
  .catch(error => {
    console.error('Error updating artist:', error);
  });
}
function deleteArtist(artistId) {

  const artistNameElement = document.getElementById(`artist-name-${artistId}`);
  const artistStyleElement = document.getElementById(`artist-style-${artistId}`);
  const artistDateElement = document.getElementById(`artist-date-${artistId}`);

  const DeletedArtist = {
    artistId: artistId,
    artistName: artistNameElement.textContent,
    style: artistStyleElement.textContent,
    participationDate: artistDateElement.textContent,
  };
  fetch(`http://localhost/api/danceevent/deleteArtist`, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(DeletedArtist),
  })
  .then(response => {
    if (response.ok) {
      console.log('Artist deleted successfully');
      loadArtists(); // Reload artists to reflect changes
    } else {
      throw new Error('Failed to delete artist');
    }
  })
  .catch(error => console.error('Error deleting artist:', error));
}

function addArtist() {
  const artistName = document.getElementById('new-artist-name').value;
  const artistStyle = document.getElementById('new-artist-style').value;
  const participationDate = document.getElementById('new-artist-date').value;

  const artistData = {
    artistName: artistName,
    style: artistStyle,
    participationDate: participationDate,
  };

  fetch('http://localhost/api/danceevent/addArtist', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(artistData),
  })
  .then(response => response.json())
  .then(data => {
    console.log('Artist added successfully:', data);
    showArtists(); // Reload artists list
  })
  .catch(error => {
    console.error('Error adding artist:', error);
  });
}



//////////////////////////Agenda//////////////////////////


function displayAgenda(agendas) {
  const agendaContainer = document.getElementById('agenda-container');
  agendaContainer.innerHTML = ''; // Clear existing content

  const heading = document.createElement('h2');
  heading.textContent = 'Agendas'; // Set the heading text
  agendaContainer.appendChild(heading);
  const agendaList = document.createElement('ul');

  agendas.forEach(agenda => {
    const agendaItem = document.createElement('li');
    agendaItem.innerHTML = `
    Artist: <span contenteditable="true" id="agenda-Artist-${agenda.agendaId}">${agenda.artistName}</span>, 

      Event Day: <span contenteditable="true" id="agenda-day-${agenda.agendaId}">${agenda.eventDay}</span>, 
      Date: <span contenteditable="true" id="agenda-date-${agenda.agendaId}">${agenda.eventDate}</span>, 
      Time: <span contenteditable="true" id="agenda-time-${agenda.agendaId}">${agenda.eventTime}</span>,
      Duration: <span contenteditable="true" id="agenda-duration-${agenda.agendaId}">${agenda.durationMinutes} min</span>, 
      Price: €<span contenteditable="true" id="agenda-price-${agenda.agendaId}">${agenda.ticketPrice}</span>, 
      Tickets Available: <span contenteditable="true" id="agenda-tickets-${agenda.agendaId}">${agenda.ticketsAvailable}</span>, 
      Venue: <span contenteditable="true" id="agenda-venue-${agenda.agendaId}">${agenda.venueAddress}</span>
      <button onclick="saveAgenda(${agenda.agendaId})">Save</button>
      <button onclick="deleteAgenda(${agenda.agendaId})">Delete</button>

    `;
    agendaList.appendChild(agendaItem);
  });

  agendaContainer.appendChild(agendaList);
}

function saveAgenda(agendaId) {
  const updatedAgenda = {
    agendaId: agendaId,
    artistName: document.getElementById(`agenda-Artist-${agendaId}`).textContent,
    eventDay: document.getElementById(`agenda-day-${agendaId}`).textContent,
    eventDate: document.getElementById(`agenda-date-${agendaId}`).textContent,
    eventTime: document.getElementById(`agenda-time-${agendaId}`).textContent,
    durationMinutes: document.getElementById(`agenda-duration-${agendaId}`).textContent.replace(' min', ''),
    ticketPrice: document.getElementById(`agenda-price-${agendaId}`).textContent,
    ticketsAvailable: document.getElementById(`agenda-tickets-${agendaId}`).textContent,
    venueAddress: document.getElementById(`agenda-venue-${agendaId}`).textContent,
  };

  // Send POST request with the updated content of the updatedAgenda
  fetch('http://localhost/api/danceevent/updateAgenda', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(updatedAgenda),
  })
  .then(response => {
    if (response.ok) {
      console.log('Agenda updated successfully');
    } else {
      throw new Error('Failed to update agenda');
    }
  })
  .catch(error => {
    console.error('Error updating agenda:', error);
  });
}
function deleteAgenda(agendaId) {
  const DeletedAgenda = {
    agendaId: agendaId,
    artistName: document.getElementById(`agenda-Artist-${agendaId}`).textContent,
    eventDay: document.getElementById(`agenda-day-${agendaId}`).textContent,
    eventDate: document.getElementById(`agenda-date-${agendaId}`).textContent,
    eventTime: document.getElementById(`agenda-time-${agendaId}`).textContent,
    durationMinutes: document.getElementById(`agenda-duration-${agendaId}`).textContent.replace(' min', ''),
    ticketPrice: document.getElementById(`agenda-price-${agendaId}`).textContent,
    ticketsAvailable: document.getElementById(`agenda-tickets-${agendaId}`).textContent,
    venueAddress: document.getElementById(`agenda-venue-${agendaId}`).textContent,
  };
  fetch(`http://localhost/api/danceevent/deleteAgenda`, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(DeletedAgenda),
  })
  .then(response => {
    if (response.ok) {
      console.log('Agenda deleted successfully');
      loadAgenda(); // Reload agendas to reflect changes
    } else {
      throw new Error('Failed to delete agenda');
    }
  })
  .catch(error => console.error('Error deleting agenda:', error));
}


function addEvent() {
  // Collect input values...
  const eventData = {
    artistName: document.getElementById('new-event-artistName').value,
    eventDay: document.getElementById('new-event-day').value,
    eventDate: document.getElementById('new-event-date').value,
    eventTime: document.getElementById('new-event-time').value,
    durationMinutes: document.getElementById('new-event-duration').value,
    ticketPrice: document.getElementById('new-event-ticketPrice').value,
    ticketsAvailable: document.getElementById('new-event-ticketsAvailable').value,
    venueAddress: document.getElementById('new-event-venueAddress').value,
  };

  fetch('http://localhost/api/danceevent/addEvent', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(eventData),
  })
  .then(response => response.json())
  .then(data => {
    console.log('Event added successfully:', data);
    showAgenda(); // Reload events list
  })
  .catch(error => console.error('Error adding event:', error));
}



//////////////////////////Tickets//////////////////////////




function displayTickets(tickets) {
  const ticketContainer = document.getElementById('tickets-container');
  ticketContainer.innerHTML = ''; // Clear existing content

  const heading = document.createElement('h2');
  heading.textContent = 'Tickets'; // Set the heading text
  ticketContainer.appendChild(heading);
  const ticketList = document.createElement('ul');

  tickets.forEach(ticket => {
    const ticketItem = document.createElement('li');
    ticketItem.innerHTML = `
    Artist Name: <span contenteditable="true" id="ticket-artistName-${ticket.ticketId}">${ticket.artistName}</span>,
      Session Time: <span contenteditable="true" id="ticket-time-${ticket.ticketId}">${ticket.sessionTime}</span>,
      Date: <span contenteditable="true" id="ticket-date-${ticket.ticketId}">${ticket.sessionDate}</span>, 
      Venue: <span contenteditable="true" id="ticket-venue-${ticket.ticketId}">${ticket.venue}</span>, 
      Price: €<span contenteditable="true" id="ticket-price-${ticket.ticketId}">${ticket.ticketPrice}</span>
      <button onclick="saveTicket(${ticket.ticketId})">Save</button>
      <button onclick="deleteTicket(${ticket.ticketId})">Delete</button>

    `;
    ticketList.appendChild(ticketItem);
  });

  ticketContainer.appendChild(ticketList);
}

function saveTicket(ticketId) {
  const updatedTicket = {
    ticketId: ticketId,
    artistName: document.getElementById(`ticket-artistName-${ticketId}`).textContent,
    sessionTime: document.getElementById(`ticket-time-${ticketId}`).textContent,
    sessionDate: document.getElementById(`ticket-date-${ticketId}`).textContent,
    venue: document.getElementById(`ticket-venue-${ticketId}`).textContent,
    ticketPrice: document.getElementById(`ticket-price-${ticketId}`).textContent,
  };

  // Send POST request with the updated content of the updatedTicket
  fetch('http://localhost/api/danceevent/updateTicket', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(updatedTicket),
  })
  .then(response => {
    if (response.ok) {
      console.log('Ticket updated successfully');
    } else {
      throw new Error('Failed to update ticket');
    }
  })
  .catch(error => {
    console.error('Error updating ticket:', error);
  });
}

function deleteTicket(ticketId)
{
  const DeleteTicket = {
    ticketId: ticketId,
    artistName: document.getElementById(`ticket-artistName-${ticketId}`).textContent,
    sessionTime: document.getElementById(`ticket-time-${ticketId}`).textContent,
    sessionDate: document.getElementById(`ticket-date-${ticketId}`).textContent,
    venue: document.getElementById(`ticket-venue-${ticketId}`).textContent,
    ticketPrice: document.getElementById(`ticket-price-${ticketId}`).textContent,
  };
  fetch(`http://localhost/api/danceevent/deleteTicket`, {
    method: 'DELETE',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(DeleteTicket),
  })
  .then(response => {
    if (response.ok) {
      console.log('Ticket deleted successfully');
      loadTickets(); // Reload tickets to reflect changes
    } else {
      throw new Error('Failed to delete ticket');
    }
  })
  .catch(error => console.error('Error deleting ticket:', error));

}


function addTicket() {
  const ticketData = {
    artistName: document.getElementById('new-ticket-artistName').value,
    sessionTime: document.getElementById('new-ticket-sessionTime').value,
    sessionDate: document.getElementById('new-ticket-sessionDate').value,
    venue: document.getElementById('new-ticket-venue').value,
    ticketPrice: document.getElementById('new-ticket-price').value,
  };


  fetch('http://localhost/api/danceevent/addTicket', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(ticketData),
  })
  .then(response => response.json())
  .then(data => {
    console.log('Ticket added successfully:', data);
    showTickets(); // Reload tickets list
  })
  .catch(error => console.error('Error adding ticket:', error));
}



//////////////////////finish update data///////////////////////







