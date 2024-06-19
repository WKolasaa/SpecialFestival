// toast.js
function showToast(message,color) {
  Toastify({
      text: message,
      duration: 3000,
      close: true,
      gravity: "top", // `top` or `bottom`
      position: "right", // `left`, `center` or `right`
      style: {
        background: color
      },      stopOnFocus: true, // Prevents dismissing of toast on hover
  }).showToast();
  
}

