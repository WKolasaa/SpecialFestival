//Ticket means session
// TODO: change the naming to make it more clear and aligned with the database
////////////sidebar/////////////////////
function showArtists() {
  document.getElementById('artists-container').style.display = 'flex';
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
  document.getElementById('artists-container').style.display = 'none';
  document.getElementById('add-btn').style.display = 'none';




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


document.getElementById('artistForm').addEventListener('submit', function(event) {
  event.preventDefault(); // Prevent the form from being submitted normally
  addArtist(); // Replace this with your function to add the artist
  loadArtists(); // Reload the artists
});


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
  fetch("http://localhost/api/danceevent/sessions")
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
  artistContainer.className = 'row'; // Add Bootstrap row class

  const heading = document.createElement('h2');
  heading.textContent = 'Artists'; // Set the heading text
  artistContainer.appendChild(heading);

  artists.forEach(artist => {
    const artistCard = document.createElement('div');
    artistCard.className = 'artist-card col-sm-4'; // Add Bootstrap column class
    
    const artistImageInput = document.createElement('input');
    artistImageInput.type = 'file';
    artistImageInput.id = `artist-image-${artist.artistId}`;
    artistImageInput.style.display = 'none';
    artistCard.appendChild(artistImageInput);

    const artistImage = document.createElement('img');
    artistImage.src = `../../img/DanceEvent/${artist.imageName}`; // Set the image source
    artistImage.onclick=()=>artistImageInput.click();
    artistCard.appendChild(artistImage);

  const artistNameLabel = document.createElement('span');
  artistNameLabel.textContent = 'Name: ';
  artistCard.appendChild(artistNameLabel);

  const artistName = document.createElement('span');
  artistName.contentEditable = 'true';
  artistName.id = `artist-name-${artist.artistId}`;
  artistName.textContent = artist.artistName;
  artistNameLabel.appendChild(artistName);

  const artistStyleLabel = document.createElement('span');
  artistStyleLabel.textContent = 'Style: ';
  artistCard.appendChild(artistStyleLabel);

  const artistStyle = document.createElement('span');
  artistStyle.contentEditable = 'true';
  artistStyle.id = `artist-style-${artist.artistId}`;
  artistStyle.textContent = artist.style;
  artistStyleLabel.appendChild(artistStyle);


  const artistDescriptionLabel = document.createElement('span');
  artistDescriptionLabel.textContent = 'Description: ';
  artistCard.appendChild(artistDescriptionLabel);

  const artistDescription = document.createElement('span');
  artistDescription.contentEditable = 'true';
  artistDescription.id = `artist-description-${artist.artistId}`;
  artistDescription.textContent = artist.description;
  artistDescriptionLabel.appendChild(artistDescription);

  const artistTitleLabel = document.createElement('span');
  artistTitleLabel.textContent = 'Title: ';
  artistCard.appendChild(artistTitleLabel);

  const artistTitle = document.createElement('span');
  artistTitle.contentEditable = 'true';
  artistTitle.id = `artist-title-${artist.artistId}`;
  artistTitle.textContent = artist.title;
  artistTitleLabel.appendChild(artistTitle);

  const artistDateLabel = document.createElement('span');
  artistDateLabel.textContent = 'Participation Date: ';
  artistCard.appendChild(artistDateLabel);

  const artistDate = document.createElement('span');
  artistDate.contentEditable = 'true';
  artistDate.id = `artist-date-${artist.artistId}`;
  artistDate.textContent = artist.participationDate;
  artistDateLabel.appendChild(artistDate);

  const saveButton = document.createElement('button');
  saveButton.className = 'btn btn-success buttons'; // Apply Bootstrap button styling
  saveButton.onclick = () => saveArtist(artist.artistId);
  saveButton.textContent = 'Save';
  artistCard.appendChild(saveButton);
  
  const deleteButton = document.createElement('button');
  deleteButton.className = 'btn btn-danger buttons'; // Apply Bootstrap button styling for a delete button
  deleteButton.onclick = () => deleteArtist(artist.artistId);
  deleteButton.textContent = 'Delete';
  artistCard.appendChild(deleteButton);

    artistContainer.appendChild(artistCard);
  });
}

