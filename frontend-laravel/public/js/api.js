const API_USER = 'http://localhost:3001';
const API_BOOKING = 'http://localhost:3002';

function showAlert(message, type = 'success') {
    const alertHtml = `
        <div class="alert alert-${type} alert-dismissible fade show" role="alert">
            ${message}
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    `;
    
    const container = document.getElementById('alertContainer');
    if (container) {
        container.innerHTML = alertHtml;
        setTimeout(() => container.innerHTML = '', 5000);
    }
}

// Check auth on load
window.addEventListener('load', () => {
    const token = localStorage.getItem('token');
    if (token) {
        document.getElementById('userInfo').textContent = localStorage.getItem('email');
        const logoutBtn = document.getElementById('logoutBtn');
        if (logoutBtn) logoutBtn.style.display = 'block';
    }
});
