let selectedPosition = '';

function showResult(str) {
    displayFilteredResults();
}



function displayFilteredResults() {
    const input = document.querySelector('.searchField input').value.toLowerCase();
    const rows = document.querySelectorAll("#myTable tbody tr");

    rows.forEach(row => {
        const firstName = row.cells[1].textContent.toLowerCase(); // First name
        const lastName = row.cells[2].textContent.toLowerCase();  // Last name
        const position = row.cells[4].textContent.trim();        // Position

        // Check conditions for search and position
        const matchesSearch = firstName.includes(input) || lastName.includes(input);
        const matchesPosition = selectedPosition === '' || position === selectedPosition;

        // Show or hide the row based on conditions
        if (matchesSearch && matchesPosition) {
            row.style.display = ""; // Show matching row
        } else {
            row.style.display = "none"; // Hide non-matching row
        }
    });
}

function filterPlayersByPosition(position) {
    selectedPosition = position; // Store the selected position
    document.getElementById("positionButton").innerHTML = position || "Position"; // Update button text
    displayFilteredResults(); // Update displayed results
}

function myFunction() {
    document.getElementById("myDropdown").classList.toggle("show");
}

// Close the dropdown if the user clicks outside of it
window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        const dropdowns = document.getElementsByClassName("dropdown-content");
        for (let i = 0; i < dropdowns.length; i++) {
            dropdowns[i].classList.remove('show');
        }
    }
}

// Add event listeners for dropdown items
document.querySelectorAll('.dropdown-content a').forEach(item => {
    item.addEventListener('click', function() {
        const position = this.getAttribute('data-value');
        filterPlayersByPosition(position);
        myFunction(); // Close the dropdown
    });
});