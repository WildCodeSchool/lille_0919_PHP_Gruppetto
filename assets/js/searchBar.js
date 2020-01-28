const Routing = require('../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router');
const Routes = require('./js_routes.json');

const mySearchIcon = document.querySelector('.js-search-icon');
const mySearchInput = document.querySelector('#js-search-input');
const searchResultsBlock = document.getElementById('js-search-results');

// hide/display the search input
// eslint-disable-next-line no-console
mySearchIcon.addEventListener('click', () => {
    mySearchInput.value = '';
    mySearchInput.classList.toggle('visible');
});

function createElement(name) {
    return document.createElement(name);
}

function insertToDOM(data) {
    const p = createElement('p');
    p.className = 'search-result';

    // data
    const { fullname } = data;
    const pResult = searchResultsBlock.appendChild(p);

    // add all the elements to the message-list in the right order
    pResult.innerHTML = `${fullname}`;
}


// searchbar research


mySearchInput.addEventListener('keyup', () => {
    if (mySearchInput.value === '') {
        searchResultsBlock.innerText = '';
        searchResultsBlock.classList.add('hide');
        return;
    }
    new Promise(((resolve, reject) => {
        searchResultsBlock.classList.remove('hide');
        const joker = mySearchInput.value;
        const url = Routing.generate('searchbar_getMembers', { joker });
        const xhr = new XMLHttpRequest();
        xhr.open('GET', url);
        xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
        xhr.addEventListener('load', function searchMembers(event) {
            if (this.readyState === 4) {
                if (this.status === 200 && this.statusText === 'OK') {
                    resolve(JSON.parse(this.responseText));
                } else {
                    insertToDOM('Pas de résultat');
                    searchResultsBlock.innerText = '';
                }
            }
        });

        xhr.send();
    }))
        .then((response) => {
            searchResultsBlock.innerText = '';
            // display the messages for the user of this club
            for (let index = 0; index <= response.length - 1; index += 1) {
                insertToDOM(response[index]);
            }
        })
        .catch((error) => {
            // show error message
        });
});
