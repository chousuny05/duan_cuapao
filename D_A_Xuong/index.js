const buyBtns = document.querySelectorAll('.js-buy-food')
const modal = document.querySelector('.js-modal')
const modalClose = document.querySelector('.js-modal-close')
const modalcontainer = document.querySelector('.js-modal-container')

function showBuyFoods() {
    modal.classList.add('open'); // Thêm lớp 'open' để hiển thị modal
   
}

function hiddenBuyFoods() {
    modal.classList.remove('open'); // Loại bỏ lớp 'open' để ẩn modal
  
}

//lặp qua button và hành vi nghe click
for (const buyBtn of buyBtns) {

    buyBtn.addEventListener('click', showBuyFoods)
}
//Hành vi click vào button close
modalClose.addEventListener('click', hiddenBuyFoods)

modal.addEventListener('click', hiddenBuyFoods)

modalcontainer.addEventListener('click', function(event) {
    event.stopPropagation();
});


