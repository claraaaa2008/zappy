/**************************************************/
/***************** Cambio de tema *****************/
/**************************************************/
// Theme switching with persistence

// Function to apply theme
function applyTheme(theme) {
    document.documentElement.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
}

// Load saved theme on page load
document.addEventListener('DOMContentLoaded', () => {
    const savedTheme = localStorage.getItem('theme') || 'dark'; // Default to dark if no theme saved
    applyTheme(savedTheme);
});

// Event listeners for theme switching (only if elements exist)
const svgClaro = document.getElementById('svg-claro');
const svgOscuro = document.getElementById('svg-oscuro');

if (svgClaro) {
    svgClaro.addEventListener('click', () => {
        console.log('Claro');
        applyTheme('light');
    });
}

if (svgOscuro) {
    svgOscuro.addEventListener('click', () => {
        console.log('Oscuro');
        applyTheme('dark');
    });
}
