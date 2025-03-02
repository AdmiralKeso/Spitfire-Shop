const buttons = document.querySelectorAll('.toggle-btn');
const prices = document.querySelectorAll('.toggle-price');
const button1 = document.getElementById("color-1");
const button2 = document.getElementById("color-2");
const button3 = document.getElementById("color-3");

// Event listeners for buttons 1, 2, and 3
button1.addEventListener('click', () => handleButton1To3(button1, prices[0]));
button2.addEventListener('click', () => handleButton1To3(button2, prices[1]));
button3.addEventListener('click', () => handleButton1To3(button3, prices[2]));

buttons.forEach((button, index) => {
    button.addEventListener('click', () => {
        button.classList.toggle('pressed');
        prices[index].classList.toggle('update');
    });
});