
// Function to show one section and hide all others
function showSection(sectionID) {
    document.querySelectorAll('.content').forEach(s => s.style.display = 'none');
    document.getElementById('home').style.display = 'none';
    const active = document.getElementById(sectionID);
    if(active) active.style.display = 'block';
}

// Logo Requirement: Hide class 'content' when clicked
function hideContent() {
    document.querySelectorAll('.content').forEach(s => s.style.display = 'none');
    document.getElementById('home').style.display = 'block';
}

// Clear Fields Requirement: Clear text and number inputs
function clearFields() {
    const inputs = document.querySelectorAll('input[type="text"], input[type="number"]');
    inputs.forEach(input => input.value = '');
}

// Toast logic
window.onload = function() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('status') === 'success') {
        const toast = document.getElementById('success-toast');
        toast.style.display = 'block';
        setTimeout(() => { toast.style.display = 'none'; }, 3000);
    }
}
