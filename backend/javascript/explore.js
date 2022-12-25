const buttons = document.querySelectorAll('.btn-information');
buttons.forEach(button => {
    button.addEventListener('click', () => {
        window.location.href = `./product.php?reference=${button.value}`;
    });
});