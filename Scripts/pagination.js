let currentPage = 1;
const rowsPerPage = 8;

function displayPlayers() {
    const rows = document.querySelectorAll("#myTable tbody tr");
    const totalRows = rows.length;
    const totalPages = Math.ceil(totalRows / rowsPerPage);

    // Hide all rows
    rows.forEach(row => {
        row.style.display = "none";
    });

    // Calculate start and end index
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;

    // Show only the rows for the current page
    for (let i = start; i < end && i < totalRows; i++) {
        rows[i].style.display = "";
    }

    // Update pagination info
    document.getElementById("page-info").textContent = `Page ${currentPage} of ${totalPages}`;

    // Enable/disable buttons
    document.getElementById("prev").disabled = currentPage === 1;
    document.getElementById("next").disabled = currentPage === totalPages;
}

function changePage(direction) {
    currentPage += direction;
    displayPlayers();
}

// Initial display
document.addEventListener("DOMContentLoaded", () => {
    displayPlayers();
});
