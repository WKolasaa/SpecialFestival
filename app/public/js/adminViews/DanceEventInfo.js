loadArtists();
loadAgenda();
loadTickets();
loadOverviews();

////////////SideBar/////////////////////
function showArtists() {
  document.getElementById("artists-container").style.display = "flex";
  document.getElementById("agenda-container").style.display = "none";
  document.getElementById("tickets-container").style.display = "none";
  document.getElementById("danceOverview-container").style.display="none";
  const addButton = document.getElementById("add-btn");
  addButton.innerText = `Add Artist`;
  addButton.onclick = showAddArtistForm; // Assign the onclick handler here

  loadArtists();
}

function showAgenda() {
  document.getElementById("artists-container").style.display = "none";
  document.getElementById("agenda-container").style.display = "block";
  document.getElementById("tickets-container").style.display = "none";
  document.getElementById("danceOverview-container").style.display="none";

  const addButton = document.getElementById("add-btn");
  addButton.innerText = `Add Event`;
  addButton.onclick = showAddAgendaForm; // Assign the onclick handler here

  loadAgenda();
}

function showTickets() {
  document.getElementById("artists-container").style.display = "none";
  document.getElementById("agenda-container").style.display = "none";
  document.getElementById("tickets-container").style.display = "block";
  document.getElementById("danceOverview-container").style.display="none";

  const addButton = document.getElementById("add-btn");
  addButton.innerText = `Add Ticket`;
  addButton.onclick = showAddTicketForm; // Assign the onclick handler here

  loadTickets();
}

function showOverview() {
  document.getElementById("artists-container").style.display = "none";
  document.getElementById("agenda-container").style.display = "none";
  document.getElementById("tickets-container").style.display = "none";
  document.getElementById("danceOverview-container").style.display = "block";
  const addButton = document.getElementById("add-btn");
  addButton.innerText = `Add Overview`;
  addButton.onclick = showAddOverviewForm; // Assign the onclick handler here
  loadOverviews();
}
////////////////////End of SideBar//////////////////////////


//////////////////////Adjusting the Form///////////////////////
function showAddArtistForm() {
  // Get the modal
  var modal = document.getElementById("add-artist-modal");
  var form = document.getElementById("add-artist-form");

  var span = modal.getElementsByClassName("close")[0];

  span.onclick = function () {
    modal.style.display = "none";
    form.style.display = "none"; 
  };

  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
      form.style.display = "none"; 
    }
  };
  modal.style.display = "block";
  form.style.display = "block";
}


function showAddAgendaForm() {
  var modal = document.getElementById("add-agenda-modal");
  var form = document.getElementById("add-agenda-form");
  var span = modal.getElementsByClassName("close")[0];

  span.onclick = function () {
    modal.style.display = "none";
    form.style.display = "none";
  };

  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
      form.style.display = "none";
    }
  };

  modal.style.display = "block";
  form.style.display = "block";
}

function showAddTicketForm() {
  var modal = document.getElementById("add-ticket-modal");
  var form = document.getElementById("add-ticket-form");
  var span = modal.getElementsByClassName("close")[0];

  span.onclick = function () {
    modal.style.display = "none";
    form.style.display = "none";
  };

  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
      form.style.display = "none";
    }
  };

  modal.style.display = "block";
  form.style.display = "block";
}

function showAddOverviewForm() {
 
  var modal = document.getElementById("add-overview-modal");
  var form = document.getElementById("add-overview-form");

  
  var span = modal.getElementsByClassName("close")[0];

  
  span.onclick = function () {
    modal.style.display = "none";
    form.style.display = "none"; 
  };

  
  window.onclick = function (event) {
    if (event.target == modal) {
      modal.style.display = "none";
      form.style.display = "none"; 
    }
  };

  
  modal.style.display = "block";
  form.style.display = "block";
}

document
  .getElementById("artistForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); 
    addArtist(); 
    loadArtists(); 
  });



