
var img = document.querySelector('.img-produit');

img.addEventListener('mousein', (e) => {
    img.classList.remove('img-produit-out');
});

img.addEventListener('mouseout', (e) => {
    img.classList.add('img-produit-out');
});