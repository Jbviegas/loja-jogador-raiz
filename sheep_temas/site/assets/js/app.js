

// Inicializando o Swiper
const swiper = new Swiper('.swiper', {
    loop: true, // Permite rolar os slides em loop
    navigation: {
        nextEl: '.swiper-button-next',
        prevEl: '.swiper-button-prev',
    },
    pagination: {
        el: '.swiper-pagination',
        clickable: true,
    },
    autoplay: {
        delay: 4000, // Tempo em milissegundos para trocar o slide automaticamente
    },
});
