function manualBackup() {
    const data = document.getElementById('myTable').outerHTML; // Get the table data
    const blob = new Blob([data], { type: 'text/html' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;

    // Get today's date in YYYY-MM-DD format
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
    const day = String(today.getDate()).padStart(2, '0');
    const fileName = `backup-${year}-${month}-${day}.sql`;

    a.download = fileName; // Set the new filename with the date
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    
    console.log('Backup saved at:', new Date().toLocaleTimeString()); // Log the backup time
    alert('Manual backup completed!');
}