function saveArtist(artistId) {
  // Collect the updated artist details from the content-editable elements
  const artistNameElement = document.getElementById(`artist-name-${artistId}`);
  const artistStyleElement = document.getElementById(`artist-style-${artistId}`);
  const artistDescriptionElement = document.getElementById(`artist-description-${artistId}`);
  const artistTitleElement = document.getElementById(`artist-title-${artistId}`);
  const artistDateElement = document.getElementById(`artist-date-${artistId}`);
  const artistImageElement = document.getElementById(`artist-image-${artistId}`);

  const updatedArtist = {
    artistId: artistId,
    artistName: artistNameElement.textContent,
    style: artistStyleElement.textContent,
    description: artistDescriptionElement.textContent,
    title: artistTitleElement.textContent,
    participationDate: artistDateElement.textContent,
    image: artistImageElement.files[0],
  };
  console.log(artistImageElement);
console.log(artistImageElement.files[0]);
console.log("testing: "+ updatedArtist.artistId + updatedArtist.artistName + updatedArtist.style + updatedArtist.description + updatedArtist.title + updatedArtist.participationDate + updatedArtist.image);

  // Create a FormData object to hold the updated artist details
 
   // Initialize FormData with the text content
   const formData = new FormData();
   formData.append('artistId', artistId);
   formData.append('artistName', artistNameElement.textContent);
   formData.append('style', artistStyleElement.textContent);
    formData.append('description', artistDescriptionElement.textContent);
    formData.append('title', artistTitleElement.textContent);
   formData.append('participationDate', artistDateElement.textContent);
 
   // Only add the image to the FormData if a new image has been selected
   if (artistImageElement.files.length > 0) {
     formData.append('image', artistImageElement.files[0]);
   }
  // Send POST request with the updated content of the updatedArtist
  fetch('http://localhost/api/danceevent/updateArtist', {
    method: 'POST',
    body: formData,
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
  const DeletedArtist = {
    artistId: artistId,
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
      // loadArtists(); // Reload artists to reflect changes
    } else {
      throw new Error('Failed to delete artist');
    }
  })
  .catch(error => console.error('Error deleting artist:', error));
}



async function addArtist(event) {
  event.preventDefault(); // Prevent the default form submission behavior
  const formData = new FormData(document.getElementById('artistForm'));

  // Debugging: Log FormData contents
  console.log("FormData contents:");
  for (let [key, value] of formData.entries()) {
      console.log(`${key}: ${value}`);
  }

  try {
      console.log("Sending request to add artist");
      const response = await fetch('http://localhost/api/danceevent/addArtist', {
          method: 'POST',
          body: formData,
      });
      console.log("Received response", response);

      if (!response.ok) {
          throw new Error('Failed to add artist');
      }
      console.log("Received response", response);
      const responseText = await response.text();
      console.log("Response text:", responseText);
      const data = JSON.parse(responseText); // Parse JSON response

      // const data = await response.json(); // Parse JSON response
      console.log("Parsed JSON response", data); // Debugging: Log parsed JSON

      if (data.success) {
          alert(data.message); // Show success message
      } else {
          throw new Error(data.error || 'Unknown error occurred');
      }

      document.getElementById('artistForm').reset(); // Reset the form only on success
  } catch (error) {
      console.error('Error adding artist:', error);
      alert(error.message); // Show error message to the user
  }
}

document.addEventListener('DOMContentLoaded', function() {
  document.getElementById('artistForm').addEventListener('submit', addArtist);
});






//////////////////////////Agenda//////////////////////////

