require('../scss/details.scss');


// Details scroll through the answers.
const acc = document.getElementsByClassName('accordion');
let i;
function faqList() {
    this.classList.toggle('active');
    const panel = this.nextElementSibling;
    if (panel.style.maxHeight) {
        panel.style.maxHeight = null;
    } else {
        panel.style.maxHeight = `${panel.scrollHeight}px`;
    }
}
for (i = 0; i < acc.length; i += 1) {
    acc[i].addEventListener('click', faqList);
}
