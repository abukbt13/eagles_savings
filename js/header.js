const menu = document.getElementById('menu')
const nav_bar = document.getElementById('nav_bar')

// Assuming 'menu' is a reference to your menu element
menu.addEventListener('click', () => {
    nav_bar.classList.toggle('d-none')
});
const message = document.getElementById('message')
function showForm() {
    message.style.display = 'block';
}