function displayAgenda(agendas) {
  const agendaContainer = document.getElementById('agenda-container');
  agendaContainer.innerHTML = ''; // Clear existing content
  agendaContainer.classList.add('container'); // Add Bootstrap container class

  const heading = document.createElement('h2');
  heading.textContent = 'Agendas'; // Set the heading text
  heading.classList.add('my-3'); // Add Bootstrap margin class
  agendaContainer.appendChild(heading);

  agendas.forEach(agenda => {
    const agendaItem = document.createElement('div');
    agendaItem.classList.add('cardTicket', 'mb-3'); // Use the same custom class as for tickets

    agendaItem.innerHTML = `
      <div class="card-body">
        <h5 class="card-title"><span contenteditable="true" id="agenda-Artist-${agenda.agendaId}">${agenda.artistName}</span></h5>
        <p class="card-text">
          Event Day: <span contenteditable="true" id="agenda-day-${agenda.agendaId}">${agenda.eventDay}</span>
          Date: <span contenteditable="true" id="agenda-date-${agenda.agendaId}">${agenda.eventDate}</span>
          Time: <span contenteditable="true" id="agenda-time-${agenda.agendaId}">${agenda.eventTime}</span>
          Duration: <span contenteditable="true" id="agenda-duration-${agenda.agendaId}">${agenda.durationMinutes} min</span>
          Price: €<span contenteditable="true" id="agenda-price-${agenda.agendaId}">${agenda.sessionPrice}</span> 
          Tickets Available: <span contenteditable="true" id="agenda-tickets-${agenda.agendaId}">${agenda.sessionsAvailable}</span><br>
          Venue: <span contenteditable="true" id="agenda-venue-${agenda.agendaId}">${agenda.venueAddress}</span>
        </p>
        <button class="btn btn-success btnTicket" onclick="saveAgenda(${agenda.agendaId})">Save</button>
        <button class="btn btn-danger btnTicket" onclick="deleteAgenda(${agenda.agendaId})">Delete</button>
      </div>
    `;

    agendaContainer.appendChild(agendaItem);
  });
}
function saveAgenda(agendaId) {
  const updatedAgenda = {
    agendaId: agendaId,
    artistName: document.getElementById(`agenda-Artist-${agendaId}`).textContent,
    eventDay: document.getElementById(`agenda-day-${agendaId}`).textContent,
    eventDate: document.getElementById(`agenda-date-${agendaId}`).textContent,
    eventTime: document.getElementById(`agenda-time-${agendaId}`).textContent,
    durationMinutes: document.getElementById(`agenda-duration-${agendaId}`).textContent.replace(' min', ''),
    sessionPrice: document.getElementById(`agenda-price-${agendaId}`).textContent,
    sessionsAvailable: document.getElementById(`agenda-tickets-${agendaId}`).textContent,
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
    sessionPrice: document.getElementById(`agenda-price-${agendaId}`).textContent,
    sessionsAvailable: document.getElementById(`agenda-tickets-${agendaId}`).textContent,
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
    sessionPrice: document.getElementById('new-event-ticketPrice').value,
    sessionsAvailable: document.getElementById('new-event-ticketsAvailable').value,
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
    alert('Event added successfully');
    showAgenda(); // Reload events list
  })
  .catch(error => console.error('Error adding event:', error));
}



//////////////////////////Tickets//////////////////////////

