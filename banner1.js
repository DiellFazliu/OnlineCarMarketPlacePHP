document.addEventListener("DOMContentLoaded", function () {
    // Ensure that the element is available before adding the event listener
    const element = document.getElementById("your-element-id");
    
    if (element) {
        element.addEventListener("click", function() {
            // Your event handler logic here
        });
    } else {
        console.error("Element not found: #your-element-id");
    }
});
