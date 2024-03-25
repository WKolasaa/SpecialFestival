let allSessions = [];
function loadSessions() {
  fetch("http://localhost/api/danceevent/sessions")
      .then(response => response.json())
      .then(data => {
        allSessions = data; 
          displaySessions(allSessions); 
      })
      .catch(error => {
          console.error('Error fetching items:', error);
      });
}

function displaySessions(sessions) {
  // Get the template for the sessions
  const template = document.querySelector('.ticket');

  // Remove any existing session elements except the first one (the template)
  while (template.nextSibling) {
    template.nextSibling.remove();
  }


  // Loop over the sessions
  sessions.forEach(session => {
    // Parse the sessionTime
    const date = new Date(session.sessionDate);

    // Get the day, month, and year
    const day = date.getDate(); // Day of the month (1-31)
    const month = date.getMonth() + 1; // Month (0-11, so add 1 to get 1-12)
    const monthNames = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
    // Get the month name using the month number as an index
    const monthName = monthNames[month - 1]; // Subtract 1 because arrays are zero-based
    const year = date.getFullYear(); // Year
   
      const startParts = session.startSession.split(':');
      const endParts = session.endSession.split(':');

      const startTime = `${startParts[0]}:${startParts[1]}`;
      const endTime = `${endParts[0]}:${endParts[1]}`;


    // Get the day of the week
    const dayOfWeekNumber = date.getDay(); // Day of the week (0-6, where 0 is Sunday)
    let dayOfWeek;
    switch (dayOfWeekNumber) {
      case 0:
        dayOfWeek = 'Sunday';
        break;
      case 1:
        dayOfWeek = 'Monday';
        break;
      case 2:
        dayOfWeek = 'Tuesday';
        break;
      case 3:
        dayOfWeek = 'Wednesday';
        break;
      case 4:
        dayOfWeek = 'Thursday';
        break;
      case 5:
        dayOfWeek = 'Friday';
        break;
      case 6:
        dayOfWeek = 'Saturday';
        break;
    }
    const row = template.cloneNode(true);

    const imagePath = getImagePath(session.artistName);
    row.querySelector('.group-child').src = imagePath;
    // Fill in the session data
    row.querySelector('.month').textContent = monthName;
    row.querySelector('.day').innerHTML = `${day}<br>${dayOfWeek}`;    // row.querySelector('.day').textContent = day;
    row.querySelector('.year').textContent = year;
    row.querySelector('.artist-name').textContent = session.artistName;
    row.querySelector('.session').textContent = session.sessionType;
    row.querySelector('.location').innerHTML = `<i class="fa fa-map-marker-alt"> ${session.venue}`;
    row.querySelector('.time-price p').innerHTML = `${startTime} - ${endTime}` ;
    row.querySelector('.price').innerHTML = `<i class="fa fa-euro-sign"></i> ${session.sessionPrice}`;
    // Append the row to the container
    template.parentNode.appendChild(row);
  });
   // Remove the template
   template.remove();

}
loadSessions();



function getImagePath(artistName) {
  const images = {
    'afrojack': '../../img/DanceEvent/Afrojack.jpeg',
    'armin van buuren': '../../img/DanceEvent/Armin van Buuren.jpeg',
    'hardwell': '../../img/DanceEvent/Hardwell.jpeg',
    'martin garrix': '../../img/DanceEvent/Martin Garrix.jpeg',
    'tiěsto': '../../img/DanceEvent/Tiësto.jpeg',
    'nicky romero': '../../img/DanceEvent/Nicky Romero.jpeg',
    'alldaypass': '../../img/DanceEvent/alldaypass.jpeg',
    'golden ticket': '../../img/DanceEvent/Golden Ticket.jpeg',
  };

  return images[artistName.toLowerCase()] || '../../img/DanceEvent/Default.jpeg';
}

function filterSessions(day) {
  const filteredSessions = allSessions.filter(session => {
    const date = new Date(session.sessionDate);
    return date.getDate() === day;
  });

  displaySessions(filteredSessions);
}
document.addEventListener('DOMContentLoaded', (event) => {
  document.querySelector('.buttonDay1').addEventListener('click', () => filterSessions(26));
  document.querySelector('.buttonDay2').addEventListener('click', () => filterSessions(27));
  document.querySelector('.buttonDay3').addEventListener('click', () => filterSessions(28));
});

document.addEventListener('DOMContentLoaded', (event) => {
  const buttons = [document.querySelector('.buttonDay1'), document.querySelector('.buttonDay2'), document.querySelector('.buttonDay3')];

  buttons[0].classList.add('selectedDay');

  buttons.forEach((button, index) => {
    button.addEventListener('click', () => {
      // Filter sessions
      filterSessions(26 + index);

      // Remove 'selectedDay' class from all buttons
      buttons.forEach(button => button.classList.remove('selectedDay'));

      // Add 'selectedDay' class to clicked button
      button.classList.add('selectedDay');
    });
  });
});