function displayTickets(tickets) {
  const ticketContainer = document.getElementById('tickets-container');
  ticketContainer.innerHTML = ''; // Clear existing content
  ticketContainer.classList.add('container'); // Add Bootstrap container class

  const heading = document.createElement('h2');
  heading.textContent = 'Sessions'; // Set the heading text
  heading.classList.add('my-3'); // Add Bootstrap margin class
  ticketContainer.appendChild(heading);

  tickets.forEach(ticket => {
    const ticketItem = document.createElement('div');
    ticketItem.classList.add('cardTicket', 'mb-3'); // Add Bootstrap card and margin classes

    ticketItem.innerHTML = `
      <div class="card-body">
        <h5 class="card-title"><span contenteditable="true" id="ticket-artistName-${ticket.sessionId}">${ticket.artistName}</span></h5>
        <p class="card-text">
          Start Session: <input type="time" id="ticket-startSession-${ticket.sessionId}" value="${ticket.startSession}">
          End Session: <input type="time" id="ticket-endSession-${ticket.sessionId}" value="${ticket.endSession}">
          Date: <span contenteditable="true" id="ticket-date-${ticket.sessionId}">${ticket.sessionDate}</span>
          Venue: <span contenteditable="true" id="ticket-venue-${ticket.sessionId}">${ticket.venue}</span>
          Price: €<span contenteditable="true" id="ticket-price-${ticket.sessionId}">${ticket.sessionPrice}</span>
          Session Type: <span contenteditable="true" id="ticket-sessionType-${ticket.sessionId}">${ticket.sessionType}</span>
        </p>
        <button class="btn btn-success btnTicket" onclick="saveTicket(${ticket.sessionId})">Save</button>
        <button class="btn btn-danger btnTicket" onclick="deleteTicket(${ticket.sessionId})">Delete</button>
      </div>
    `;

    ticketContainer.appendChild(ticketItem);
  });
}

function saveTicket(sessionId) {
  // console.log('saveTicket called: ', ticketId);
  const updatedTicket = {
    sessionId: sessionId,
    artistName: document.getElementById(`ticket-artistName-${sessionId}`).textContent,
    startSession: document.getElementById(`ticket-startSession-${sessionId}`).value,// change
    sessionDate: document.getElementById(`ticket-date-${sessionId}`).textContent,
    venue: document.getElementById(`ticket-venue-${sessionId}`).textContent,
    sessionPrice: document.getElementById(`ticket-price-${sessionId}`).textContent,
    // sessionPrice: parseFloat(document.getElementById(`ticket-price-${ticketId}`).textContent.replace('€', '')),
    // sessionPrice: parseFloat(document.getElementById(`ticket-price-${ticketId}`).textContent.replace('€', '')),
     sessionType: document.getElementById(`ticket-sessionType-${sessionId}`).textContent,
    endSession: document.getElementById(`ticket-endSession-${sessionId}`).value,//change

  };

  // Send POST request with the updated content of the updatedTicket
  fetch('http://localhost/api/danceevent/updateSession', {
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

function deleteTicket(sessionId)
{
  const DeleteTicket = {
    sessionId: sessionId,
    artistName: document.getElementById(`ticket-artistName-${sessionId}`).textContent,
    startSession: document.getElementById(`ticket-startSession-${sessionId}`).textContent,
    sessionDate: document.getElementById(`ticket-date-${sessionId}`).textContent,
    venue: document.getElementById(`ticket-venue-${sessionId}`).textContent,
    sessionPrice: document.getElementById(`ticket-price-${sessionId}`).textContent,
    sessionType: document.getElementById(`ticket-sessionType-${sessionId}`).textContent,
    endSession: document.getElementById(`ticket-endSession-${sessionId}`).textContent,
  };
  fetch(`http://localhost/api/danceevent/deleteSession`, {
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
    startSession: document.getElementById('new-ticket-startSession').value,
    sessionDate: document.getElementById('new-ticket-sessionDate').value,
    venue: document.getElementById('new-ticket-venue').value,
    sessionPrice: document.getElementById('new-ticket-price').value,
    sessionType: document.getElementById('new-ticket-sessionType').value,
    endSession: document.getElementById('new-ticket-endSession').value,
  };
  console.log('Ticket data:', ticketData);


  fetch('http://localhost/api/danceevent/addSession', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
    },
    body: JSON.stringify(ticketData),
  })
  .then(response => response.json())
  .then(data => {
    console.log('Ticket added successfully:', data);
 //   showTickets(); // Reload tickets list
  })
  .catch(error => console.error('Error adding ticket:', error));
}



//////////////////////finish update data///////////////////////







