/* ==========================================================================
   LABEL: SECTION SELECTION VIEW MANAGER
   ========================================================================== */
function showSection(sectionID) {
    document.querySelectorAll('.content').forEach(s => s.style.display = 'none');
    document.getElementById('home').style.display = 'none';
    
    const active = document.getElementById(sectionID);
    if(active) {
        active.style.display = 'block';
    }
}

/* ==========================================================================
   LABEL: RESET WORKSPACE VIEW ON BRAND LOGO INTERACTION
   ========================================================================== */
function hideContent() {
    document.querySelectorAll('.content').forEach(s => s.style.display = 'none');
    document.getElementById('home').style.display = 'block';
}

/* ==========================================================================
   LABEL: INPUT RESET METHOD
   ========================================================================== */
function clearFields() {
    document.querySelectorAll('input').forEach(input => input.value = '');
}

/* ==========================================================================
   LABEL: APP CONFIRMATION SUCCESS BANNER LOADER
   ========================================================================== */
window.onload = function() {
    const params = new URLSearchParams(window.location.search);
    if (params.get('status') === 'success') {
        const toast = document.getElementById('success-toast');
        if(toast) {
            toast.style.display = 'block';
            setTimeout(() => { toast.style.display = 'none'; }, 3500);
        }
    }
}