document
  .getElementById("overviewForm")
  .addEventListener("submit", function (event) {
    event.preventDefault(); 
    addOverview(); 
    loadOverviews();
  });



  function validateAgendaForm() {
    const venue = document.getElementById('new-event-venueAddress').value;
    const ticketsAvailable = document.getElementById('new-event-ticketsAvailable').value;
    const time = document.getElementById('new-event-time').value;
    const duration = document.getElementById('new-event-duration').value;
    const price = document.getElementById('new-event-ticketPrice').value;
  
    if (typeof venue !== 'string' || venue.trim() === '') {
      alert('Venue must be a string and cannot be empty');
      return false;
    }
  
    if (isNaN(ticketsAvailable) || ticketsAvailable <= 0) {
      alert('Tickets Available must be a positive number');
      return false;
    }
  
    if (time === '') {
      alert('Time cannot be empty');
      return false;
    }
  
    if (isNaN(duration) || duration <= 0) {
      alert('Duration must be a positive number');
      return false;
    }
  
    if (isNaN(price) || price <= 0) {
      alert('Price must be a positive number');
      return false;
    }
  
    // Add more validations as needed
  
    return true;
  }
  
  function validateSessionForm() {
    const sessionType = document.getElementById('new-ticket-sessionType').value;
    const price = document.getElementById('new-ticket-price').value;
  
    if (typeof sessionType !== 'string' || sessionType.trim() === '') {
      alert('Session Type must be a string and cannot be empty');
      return false;
    }
  
    if (isNaN(price) || price <= 0) {
      alert('Price must be a positive number');
      return false;
    }
  
    // Add more validations as needed
  
    return true;
  }

//////////////////////fetch data///////////////////////

let allArtists = [];
function loadArtists() {
  fetch("http://localhost/api/danceevent/Artists")
    .then((response) => response.json())
    .then((data) => {
      allArtists = data; // Store all users in the array
      displayArtists(allArtists); // Display all users by default
    })
    .catch((error) => {
      console.error("Error fetching items:", error);
    });
}

let allAgenda = [];
function loadAgenda() {
  fetch("http://localhost/api/danceevent/Agenda")
    .then((response) => {
      return response.json();
    })
    .then((data) => {
     
      allAgenda = data;
      displayAgenda(allAgenda);
    })
    .catch((error) => {
      console.error("Error fetching items:", error);
    });
}

let allTickets = [];
function loadTickets() {
  fetch("http://localhost/api/danceevent/sessions")
    .then((response) => response.json())
    .then((data) => {
      allTickets = data; // Store all users in the array
      displayTickets(allTickets); // Display all users by default
    })
    .catch((error) => {
      console.error("Error fetching items:", error);
    });
}

let overviews = [];
function loadOverviews() {
  fetch("http://localhost/api/danceevent/danceOverviews")
    .then((response) => response.json())
    .then((data) => {
      overviews = data; // Store all users in the array
      displayOverviews(overviews); // Display all users by default
    })
    .catch((error) => {
      console.error("Error fetching items:", error);
    });
}

//////////////////////finish fetch data///////////////////////

