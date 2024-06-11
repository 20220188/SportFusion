


document.getElementById('increaseBtn').addEventListener('click', function () {
    var quantity = document.getElementById('quantity');
    var currentQuantity = parseInt(quantity.textContent);
    quantity.textContent = currentQuantity + 1;
});

document.getElementById('decreaseBtn').addEventListener('click', function () {
    var quantity = document.getElementById('quantity');
    var currentQuantity = parseInt(quantity.textContent);
    if (currentQuantity > 1) {
        quantity.textContent = currentQuantity - 1;
    }
});