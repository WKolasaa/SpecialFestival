// Get all elements with the class 'column-address'
var addressElements = document.querySelectorAll('.column-address');

// Loop through each element
addressElements.forEach(function (element) {
    // Get the raw address from the element's text content
    var rawAddress = element.textContent;

    // Format the address
    var formattedAddress = rawAddress.replace(', ', ',<br>');

    // Set the formatted address as the innerHTML of the element
    element.innerHTML = formattedAddress;
});