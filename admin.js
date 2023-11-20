

const loan = document.getElementById('loan')
function showForm() {
    loan.style.display = 'block';
}
function closeBtn() {
    loan.style.display = 'none';
}

const sidebar = document.getElementById('sidebar')

function sideBar(){
    sidebar.classList.toggle('d-none')
}