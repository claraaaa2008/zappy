/*** Efecto parallax para scroll ***/
document.addEventListener('DOMContentLoaded', function () {
    const rankingAll = document.querySelector('.rankingAll'); // Llama a la clase .rankingAll en html
    rankingAll.classList.remove('visible'); // Quita la visibilidad a la clase .rankingAll al cargar la página

    window.addEventListener('scroll', function () { // Agrega un evento al scrollear la página
        if (window.scrollY > 50) { // Si se scrollea mas de 50px
            rankingAll.classList.add('visible'); // Se hace visible la clase .rankingAll
        } else { // Caso contrario
            rankingAll.classList.remove('visible'); // Caso contrario se quita la visibilidad a la clase .rankingAll
        }
    });
});