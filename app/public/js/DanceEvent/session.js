let allSessions = [];
function loadSessions() {
  fetch("http://localhost/api/danceevent/sessions")
    .then((response) => response.json())
    .then((data) => {
      allSessions = data;
      displaySessions(allSessions);
      displayGoldenTicket(allSessions);
    })
    .catch((error) => {
      console.error("Error fetching items:", error);
    });
}

function displaySessions(sessions) { //TODO: check the method again
  // Get the template for the sessions
  const template = document.querySelector(".ticket");

  // Remove any existing session elements except the first one (the template)
  while (template.nextSibling) {
    template.nextSibling.remove();
  }

  // Loop over the sessions
  sessions.forEach((session) => {
    // Parse the sessionTime
    const date = new Date(session.sessionDate);
    let venueText = session.venue; /////////////

    if (session.artistName === "Golden Ticket") {
      return;
    }
    // Get the day, month, and year
    const day = date.getDate(); // Day of the month (1-31)
    const month = date.getMonth() + 1; // Month (0-11, so add 1 to get 1-12)
    if (month !== 7) {
      return;
    }
    // Get the month name using the month number as an index
    const year = date.getFullYear(); // Year

    let startTime = "";
    let endTime = "";

    if (session.startSession !== null) {
      const startParts = session.startSession.split(":");
      startTime = `${startParts[0]}:${startParts[1]}`;
    }

    if (session.endSession !== null) {
      const endParts = session.endSession.split(":");
      endTime = `${endParts[0]}:${endParts[1]}`;
    }

    // Get the day of the week
    const dayOfWeekNumber = date.getDay(); // Day of the week (0-6, where 0 is Sunday)
    let dayOfWeek;
    switch (dayOfWeekNumber) {
      case 0:
        dayOfWeek = "Sunday";
        break;

      case 5:
        dayOfWeek = "Friday";
        break;
      case 6:
        dayOfWeek = "Saturday";
        break;
    }
    const row = template.cloneNode(true);

    const imagePath = getImagePath(session.artistName);
    row.querySelector(".group-child").src = imagePath;
    // Fill in the session data
    row.querySelector(".month").textContent = "July";
    row.querySelector(".day").innerHTML = `${day}<br>${dayOfWeek}`; // row.querySelector('.day').textContent = day;
    row.querySelector(".year").textContent = year;
    row.querySelector(".artist-name").textContent = session.artistName;
    row.querySelector(".session").textContent = session.sessionType;
    row.querySelector(".location");
    const sessionName = row.querySelector(".artist-name");
    if (venueText.length > 50) {
      // applying some DOM manipulation for UI purposes
      venueText =
        venueText.substring(0, venueText.length / 2) +
        "<br>" +
        venueText.substring(venueText.length / 2);
      row.querySelector(".location").innerHTML = venueText;
      // Check the value of session.artistName
      if (session.artistName === "All-Day Pass") {
        sessionName.style.color = "#FF0705";
        row.querySelector(".time-price p").style.display = "none"; // Hide the session times
      } /* (session.artistName === 'Golden Ticket')*/ else {
        sessionName.style.color = "#FFCE31";
      }
    } else {
      // Set the innerHTML of the .location element to the venue text with the location icon
      row.querySelector(
        ".location"
      ).innerHTML = `<i class="fa fa-map-marker-alt"> ${venueText}`;
    }
    // innerHTML = `<i class="fa fa-map-marker-alt"> ${session.venue}`;
    if (startTime !== "" && endTime !== "") {
      row.querySelector(
        ".time-price p"
      ).innerHTML = `${startTime} - ${endTime}`;
    } else {
      row.querySelector(".time-price p").innerHTML = "";
    }
    // row.querySelector(".time-price p").innerHTML = `${startTime} - ${endTime}`;
    row.querySelector(
      ".price"
    ).innerHTML = `<i class="fa fa-euro-sign"></i> ${session.sessionPrice}`;
    // Append the row to the container
    template.parentNode.appendChild(row);
    // Inside the sessions.forEach loop...
    const addButton = row.querySelector(".btn");
    addButton.addEventListener("click", () => addToCart(session, addButton));
  });
  // Remove the template
  template.remove();
}

loadSessions();

