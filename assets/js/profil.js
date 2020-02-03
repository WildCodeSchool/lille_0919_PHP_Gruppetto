require('../scss/profil.scss');

// js for modify profil page with the pen and display effect
const myPens = document.querySelectorAll('.btn-modify');
const myForms = document.querySelectorAll('.box-form-update');
const myTexts = document.querySelectorAll('.box-text');

for (let i = 0; i <= myForms.length; i += 1) {
    myPens[i].addEventListener('click', () => {
        myForms[i].classList.toggle('displayed');
        myTexts[i].classList.toggle('hidden');
    });
}