///////////////////////CRUD Artist data///////////////////////
function displayArtists(artists) {
  const artistContainer = document.getElementById("artists-container");
  artistContainer.innerHTML = ""; // Clear existing content
  artistContainer.className = "row"; // Add Bootstrap row class

  const heading = document.createElement("h2");
  heading.textContent = "Artists"; // Set the heading text
  artistContainer.appendChild(heading);

  artists.forEach((artist) => {
    const artistCard = document.createElement("div");
    artistCard.className = "artist-card col-sm-4"; // Add Bootstrap column class

    const artistImageInput = document.createElement("input");
    artistImageInput.type = "file";
    artistImageInput.id = `artist-image-${artist.artistId}`;
    artistImageInput.style.display = "none";
    artistCard.appendChild(artistImageInput);

    const artistImage = document.createElement("img");
    artistImage.src = `../../img/DanceEvent/${artist.imageName}`; // Set the image source
    artistImage.onclick = () => artistImageInput.click();
    artistCard.appendChild(artistImage);

    const artistNameLabel = document.createElement("span");
    artistNameLabel.textContent = "Name: ";
    artistCard.appendChild(artistNameLabel);

    const artistName = document.createElement("span");
    artistName.contentEditable = "true";
    artistName.id = `artist-name-${artist.artistId}`;
    artistName.textContent = artist.artistName;
    artistNameLabel.appendChild(artistName);

    const artistStyleLabel = document.createElement("span");
    artistStyleLabel.textContent = "Style: ";
    artistCard.appendChild(artistStyleLabel);

    const artistStyle = document.createElement("span");
    artistStyle.contentEditable = "true";
    artistStyle.id = `artist-style-${artist.artistId}`;
    artistStyle.textContent = artist.style;
    artistStyleLabel.appendChild(artistStyle);

    const artistDescriptionLabel = document.createElement("span");
    artistDescriptionLabel.textContent = "Description: ";
    artistCard.appendChild(artistDescriptionLabel);

    const artistDescription = document.createElement("span");
    artistDescription.contentEditable = "true";
    artistDescription.id = `artist-description-${artist.artistId}`;
    artistDescription.textContent = artist.description;
    artistDescriptionLabel.appendChild(artistDescription);

    const artistTitleLabel = document.createElement("span");
    artistTitleLabel.textContent = "Title: ";
    artistCard.appendChild(artistTitleLabel);

    const artistTitle = document.createElement("span");
    artistTitle.contentEditable = "true";
    artistTitle.id = `artist-title-${artist.artistId}`;
    artistTitle.textContent = artist.title;
    artistTitleLabel.appendChild(artistTitle);

    const artistDateLabel = document.createElement("span");
    artistDateLabel.textContent = "Participation Date: ";
    artistCard.appendChild(artistDateLabel);

    const artistDate = document.createElement("select");
    artistDate.id = `artist-date-${artist.artistId}`;

    const dates = ["2024-07-26", "2024-07-27", "2024-07-28"];
    dates.forEach((date) => {
      const option = document.createElement("option");
      option.value = date;
      
      const [year, month, day] = date.split("-");
      option.text = `${day}-${month}-${year}`;

      if (date === artist.participationDate) {
        option.selected = true;
      }
      artistDate.appendChild(option);
    });

    artistDateLabel.appendChild(artistDate);

    const saveButton = document.createElement("button");
    saveButton.className = "btn btn-success buttons";
    saveButton.onclick = () => saveArtist(artist.artistId);
    saveButton.textContent = "Save";
    artistCard.appendChild(saveButton);

    const deleteButton = document.createElement("button");
    deleteButton.className = "btn btn-danger buttons";
    deleteButton.onclick = () => deleteArtist(artist.artistId);
    deleteButton.textContent = "Delete";
    artistCard.appendChild(deleteButton);

    artistContainer.appendChild(artistCard);
  });
}

function saveArtist(artistId) {
  // Collect the updated artist details from the content-editable elements
  const artistNameElement = document.getElementById(`artist-name-${artistId}`);
  const artistStyleElement = document.getElementById(
    `artist-style-${artistId}`
  );
  const artistDescriptionElement = document.getElementById(
    `artist-description-${artistId}`
  );
  const artistTitleElement = document.getElementById(
    `artist-title-${artistId}`
  );
  const artistDateElement = document.getElementById(`artist-date-${artistId}`);
  const artistImageElement = document.getElementById(
    `artist-image-${artistId}`
  );

  const updatedArtist = {
    artistId: artistId,
    artistName: artistNameElement.textContent,
    style: artistStyleElement.textContent,
    description: artistDescriptionElement.textContent,
    title: artistTitleElement.textContent,
    participationDate: artistDateElement.value,
    image: artistImageElement.files[0],
  };
  console.log(artistImageElement);
  console.log(artistImageElement.files[0]);
  console.log(
    "testing: " +
      updatedArtist.artistId +
      updatedArtist.artistName +
      updatedArtist.style +
      updatedArtist.description +
      updatedArtist.title +
      updatedArtist.participationDate +
      updatedArtist.image
  );

  // Create a FormData object to hold the updated artist details

  // Initialize FormData with the text content
  const formData = new FormData();
  formData.append("artistId", artistId);
  formData.append("artistName", artistNameElement.textContent);
  formData.append("style", artistStyleElement.textContent);
  formData.append("description", artistDescriptionElement.textContent);
  formData.append("title", artistTitleElement.textContent);
  formData.append("participationDate", artistDateElement.value);

  // Only add the image to the FormData if a new image has been selected
  if (artistImageElement.files.length > 0) {
    formData.append("image", artistImageElement.files[0]);
  }
  // Send POST request with the updated content of the updatedArtist
  fetch("http://localhost/api/danceevent/updateArtist", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (response.ok) {
        console.log("Artist updated successfully");

        if (artistImageElement.files.length > 0) {
          const updatedImage = document.querySelector(
            `#artist-image-${artistId}`
          );
          updatedImage.src = URL.createObjectURL(artistImageElement.files[0]);
        }
      } else {
        if (response.status === 413) {
          // If the status code is 413, throw a specific error message
          throw new Error(
            "The image file is too large. Please select a smaller file."
          );
        } else {
          // Check the Content-Type of the response
          const contentType = response.headers.get("content-type");
          if (contentType && contentType.indexOf("application/json") !== -1) {
            // If the Content-Type is JSON, parse the response body and throw an error
            return response.json().then((error) => {
              throw new Error(error.error);
            });
          } else {
            // If the Content-Type is not JSON, throw a generic error message
            throw new Error("An error occurred while updating the artist");
          }
        }
      }
    })
    .catch((error) => {
      // console.error("Error updating artist:", error);
      alert(error.message);
    });
}

