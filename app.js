const menu = document.getElementById('menu')
const close = document.getElementById('close')
const nav_bar = document.getElementById('nav_bar')

menu.addEventListener('click',function (){
    nav_bar.classList.toggle('d-none')
})

const message = document.getElementById('message')
function showForm() {
    message.style.display = 'block';
}
function closeBtn() {
    message.style.display = 'none';
}

