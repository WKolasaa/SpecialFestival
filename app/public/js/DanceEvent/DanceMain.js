// let allArtists = [];
// let swiper;

// function loadArtists() {
//   fetch("http://localhost/api/danceevent/Artists")
//     .then(response => response.json())
//     .then(data => {
//       allArtists = data; // Store all users in the array
//       displayArtists(allArtists); // Display all users by default

//       // Initialize Swiper here after data has been loaded
//       swiper = new Swiper(".mySwiper", {
//         direction: "horizontal",
//         breakpoints: {
//           320: {
//             slidesPerView: 1,
//             spaceBetween: 10
//           },
//           640: {
//             slidesPerView: 3,
//             spaceBetween: 20
//           },
//           920: {
//             slidesPerView: 3,
//             spaceBetween: 50
//           }
//         },
//         grabCursor: true,
//         loop: true,
//         pagination: {
//           el: ".swiper-pagination",
//           clickable: true,
//         },
//         navigation: {
//           nextEl: ".swiper-button-next",
//           prevEl: ".swiper-button-prev",
//         }
//       });
//     })
//     .catch(error => {
//       console.error('Error fetching items:', error);
//     });
// }


// // function displayArtists(artists) {
// //   artists.forEach((artist, index) => {
// //     const artistCard = document.querySelector(`.swiper-slide.card[data-artist-index="${index}"]`);

// //     if (artistCard) {
// //       artistCard.querySelector(".artistDate span").textContent = artist.participationDate + ' | Club';
// //       artistCard.querySelector(".artistName span").textContent = artist.artistName;
// //       artistCard.querySelector(".artistStyle span").textContent = 'Style: ' + artist.style;
// //     }
// //   });
// // }
// // document.addEventListener('DOMContentLoaded', function() {
// //   loadArtists();
// // });
// function displayArtists(artists) {
//   const swiperWrapper = document.querySelector('.swiper-wrapper');

//   // Clear out any existing cards
//   swiperWrapper.innerHTML = '';

//   artists.forEach((artist, index) => {
//     // Create a new card
//     const artistCard = document.createElement('div');
//     artistCard.classList.add('swiper-slide', 'card');
//     artistCard.dataset.artistIndex = index;

//     // Fill in the card content
//     artistCard.innerHTML = `
//       <div class="card-content">
//         <div class="image">
//           <img src="../../img/DanceEvent/${artist.imageName}" alt="Artists">
//         </div>
//         <div class="artist-container">
//           <div class="artistDate">
//             <span>${artist.participationDate} | Club</span>
//           </div>
//           <div class="artistName">
//             <span>${artist.artistName}</span>
//           </div>
//           <div class="artistInfo">
//             <span>${artist.info}</span>
//           </div>
//           <div class="artistTitle">
//             <span><span class="desc">Title:</span> ${artist.title}</span>
//           </div>
//           <div class="artistStyle">
//             <span><span class="desc">Style:</span> ${artist.style}</span>
//           </div>
//         </div>
//       </div>
//     `;

//     // Add the new card to the swiper wrapper
//     swiperWrapper.appendChild(artistCard);
//   });

//   // Update Swiper after adding new slides
//   swiper.update();
// }
// document.addEventListener('DOMContentLoaded', function() {
//     loadArtists();
//   });

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

function displayArtists(artists) {
  const swiperWrapper = document.querySelector('.swiper-wrapper');

  // Clear out any existing cards
  swiperWrapper.innerHTML = '';

  artists.forEach((artist, index) => {
    // Create a new card
    const artistCard = document.createElement('div');
    artistCard.classList.add('swiper-slide', 'card');
    artistCard.dataset.artistIndex = index;

    // Fill in the card content
    artistCard.innerHTML = `
      <div class="card-content">
        <div class="image">
          <img src="../../img/DanceEvent/${artist.imageName}" alt="Artists">
        </div>
        <div class="artist-container">
          <div class="artistDate">
            <span>${artist.participationDate} | Club</span>
          </div>
          <div class="artistName">
            <span>${artist.artistName}</span>
          </div>
          <div class="artistInfo">
            <span>${artist.description}</span>
          </div>
          <div class="artistTitle">
            <span><span class="desc">Title:</span> ${artist.title}</span>
          </div>
          <div class="artistStyle">
            <span><span class="desc">Style:</span> ${artist.style}</span>
          </div>
        </div>
      </div>
    `;

    // Add the new card to the swiper wrapper
    swiperWrapper.appendChild(artistCard);
  });

  // Initialize Swiper here after data has been loaded
  swiper = new Swiper(".mySwiper", {
    direction: "horizontal",
    breakpoints: {
      320: {
        slidesPerView: 1,
        spaceBetween: 10
      },
      640: {
        slidesPerView: 3,
        spaceBetween: 20
      },
      920: {
        slidesPerView: 3,
        spaceBetween: 50
      }
    },
    grabCursor: true,
    loop: true,
    pagination: {
      el: ".swiper-pagination",
      clickable: true,
    },
    navigation: {
      nextEl: ".swiper-button-next",
      prevEl: ".swiper-button-prev",
    }
  });
}

document.addEventListener('DOMContentLoaded', function() {
  loadArtists();
});