function deleteArtist(artistId) {
  const DeletedArtist = {
    artistId: artistId,
  };
  fetch(`http://localhost/api/danceevent/deleteArtist`, {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(DeletedArtist),
  })
    .then((response) => {
      if (response.ok) {
        console.log("Artist deleted successfully");
        // loadArtists(); // Reload artists to reflect changes
      } else {
        throw new Error("Failed to delete artist");
      }
    })
    .catch((error) => console.error("Error deleting artist:", error));
}

async function addArtist(event) {
  event.preventDefault(); // Prevent the default form submission behavior
  const formData = new FormData(document.getElementById("artistForm"));

  // Debugging: Log FormData contents
  console.log("FormData contents:");
  for (let [key, value] of formData.entries()) {
    console.log(`${key}: ${value}`);
  }

  try {
    console.log("Sending request to add artist");
    const response = await fetch("http://localhost/api/danceevent/addArtist", {
      method: "POST",
      body: formData,
    });
    console.log("Received response", response);

    if (!response.ok) {
      throw new Error("Failed to add artist");
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
      throw new Error(data.error || "Unknown error occurred");
    }

    document.getElementById("artistForm").reset(); // Reset the form only on success
  } catch (error) {
    console.error("Error adding artist:", error);
    alert(error.message); // Show error message to the user
  }
}

document.addEventListener("DOMContentLoaded", function () {
  document.getElementById("artistForm").addEventListener("submit", addArtist);
});


//////////////////////////CRUD Agenda data//////////////////////////

