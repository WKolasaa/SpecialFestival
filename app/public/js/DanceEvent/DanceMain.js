let overviews = [];

function loadOverviews() {
    fetch("/api/DanceEvent/danceOverviews") //remove the localhost to the config file
        .then((response) => response.json())
        .then((data) => {
            overviews = data;
            // displayOverviews(overviews);
        })
        .catch((error) => {
            console.error("Error fetching items:", error);
        });
}


loadOverviews();

//////////////////////////////Artist//////////////////////////////
let allArtists = [];

function loadArtists() {
    fetch("/api/DanceEvent/Artists")
        .then((response) => response.json())
        .then((data) => {
            allArtists = data; // Store all users in the array
            displayArtists(allArtists); // Display all users by default
        })
        .catch((error) => {
            console.error("Error fetching items:", error);
        });
}

function displayArtists(artists) {
    const swiperWrapper = document.querySelector(".swiper-wrapper");

    // Clear out any existing cards
    swiperWrapper.innerHTML = "";

    artists.forEach((artist, index) => {
        // Create a new card
        const artistCard = document.createElement("div");
        artistCard.classList.add("swiper-slide", "card");
        artistCard.dataset.artistIndex = index;

        // Fill in the card content
        artistCard.innerHTML = `
      <div class="card-content">
        <div class="image">
          <img src="../../img/DanceEvent/${artist.imageName}" alt="Artists" style="height: 200px; object-fit:cover;">
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
                spaceBetween: 10,
            },
            640: {
                slidesPerView: 3,
                spaceBetween: 20,
            },
            920: {
                slidesPerView: 3,
                spaceBetween: 50,
            },
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
        },
    });
}

document.addEventListener("DOMContentLoaded", function () {
    loadArtists();
});