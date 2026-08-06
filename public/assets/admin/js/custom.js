// Sidebar Toggle (mobile/tablet ke liye)
document.getElementById('sidebarToggle').addEventListener('click', function () {
    document.getElementById('sidebar').classList.toggle('show');
});

// Dark / Light Theme Toggle
const themeToggle = document.getElementById('themeToggle');
const themeIcon = document.getElementById('themeIcon');
const htmlEl = document.documentElement;

// Page load hote hi saved theme apply karo
const savedTheme = localStorage.getItem('adminTheme') || 'light';
htmlEl.setAttribute('data-bs-theme', savedTheme);
updateThemeIcon(savedTheme);

themeToggle.addEventListener('click', function () {
    const currentTheme = htmlEl.getAttribute('data-bs-theme');
    const newTheme = currentTheme === 'light' ? 'dark' : 'light';
    htmlEl.setAttribute('data-bs-theme', newTheme);
    localStorage.setItem('adminTheme', newTheme);
    updateThemeIcon(newTheme);
});

function updateThemeIcon(theme) {
    themeIcon.classList.remove('bi-moon-stars', 'bi-sun');
    themeIcon.classList.add(theme === 'light' ? 'bi-moon-stars' : 'bi-sun');
}