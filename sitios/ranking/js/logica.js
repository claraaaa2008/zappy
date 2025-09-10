document.addEventListener('DOMContentLoaded', function () {
    const rankingAll = document.querySelector('.rankingAll');
    rankingAll.classList.remove('visible');

    window.addEventListener('scroll', function () {
        if (window.scrollY > 50) {
            rankingAll.classList.add('visible');
        } else {
            rankingAll.classList.remove('visible');
        }
    });
});