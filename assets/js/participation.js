function onclickBtnParticipe(event) {
    event.preventDefault();

    const url = this.href;
    const spanCount = this.querySelector('span.js-participationLikes');
    const icone = this.querySelector('i');
    // eslint-disable-next-line no-undef
    axios.get(url).then((response) => {
        spanCount.textContent = response.data.participationLikes;

        if (icone.classList.contains('fas')) {
            icone.classList.replace('fas', 'far');
        } else {
            icone.classList.replace('far', 'fas');
        }
    });
}

document.querySelectorAll('a.js-participe').forEach((link) => {
    link.addEventListener('click', onclickBtnParticipe);
});