function getImagePath(artistName) { //TODO: try to do it based on the artistImage
  const images = {
    afrojack: "../../img/DanceEvent/Afrojack.jpeg",
    "armin van buuren": "../../img/DanceEvent/Armin van Buuren.jpeg",
    hardwell: "../../img/DanceEvent/Hardwell.jpeg",
    "martin garrix": "../../img/DanceEvent/Martin Garrix.jpeg",
    tiěsto: "../../img/DanceEvent/Tiësto.jpeg",
    "nicky romero": "../../img/DanceEvent/Nicky Romero.jpeg",
    alldaypass: "../../img/DanceEvent/alldaypass.jpeg",
    "golden ticket": "../../img/DanceEvent/Golden Ticket.jpeg",
  };

  return (
    images[artistName.toLowerCase()] || "../../img/DanceEvent/Default.jpeg"
  );
}

function filterSessions(day) {
  const filteredSessions = allSessions.filter((session) => {
    const date = new Date(session.sessionDate);
    return date.getDate() === day;
  });

  displaySessions(filteredSessions);
}
document.addEventListener("DOMContentLoaded", (event) => {
  document
    .querySelector(".buttonDay1")
    .addEventListener("click", () => filterSessions(26));
  document
    .querySelector(".buttonDay2")
    .addEventListener("click", () => filterSessions(27));
  document
    .querySelector(".buttonDay3")
    .addEventListener("click", () => filterSessions(28));
});

document.addEventListener("DOMContentLoaded", (event) => {
  const buttons = [
    document.querySelector(".buttonDay1"),
    document.querySelector(".buttonDay2"),
    document.querySelector(".buttonDay3"),
  ];

  buttons[0].classList.add("selectedDay");

  buttons.forEach((button, index) => {
    button.addEventListener("click", () => {
      // Filter sessions
      filterSessions(26 + index);

      // Remove 'selectedDay' class from all buttons
      buttons.forEach((button) => button.classList.remove("selectedDay"));

      // Add 'selectedDay' class to clicked button
      button.classList.add("selectedDay");
    });
  });
});

function displayGoldenTicket(sessions) {
  const template = document.querySelector(".ticket"); 

  const goldenTicketContainer = document.querySelector(".goldenTicketContainer");
  goldenTicketContainer.innerHTML = "";
  const goldenTicketSession = sessions.find(session => session.artistName === 'Golden Ticket');
  
  const row = template.cloneNode(true);

  const imagePath = getImagePath(goldenTicketSession.artistName);
  row.querySelector(".group-child").src = imagePath;
  row.querySelector(".group-child").style.border = "0.5px solid #FFCE31";
  row.querySelector(".artist-name").textContent = goldenTicketSession.artistName;
  row.querySelector(".artist-name").style.color = "#FFCE31";
  row.querySelector(".session").textContent = goldenTicketSession.sessionType;
  row.querySelector(".month").textContent = "July";
  const date = new Date(goldenTicketSession.sessionDate);
  const day = date.getDate();

  const thirdDay = date.setDate(date.getDate() + 2); // Increase the date by 2 days
  row.querySelector(".day").innerHTML = day + "-" + date.getDate();
  row.querySelector(".day").style.fontSize = "30px";
  row.querySelector(".day").style.padding = "10px";

  row.querySelector(".year").textContent = date.getFullYear();
  row.querySelector(".year").style.fontSize = "25px";
  row.querySelector(".year").style.padding = "12px";
  row.querySelector(".year").style.backgroundColor = "#FFCE31";
  row.querySelector(".year").style.color = "black";

  let venueText = goldenTicketSession.venue;
  venueText = venueText.substring(0, venueText.length / 2) + "<br>" + venueText.substring(venueText.length / 2);
  row.querySelector(".location").innerHTML = venueText;

  row.querySelector(".time-price p").innerHTML = "";

  row.querySelector(".price").innerHTML = `<i class="fa fa-euro-sign"></i> ${goldenTicketSession.sessionPrice}`;

  // Append the row to the goldenTicketContainer
  goldenTicketContainer.appendChild(row);
  const addButton = row.querySelector(".btn");
  addButton.addEventListener("click", () => addToCart(goldenTicketSession,addButton));

  // Remove the template
  template.remove();
}

//////////////////////////Adding Tickets to Cart//////////////////////////

function addToCart(session,button) {
  console.log("Sending session data: ", session);

  fetch("http://localhost/api/danceevent/addTicket", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
    },
    body: JSON.stringify(session),
  })
    .then((response) => {
      if (response.ok) {
        console.log("Ticket added successfully");
        button.style.backgroundColor = "#1734F7";
        button.textContent = "Ticket Added";
        // button.disabled = true; check it
      } else {
        console.error("Error:", response.status, response.statusText);
      }
    })
    .catch((error) => console.error("Error:", error));
}