function displayAgenda(agendas) {
  const agendaContainer = document.getElementById("agenda-container");
  agendaContainer.innerHTML = ""; // Clear existing content
  agendaContainer.classList.add("container"); // Add Bootstrap container class

  const heading = document.createElement("h2");
  heading.textContent = "Agendas"; // Set the heading text
  heading.classList.add("my-3"); // Add Bootstrap margin class
  agendaContainer.appendChild(heading);

  agendas.forEach((agenda) => {
    const agendaItem = document.createElement("div");
    agendaItem.classList.add("cardTicket", "mb-3"); // Use the same custom class as for tickets

    agendaItem.innerHTML = `
      <div class="card-body">
        <h5 class="card-title"><span contenteditable="true" id="agenda-Artist-${
          agenda.agendaId
        }">${agenda.artistName}</span></h5>
        <p class="card-text">
          Event Day: <select id="agenda-day-${agenda.agendaId}">
          <option value="Friday" ${
            agenda.eventDay === "Friday" ? "selected" : ""
          }>Friday</option>
          <option value="Saturday" ${
            agenda.eventDay === "Saturday" ? "selected" : ""
          }>Saturday</option>
          <option value="Sunday" ${
            agenda.eventDay === "Sunday" ? "selected" : ""
          }>Sunday</option>
        </select>
          Date: <select id="agenda-date-${agenda.agendaId}">
          <option value="2024-07-26" ${
            agenda.eventDate === "2024-07-26" ? "selected" : ""
          }>26-07-2024</option>
          <option value="2024-07-27" ${
            agenda.eventDate === "2024-07-27" ? "selected" : ""
          }>27-07-2024</option>
          <option value="2024-07-28" ${
            agenda.eventDate === "2024-07-28" ? "selected" : ""
          }>28-07-2024</option>
        </select>
          Time: <span contenteditable="true" id="agenda-time-${
            agenda.agendaId
          }">${agenda.eventTime}</span>
          Duration: <span contenteditable="true" id="agenda-duration-${
            agenda.agendaId
          }">${agenda.durationMinutes} min</span>
          Price: €<span contenteditable="true" id="agenda-price-${
            agenda.agendaId
          }">${agenda.sessionPrice}</span> 
          Tickets Available: <span contenteditable="true" id="agenda-tickets-${
            agenda.agendaId
          }">${agenda.sessionsAvailable}</span><br>
          Venue: <span contenteditable="true" id="agenda-venue-${
            agenda.agendaId
          }">${agenda.venueAddress}</span>
        </p>
        <button class="btn btn-success btnTicket" onclick="saveAgenda(${
          agenda.agendaId
        })">Save</button>
        <button class="btn btn-danger btnTicket" onclick="deleteAgenda(${
          agenda.agendaId
        })">Delete</button>
      </div>
    `;

    agendaContainer.appendChild(agendaItem);
  });
}
function saveAgenda(agendaId) {
  const updatedAgenda = {
    agendaId: agendaId,
    artistName: document.getElementById(`agenda-Artist-${agendaId}`)
      .textContent,
    eventDay: document.getElementById(`agenda-day-${agendaId}`).value,
    eventDate: document.getElementById(`agenda-date-${agendaId}`).value,
    eventTime: document.getElementById(`agenda-time-${agendaId}`).textContent,
    durationMinutes: document
      .getElementById(`agenda-duration-${agendaId}`)
      .textContent.replace(" min", ""),
    sessionPrice: document.getElementById(`agenda-price-${agendaId}`)
      .textContent,
    sessionsAvailable: document.getElementById(`agenda-tickets-${agendaId}`)
      .textContent,
    venueAddress: document.getElementById(`agenda-venue-${agendaId}`)
      .textContent,
  };
  const selectedDay = updatedAgenda.eventDay;
  const selectedDate = updatedAgenda.eventDate;

  if (getDayOfWeek(selectedDate) !== selectedDay) {
    alert(
      "The selected day does not match the selected date. Please select a matching day and date."
    );
    return; // Exit the function early if the day and date don't match
  }

  // Send POST request with the updated content of the updatedAgenda
  fetch("http://localhost/api/danceevent/updateAgenda", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(updatedAgenda),
  })
    .then((response) => {
      if (response.ok) {
        console.log("Agenda updated successfully");
        alert("Event updated successfully");
      } else {
        throw new Error("Failed to update agenda");
      }
    })
    .catch((error) => {
      console.error("Error updating agenda:", error);
    });
}
function deleteAgenda(agendaId) {
  const DeletedAgenda = {
    agendaId: agendaId,
    artistName: document.getElementById(`agenda-Artist-${agendaId}`)
      .textContent,
    eventDay: document.getElementById(`agenda-day-${agendaId}`).textContent,
    eventDate: document.getElementById(`agenda-date-${agendaId}`).textContent,
    eventTime: document.getElementById(`agenda-time-${agendaId}`).textContent,
    durationMinutes: document
      .getElementById(`agenda-duration-${agendaId}`)
      .textContent.replace(" min", ""),
    sessionPrice: document.getElementById(`agenda-price-${agendaId}`)
      .textContent,
    sessionsAvailable: document.getElementById(`agenda-tickets-${agendaId}`)
      .textContent,
    venueAddress: document.getElementById(`agenda-venue-${agendaId}`)
      .textContent,
  };
  fetch(`http://localhost/api/danceevent/deleteAgenda`, {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(DeletedAgenda),
  })
    .then((response) => {
      if (response.ok) {
        alert("Event Deleted successfully");
        loadAgenda(); 
      } else {
        throw new Error("Failed to delete agenda");
      }
    })
    .catch((error) => console.error("Error deleting agenda:", error));
}

function addEvent() {
  // Collect input values...
  const eventData = {
    artistName: document.getElementById("new-event-artistName").value,
    eventDay: document.getElementById("new-event-day").value,
    eventDate: document.getElementById("new-event-date").value,
    eventTime: document.getElementById("new-event-time").value,

    durationMinutes: document.getElementById("new-event-duration").value,
    sessionPrice: document.getElementById("new-event-ticketPrice").value,
    sessionsAvailable: document.getElementById("new-event-ticketsAvailable")
      .value,
    venueAddress: document.getElementById("new-event-venueAddress").value,
  };
  const selectedDay = eventData.eventDay;
  const selectedDate = eventData.eventDate;
  const artistExists=allArtists.some(artist=>artist.artistName===eventData.artistName); //check if artist exists
  if(!artistExists)
  {
    alert("Artist doesn't exist, please provide correct artist name.")
    return;
  }

  if (getDayOfWeek(selectedDate) !== selectedDay) {
    alert(
      "The selected day does not match the selected date. Please select a matching day and date."
    );
    return; // Exit the function early if the day and date don't match
  }
  fetch("http://localhost/api/danceevent/addEvent", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(eventData),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Event added successfully:", data);
      alert("Event added successfully");
      showAgenda(); // Reload events list
    })
    .catch((error) => console.error("Error adding event:", error));
}

