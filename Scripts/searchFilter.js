let selectedPosition = ''; // Stores the currently selected position filter
let selectedSchool = '';    // Stores the currently selected school filter

// Function to toggle dropdown visibility
function toggleDropdown(dropdownId) {
    const dropdown = document.getElementById(dropdownId);
    if (dropdown) {
        dropdown.classList.toggle("show");
    }
}

// Function to handle filtering by position or school
function filterPlayers(filterType, value) { 
    if (filterType === 'position') { 
        selectedPosition = value; 
        document.getElementById("positionButton").textContent = value || "Position"; // Update button text 
    } else if (filterType === 'school') { 
        selectedSchool = value; 
        document.getElementById("schoolButton").textContent = value || "School"; // Update button text 
    } 

    currentPage = 1; // Reset to first page when filtering
    displayFilteredResults(); 
}

// Function to apply all active filters (search, position, school)
function displayFilteredResults() { 
    const input = document.querySelector('.searchField input').value.toLowerCase(); 
    const rows = document.querySelectorAll("#myTable tbody tr"); 
    const filteredRows = [];

    rows.forEach(row => { 
        const firstName = row.cells[1].textContent.toLowerCase(); 
        const lastName = row.cells[2].textContent.toLowerCase(); 
        const schoolName = row.cells[3].textContent.trim().toLowerCase(); 
        const position = row.cells[4].textContent.trim().toLowerCase(); 

        const matchesSearch = firstName.includes(input) || lastName.includes(input); 
        const matchesPosition = selectedPosition === '' || position === selectedPosition.toLowerCase(); 
        const matchesSchool = selectedSchool === '' || schoolName === selectedSchool.toLowerCase(); 

        if (matchesSearch && matchesPosition && matchesSchool) { 
            filteredRows.push(row); 
        } 
    }); 

    // Hide all rows
    rows.forEach(row => {
        row.style.display = "none";
    });

    // Show only the rows for the current page
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    for (let i = start; i < end && i < filteredRows.length; i++) {
        filteredRows[i].style.display = "";
    }

    // Update pagination info
    const totalPages = Math.ceil(filteredRows.length / rowsPerPage);
    document.getElementById("page-info").textContent = `Page ${currentPage} of ${totalPages}`;

    // Enable/disable buttons
    document.getElementById("prev").disabled = currentPage === 1;
    document.getElementById("next").disabled = currentPage === totalPages;
}

// The onkeyup event for the search input calls this
function showResult(str) {
    displayFilteredResults();
}

// Close dropdowns if the user clicks outside of them
window.onclick = function(event) {
    if (!event.target.matches('.dropbtn')) {
        const dropdowns = document.getElementsByClassName("dropdown-content");
        for (let i = 0; i < dropdowns.length; i++) {
            const openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}
