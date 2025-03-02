const buttons = document.querySelectorAll('.toggle-btn');
const prices = document.querySelectorAll('.toggle-price');
const button1 = document.getElementById("color-1");
const button2 = document.getElementById("color-2");
const button3 = document.getElementById("color-3");

buttons.forEach((button, index) => {
    button.addEventListener('click', () => {
        button.classList.toggle('pressed');
        prices[index].classList.toggle('update');
    });
});