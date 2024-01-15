const payloan =document.getElementById('payloan')
function sideBar(){
    sidebar.classList.toggle('d-none')
}

function showForm() {
    loan.classList.toggle('d-block')
}
function PayForm() {
    payloan.classList.toggle('d-block')
}
function closeBtn(){
    loan.classList.remove('d-block')
}
function closeForm(){
    payloan.classList.remove('d-block')
}