function getDayOfWeek(date) {
  const dateObject = new Date(date);
  const daysOfWeek = [
    "Sunday",
    "Monday",
    "Tuesday",
    "Wednesday",
    "Thursday",
    "Friday",
    "Saturday",
  ];
  return daysOfWeek[dateObject.getDay()];
}

//////////////////////////CRUD Ticket data//////////////////////////

function displayTickets(tickets) {
  const ticketContainer = document.getElementById("tickets-container");
  ticketContainer.innerHTML = ""; 
  ticketContainer.classList.add("container"); 

  const heading = document.createElement("h2");
  heading.textContent = "Sessions"; 
  heading.classList.add("my-3"); 
  ticketContainer.appendChild(heading);

  tickets.forEach((ticket) => {
    const ticketItem = document.createElement("div");
    ticketItem.classList.add("cardTicket", "mb-3"); 

    ticketItem.innerHTML = `
      <div class="card-body">
        <h5 class="card-title"><span contenteditable="true" id="ticket-artistName-${
          ticket.sessionId
        }">${ticket.artistName}</span></h5>
        <p class="card-text">
        Start Session: <input type="time" id="ticket-startSession-${
            ticket.sessionId
          }" value="${ticket.startSession}">
          End Session: <input type="time" id="ticket-endSession-${
            ticket.sessionId
          }" value="${ticket.endSession}">
          Date: <select id="ticket-date-${ticket.sessionId}">
                  <option value="2024-07-26" ${
                    ticket.sessionDate === "2024-07-26" ? "selected" : ""
                  }>26-07-2024</option>
                  <option value="2024-07-27" ${
                    ticket.sessionDate === "2024-07-27" ? "selected" : ""
                  }>27-07-2024</option>
                  <option value="2024-07-28" ${
                    ticket.sessionDate === "2024-07-28" ? "selected" : ""
                  }>28-07-2024</option>
                </select>
          Venue: <span contenteditable="true" id="ticket-venue-${
            ticket.sessionId
          }">${ticket.venue}</span>
          Price: €<span contenteditable="true" id="ticket-price-${
            ticket.sessionId
          }">${ticket.sessionPrice}</span>
          Session Type: <span contenteditable="true" id="ticket-sessionType-${
            ticket.sessionId
          }">${ticket.sessionType}</span>
        </p>
        <button class="btn btn-success btnTicket" onclick="saveTicket(${
          ticket.sessionId
        })">Save</button>
        <button class="btn btn-danger btnTicket" onclick="deleteTicket(${
          ticket.sessionId
        })">Delete</button>
      </div>
    `;

    ticketContainer.appendChild(ticketItem);
  });
}

function saveTicket(sessionId) {
  const updatedTicket = {
    sessionId: sessionId,
    artistName: document.getElementById(`ticket-artistName-${sessionId}`)
      .textContent,
    startSession: document.getElementById(`ticket-startSession-${sessionId}`)
      .value,
    sessionDate: document.getElementById(`ticket-date-${sessionId}`).value,
    venue: document.getElementById(`ticket-venue-${sessionId}`).textContent,
    sessionPrice: document.getElementById(`ticket-price-${sessionId}`)
      .textContent,
    
    sessionType: document.getElementById(`ticket-sessionType-${sessionId}`)
      .textContent,
    endSession: document.getElementById(`ticket-endSession-${sessionId}`).value, //change
  };

  fetch("http://localhost/api/danceevent/updateSession", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(updatedTicket),
  })
    .then((response) => {
      if (response.ok) {
        console.log("Ticket updated successfully");
        alert("Session updated successfully");
      } else {
        throw new Error("Failed to update ticket");
      }
    })
    .catch((error) => {
      console.error("Error updating ticket:", error);
    });
}

