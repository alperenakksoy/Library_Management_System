const addBookBtn = document.querySelector('.main-header .addBook');
const closeBookBtn = document.querySelector('.closeBtn');
const modal = document.querySelector('.popup-container');

addBookBtn.addEventListener('click',()=>{
    modal.classList.add('open');
});


closeBookBtn.addEventListener('click',()=>{
    modal.classList.remove('open');
});