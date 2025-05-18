function manualBackupCoach() {
    const data = document.getElementById('myTable').outerHTML; // Get the table data
    const blob = new Blob([data], { type: 'text/html' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;

    // Get today's date and time in YYYY-MM-DD_HH-MM-SS format
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0'); // Months are 0-indexed
    const day = String(today.getDate()).padStart(2, '0');
    const hours = String(today.getHours()).padStart(2, '0');
    const minutes = String(today.getMinutes()).padStart(2, '0');
    const seconds = String(today.getSeconds()).padStart(2, '0');
    
    // Change the filename to include time
    const fileName = `coachBackup/backup-${year}-${month}-${day}_${hours}-${minutes}-${seconds}.sql`;

    a.download = fileName; // Set the new filename with the date and time
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    
    console.log('Backup saved at:', new Date().toLocaleTimeString()); // Log the backup time
    alert('Manual backup completed!');
}