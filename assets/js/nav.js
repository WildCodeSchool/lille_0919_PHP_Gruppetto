require('../scss/nav.scss');
// Interact with navbar, swipe effect !
const myArrow = document.querySelector('#arrow-swipe');
const myHeader = document.querySelector('header');

myArrow.addEventListener('click', () => {
    myHeader.classList.toggle('closed');
});
