document.addEventListener("DOMContentLoaded", () => {


    const creditCardNumber = document.querySelector('input[name="card_number"]');
    // enable spacing for credit/debit card number
    creditCardNumber.addEventListener('keyup', function() {
        let currentValue = creditCardNumber.value;
        console.log(currentValue);
        let newValue = '';
        currentValue = currentValue.replace(/\s/g, '');
        for (let i = 0; i < currentValue.length; i++) {
            // after every 4 number add a space
            if (i % 4 === 0 && i > 0) {
                newValue = newValue.concat(' ');
            }
            newValue = newValue.concat(currentValue[i]);
        }
        creditCardNumber.value = newValue;
    })



});


