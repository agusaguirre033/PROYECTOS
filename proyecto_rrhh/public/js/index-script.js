// Función para mostrar la precarga y cuando cargen los recursos se muestre la página
window.addEventListener('load', function() {
    document.querySelector('#precarga').style.opacity = '0';
    setTimeout(function() {
        document.querySelector('#precarga').style.display = 'none';
        document.querySelector('.container').style.opacity = '1';
        document.querySelector('.container').style.transform = 'scale(1)';
    }, 200);
});

// Código para la animación del header cuando hay scroll
window.addEventListener('scroll', function () {
    var header = document.querySelector('header');
    if (window.scrollY > 50) {
        header.classList.add('scrolled');
    } else {
        header.classList.remove('scrolled');
    }
});