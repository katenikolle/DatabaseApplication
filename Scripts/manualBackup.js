// Function to handle manual backup
function manualBackup() {
    const data = document.getElementById('myTable').outerHTML; // Get the table data
    const blob = new Blob([data], { type: 'text/html' });
    const url = URL.createObjectURL(blob);
    const a = document.createElement('a');
    a.href = url;
    a.download = 'backup.sql';
    document.body.appendChild(a);
    a.click();
    document.body.removeChild(a);
    URL.revokeObjectURL(url);
    
    console.log('Backup saved at:', new Date().toLocaleTimeString()); // Log the backup time
    alert('Manual backup completed!');
}