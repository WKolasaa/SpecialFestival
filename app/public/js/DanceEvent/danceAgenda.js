// let allAgenda = [];
// function loadAgenda() {
//   fetch("http://localhost/api/danceevent/Agenda")
//       .then(response => {
//         console.log('Response:', response); // And this
//         return response.json();
//       })
//       .then(data => {
//         console.log('Data:', data); // And this
//         allAgenda = data;
//         displayAgenda(allAgenda);
//       })
//       .catch(error => {
//         console.error('Error fetching items:', error);
//       });
// }

// function displayAgenda(agenda) {
//   // Group the agenda items by day
//   const groupedAgenda = agenda.reduce((groups, item) => {
//     const date = item.eventDate.split(' ')[0]; // Get the date part of the eventDate
//     if (!groups[date]) {
//       groups[date] = [];
//     }
//     groups[date].push(item);
//     return groups;
//   }, {});

//   // Loop over each day in the grouped agenda
//   Object.keys(groupedAgenda).forEach((date, index) => {
//     const dayAgenda = groupedAgenda[date];
//     const day = index + 1; // Day number (1, 2, 3, etc.)

//     // Get the table body for this day
//     const tableBody = document.querySelector(`#day${day}-table tbody`);

//     // Clear any existing rows in the table body
//     tableBody.innerHTML = '';

//     // Add a new row for each item in the day's agenda
//     dayAgenda.forEach(item => {
//       const row = document.createElement('tr');

//       const sessionCell = document.createElement('td');
//       sessionCell.innerHTML = `${item.artistName}`; // Add session under artist name
//       row.appendChild(sessionCell);

//       const timeCell = document.createElement('td');
//       timeCell.innerHTML = `${item.eventTime}<br>(${item.durationMinutes} mins)`; // Add duration under event time
//       row.appendChild(timeCell);

//       const priceCell = document.createElement('td');
//       priceCell.textContent = `€ ${item.sessionPrice}`; // Add euro sign beside price
//       row.appendChild(priceCell);

//       const ticketsCell = document.createElement('td');
//       ticketsCell.textContent = item.sessionsAvailable;
//       row.appendChild(ticketsCell);

//       const addressCell = document.createElement('td');
// addressCell.innerHTML = item.venueAddress.replace(', ', ',<br>');
// row.appendChild(addressCell);

//       tableBody.appendChild(row);
//     });
//   });
//   const firstEventDay1 = agenda.find(item => item.eventDay === 'Friday');
//   const firstEventDay2 = agenda.find(item => item.eventDay === 'Saturday');
//   const firstEventDay3 = agenda.find(item => item.eventDay === 'Sunday');

//   // Get the h3 elements
//   const dateElement1 = document.querySelector('.date1');
//   const dateElement2 = document.querySelector('.date2');
//   const dateElement3 = document.querySelector('.date3');

//   // Set the text content of the h3 elements
//   if (firstEventDay1) {
//     dateElement1.textContent = `${firstEventDay1.eventDay} ${firstEventDay1.eventDate}`;
//   }
//   if (firstEventDay2) {
//     dateElement2.textContent = `${firstEventDay2.eventDay} ${firstEventDay2.eventDate}`;
//   }
//   if (firstEventDay3) {
//     dateElement3.textContent = `${firstEventDay3.eventDay} ${firstEventDay3.eventDate}`;
//   }


// }

// document.addEventListener('DOMContentLoaded', (event) => {
//   loadAgenda();
// });

// Get all elements with the class 'column-address'
var addressElements = document.querySelectorAll('.column-address');

// Loop through each element
addressElements.forEach(function(element) {
  // Get the raw address from the element's text content
  var rawAddress = element.textContent;

  // Format the address
  var formattedAddress = rawAddress.replace(', ', ',<br>');

  // Set the formatted address as the innerHTML of the element
  element.innerHTML = formattedAddress;
});