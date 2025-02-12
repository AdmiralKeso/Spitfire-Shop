const buttons = document.querySelectorAll('.toggle-btn');
const prices = document.querySelectorAll('.toggle-price');

buttons.forEach((button, index) => {
    button.addEventListener('click', () => {
        button.classList.toggle('pressed');
        prices[index].classList.toggle('update');
    });
});