function deleteTicket(sessionId) {
  const DeleteTicket = {
    sessionId: sessionId,
    artistName: document.getElementById(`ticket-artistName-${sessionId}`)
      .textContent,
    startSession: document.getElementById(`ticket-startSession-${sessionId}`)
      .textContent,
    sessionDate: document.getElementById(`ticket-date-${sessionId}`)
      .textContent,
    venue: document.getElementById(`ticket-venue-${sessionId}`).textContent,
    sessionPrice: document.getElementById(`ticket-price-${sessionId}`)
      .textContent,
    sessionType: document.getElementById(`ticket-sessionType-${sessionId}`)
      .textContent,
    endSession: document.getElementById(`ticket-endSession-${sessionId}`)
      .textContent,
  };
  fetch(`http://localhost/api/danceevent/deleteSession`, {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(DeleteTicket),
  })
    .then((response) => {
      if (response.ok) {
        console.log("Ticket deleted successfully");
        alert("Session deleted successfully");
        loadTickets(); 
      } else {
        throw new Error("Failed to delete ticket");
      }
    })
    .catch((error) => console.error("Error deleting ticket:", error));
}

function addTicket() {
  const ticketData = {
    artistName: document.getElementById("new-ticket-artistName").value,
    startSession: document.getElementById("new-ticket-startSession").value,
    sessionDate: document.getElementById("new-ticket-sessionDate").value,
    venue: document.getElementById("new-ticket-venue").value,
    sessionPrice: document.getElementById("new-ticket-price").value,
    sessionType: document.getElementById("new-ticket-sessionType").value,
    endSession: document.getElementById("new-ticket-endSession").value,
  };
  console.log("Ticket data:", ticketData);
const artistExists=allArtists.some(artist=>artist.artistName===ticketData.artistName); //check if artist exists
if(!artistExists)
{
  alert("Artist doesn't exist, please provide correct artist name.")
  return;
}



  fetch("http://localhost/api/danceevent/addSession", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(ticketData),
  })
    .then((response) => response.json())
    .then((data) => {
      console.log("Ticket added successfully:", data);
      alert("Session added successfully");
      const modal = document.getElementById("add-ticket-modal");
      modal.style.display = "none";
      loadTickets(); // Reload tickets to reflect changes
    })
    .catch((error) => console.error("Error adding ticket:", error));
}



//////////////////////////CRUD Overview data//////////////////////////

function displayOverviews(overviews) {

  
  const overviewContainer = document.getElementById("danceOverview-container");
  overviewContainer.innerHTML = "";
  overviewContainer.className = "row";

  const heading = document.createElement("h2");
  heading.textContent = "Overviews";
  overviewContainer.appendChild(heading);

  overviews.forEach((overview) => {
    const overviewCard = document.createElement("div");
    overviewCard.className =
      "overview-card col-12 d-flex flex-column flex-md-row";
    overviewCard.style.alignItems = "flex-start";

    const textButtonContainer = document.createElement("div");
    textButtonContainer.className =
      "col-12 col-md-6 order-1 d-flex flex-column";
    overviewCard.appendChild(textButtonContainer);

    const textContainer = document.createElement("div");
    textContainer.style.marginTop = "20px";
    textButtonContainer.appendChild(textContainer);

    const overviewHeaderLabel = document.createElement("label");
    overviewHeaderLabel.textContent = "Header: ";
    textContainer.appendChild(overviewHeaderLabel);

    const overviewHeader = document.createElement("h3");
    overviewHeader.textContent = decodeHtmlEntities(overview.header);
    overviewHeader.contentEditable = "true";
    overviewHeader.id = `overview-header-${overview.id}`;
    textContainer.appendChild(overviewHeader);

    const overviewSubheaderLabel = document.createElement("label");
    overviewSubheaderLabel.textContent = "Subheader: ";
    textContainer.appendChild(overviewSubheaderLabel);

    const overviewSubheader = document.createElement("h4");
    overviewSubheader.textContent = decodeHtmlEntities(overview.subHeader);
    overviewSubheader.contentEditable = "true";
    overviewSubheader.id = `overview-subheader-${overview.id}`;
    textContainer.appendChild(overviewSubheader);

    const overviewTextLabel = document.createElement("span");
    overviewTextLabel.textContent = "Text: ";
    textContainer.appendChild(overviewTextLabel);

    const overviewText = document.createElement("span");
    overviewText.contentEditable = "true";
    overviewText.id = `overview-text-${overview.id}`;
    overviewText.textContent = decodeHtmlEntities(overview.text);
    overviewText.style.width = "100%";
    overviewTextLabel.appendChild(overviewText);

    const imageContainer = document.createElement("div");
    imageContainer.className = "col-12 col-md-6 order-2 order-md-3";
    imageContainer.style.marginTop = "20px";
    overviewCard.appendChild(imageContainer);

    const overviewImageInput = document.createElement("input");
    overviewImageInput.type = "file";
    overviewImageInput.id = `overview-image-${overview.id}`;
    overviewImageInput.style.display = "none";
    imageContainer.appendChild(overviewImageInput);

    const overviewImage = document.createElement("img");
    overviewImage.src = `../../img/DanceEvent/${overview.imageName}`;
    overviewImage.onclick = () => overviewImageInput.click();
    overviewImage.style.width = "300px";
    overviewImage.style.height = "300px";
    overviewImage.style.borderRadius = "10%";
    imageContainer.appendChild(overviewImage);

    const buttonContainer = document.createElement("div");
    buttonContainer.className = "d-flex justify-content-center";
    buttonContainer.style.marginTop = "20vh";
    textButtonContainer.appendChild(buttonContainer);

    const saveButton = document.createElement("button");
    saveButton.className = "btn btn-success buttons";
    saveButton.onclick = () => saveOverview(overview.id);
    saveButton.textContent = "Save";
    buttonContainer.appendChild(saveButton);

    const deleteButton = document.createElement("button");
    deleteButton.className = "btn btn-danger buttons";
    deleteButton.onclick = () => deleteOverview(overview.id);
    deleteButton.textContent = "Delete";
    buttonContainer.appendChild(deleteButton);

    overviewContainer.appendChild(overviewCard);
  });
}


