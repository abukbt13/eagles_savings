
const message = document.getElementById('message')
const loan = document.getElementById('loan')
const sidebar = document.getElementById('sidebar')

function showForm() {
    message.style.display = 'block';
}
function closeBtn() {
    message.style.display = 'none';
}
function sideBar(){
    sidebar.classList.toggle('d-none')
}