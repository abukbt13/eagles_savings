
const message = document.getElementById('message')
const loan = document.getElementById('loan')
function showForm() {
    loan.style.display = 'block';
}
function closeBtn() {
    loan.style.display = 'none';
}

const sidebar = document.getElementById('sidebar')
menu.addEventListener('click',function (){
    nav_bar.classList.toggle('d-none')
})

function showForm() {
    message.style.display = 'block';
}
function closeBtn() {
    message.style.display = 'none';
}

function sideBar(){
    sidebar.classList.toggle('d-none')
}

