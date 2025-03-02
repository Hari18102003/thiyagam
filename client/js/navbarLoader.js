console.log("working");
document.addEventListener("DOMContentLoaded", function () {
    fetch("js/navbar.html")
        .then(response => response.text())
        .then(data => {
            document.getElementById("navbar-container").innerHTML = data;
        })
        .catch(error => console.error("Error loading navbar:", error));
});

function setupDropdown(dropdownSelector, linksSelector) {
    const dropdown = document.querySelector(dropdownSelector);
    const resLinks = document.querySelector(linksSelector);

    if (!dropdown || !resLinks) return;

    dropdown.addEventListener('click', (event) => {
        event.stopPropagation(); // Prevents immediate closing
        resLinks.style.display = resLinks.style.display === 'block' ? 'none' : 'block';
    });

    document.addEventListener('click', (event) => {
        if (!dropdown.contains(event.target)) {
            resLinks.style.display = 'none';
        }
    });
}


