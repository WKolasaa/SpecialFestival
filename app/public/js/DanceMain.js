document.addEventListener("DOMContentLoaded", () => {
    const slides = document.querySelectorAll(".carousel-slide");
    let currentIndex = 0;
  
    function showSlide(index) {
      // Calculate the translateX value for the current index
      const offset = -index * 100;
      // Apply the transform to the container
      for (let slide of slides) {
        slide.style.transform = `translateX(${offset}%)`;
      }
    }
  
    // Change slide every 5 seconds
    setInterval(() => {
      currentIndex = (currentIndex + 1) % slides.length; // Cycle back to 0 when we reach the end
      showSlide(currentIndex);
    }, 5000);
  });