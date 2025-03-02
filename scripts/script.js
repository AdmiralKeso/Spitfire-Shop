const buttons = document.querySelectorAll('.toggle-btn');
const prices = document.querySelectorAll('.toggle-price');
const button1 = document.getElementById("color-1");
const button2 = document.getElementById("color-2");
const button3 = document.getElementById("color-3");

// Event listeners for buttons 1, 2, and 3
button1.addEventListener('click', () => handleButton1To3(button1, prices[0]));
button2.addEventListener('click', () => handleButton1To3(button2, prices[1]));
button3.addEventListener('click', () => handleButton1To3(button3, prices[2]));

// Function for button 1-3
function handleButton1To3(button, price) {
    // If the clicked button is already pressed, deselect it
    if (button.classList.contains('pressed')) {
        button.classList.remove('pressed');
        price.classList.remove('update');
    } else {
        // Reset all three buttons to unselected state
        button1.classList.remove('pressed');
        button2.classList.remove('pressed');
        button3.classList.remove('pressed');
        
        // Remove the 'update' class from all prices
        prices[0].classList.remove('update');
        prices[1].classList.remove('update');
        prices[2].classList.remove('update');
        
        button.classList.add('pressed');
        price.classList.add('update');
    }
}

// Event listeners for all other buttons (4–9)
buttons.forEach((button, index) => {
    if (index > 2) {
        button.addEventListener('click', () => {
            button.classList.toggle('pressed');
            prices[index].classList.toggle('update');
        });
    }
});