function decodeHtmlEntities(str) {
  var textArea = document.createElement("textarea");
  textArea.innerHTML = str;
  return textArea.value;
}

function saveOverview(id) {
  const overviewHeaderElement = document.getElementById(
    `overview-header-${id}`
  );
  const overviewSubheaderElement = document.getElementById(
    `overview-subheader-${id}`
  );
  const overviewTextElement = document.getElementById(`overview-text-${id}`);
  const overviewImageElement = document.getElementById(`overview-image-${id}`);

  const updatedOverview = {
    id: id,
    header: overviewHeaderElement.textContent,
    subHeader: overviewSubheaderElement.textContent,
    text: overviewTextElement.textContent,
    image: overviewImageElement.files[0],
  };
  console.log(
    updatedOverview.id + updatedOverview.text + updatedOverview.image
  );

  const formData = new FormData();
  formData.append("id", id);
  formData.append("header", overviewHeaderElement.textContent);
  formData.append("subHeader", overviewSubheaderElement.textContent);
  formData.append("text", overviewTextElement.textContent);

  if (overviewImageElement.files.length > 0) {
    formData.append("image", overviewImageElement.files[0]);
  }

  fetch("http://localhost/api/danceevent/updateDanceOverView", {
    method: "POST",
    body: formData,
  })
    .then((response) => {
      if (response.ok) {
        console.log("Overview updated successfully");
      } else {
        throw new Error("Failed to update overview");
      }
    })
    .catch((error) => {
      console.error("Error updating overview:", error);
    });
}

function deleteOverview(id) {
  const DeleteOverview = {
    id: id,
  };
  fetch(`http://localhost/api/danceevent/deleteDanceOverview`, {
    method: "DELETE",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(DeleteOverview),
  })
    .then((response) => {
      if (response.ok) {
        console.log("Overview deleted successfully");
        //  loadOverviews(); // Reload overviews to reflect changes
      } else {
        throw new Error("Failed to delete overview");
      }
    })
    .catch((error) => console.error("Error deleting overview:", error));
}

async function addOverview(event) {
  event.preventDefault(); // Prevent the default form submission behavior
  const formData = new FormData(document.getElementById("overviewForm"));

  console.log("FormData contents:");
  for (let [key, value] of formData.entries()) {
    console.log(`${key}: ${value}`);
  }
  try {
    const response = await fetch(
      "http://localhost/api/danceevent/addDanceOverview",
      {
        method: "POST",
        body: formData,
      }
    );

    if (!response.ok) {
      throw new Error("Failed to add overview");
    }

    const data = await response.json(); // Parse JSON response

    if (data.success) {
      alert(data.message); // Show success message
    } else {
      throw new Error(data.error || "Unknown error occurred");
    }

    document.getElementById("overviewForm").reset(); // Reset the form only on success
  } catch (error) {
    console.error("Error adding overview:", error);
    alert(error.message); // Show error message to the user
  }
}

document.addEventListener("DOMContentLoaded", function () {
  document
    .getElementById("overviewForm")
    .addEventListener("submit", addOverview);
});
