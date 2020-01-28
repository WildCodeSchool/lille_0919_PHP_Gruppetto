/* eslint-disable import/no-extraneous-dependencies */

require('../scss/messages.scss');
require('../js/searchBar');
// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.
const $ = require('jquery');

const Routing = require('../../vendor/friendsofsymfony/jsrouting-bundle/Resources/public/js/router');
const Routes = require('./js_routes.json');

Routing.setRoutingData(Routes);

const section = document.getElementById('messages-section');
const messagesList = document.getElementById('messages-list');
const newMessageForm = document.getElementById('new-message-form');
const userCard = document.getElementById('js-user-card');
const userAvatar = document.getElementById('user-avatar');
const userName = document.getElementById('user-name');
const userDescription = document.getElementById('user-description');

// send a message
if (newMessageForm) {
    newMessageForm.addEventListener('submit', (event) => {
        event.preventDefault();
        new Promise((resolve, reject) => {
            const url = Routing.generate('club_chat_general');
            const xhr = new XMLHttpRequest();
            const formData = new FormData(newMessageForm);

            xhr.open('POST', url);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.addEventListener('load', function () {
                if (this.readyState === 4) {
                    if (this.status === 200 && this.statusText === 'OK') {
                        resolve(JSON.parse(this.responseText));
                    } else {
                        reject(JSON.parse(this.responseText));
                    }
                }
            });
            xhr.send(formData);
        })

            .then((response) => {
                $('#general_chat_contentMessage').val('');
            })
            .catch((error) => {
            });
    });
}

function createElement(name) {
    return document.createElement(name);
}

function insertToDOM(data) {
    const li = createElement('li');
    li.className = 'general-chat-message';

    // data
    const messageId = data.messageID;
    const pMessageNode = data.content;
    const sentBy = (data.soloName ? data.soloName : data.clubName);
    const dateNode = data.dateMessage;


    // add all the elements to the message-list in the right order
    const liMessage = messagesList.appendChild(li);
    liMessage.innerHTML = `<span class="sentBy" id="${messageId}">${sentBy}</span>`
        + `<p class="message">${pMessageNode}</p>`
        + `<span class="sentAt">${dateNode}</span>`;

    // get user infos
    /*    function getUserInfos(clickedId)
    { */
    document.getElementById(messageId).addEventListener('click', (event) => {
        const url = Routing.generate('club_chat_getUserInfos', { messageId });
        new Promise(((resolve, reject) => {
            const xhr = new XMLHttpRequest();

            xhr.open('GET', url);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.addEventListener('load', function () {
                if (this.readyState === 4) {
                    if (this.status === 200 && this.statusText === 'OK') {
                        resolve(JSON.parse(this.responseText));
                    } else {
                        reject(JSON.parse(this.responseText));
                    }
                }
            });

            xhr.send();
        }))
            .then((response) => {
                // display the infos of this user
                if (data.soloName) {
                    const datas = response[0];
                    const { lastnameSolo } = datas;
                    const { firstnameSolo } = datas;
                    const { avatarSolo } = datas;
                    const { descriptionSolo } = datas;
                    userCard.style.display = 'flex';
                    userAvatar.setAttribute('src', avatarSolo);
                    userName.innerText = `${firstnameSolo} ${lastnameSolo}`;
                    userDescription.innerText = descriptionSolo;
                } else {
                    const datas = response[0];
                    const { nameClub } = datas;
                    const { cityClub } = datas;
                    const { logoClub } = datas;
                    const { descriptionClub } = datas;
                    userCard.style.display = 'flex';
                    userAvatar.setAttribute('src', logoClub);
                    userName.innerText = `${nameClub}, ${cityClub}`;
                    userDescription.innerText = descriptionClub;
                }

                if (document.getElementById('close-btn')) {
                    document.getElementById('close-btn').addEventListener('click', () => {
                        document.getElementById('js-user-card').style.display = 'none';
                    });
                }
            })
            .catch((error) => {
                // show error message
            });
    });
}
// }

// get all club messages
if (newMessageForm) {
    window.setInterval(() => {
        const url = Routing.generate('club_chat_get_messages');
        new Promise(((resolve, reject) => {
            const xhr = new XMLHttpRequest();

            xhr.open('GET', url);
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            xhr.addEventListener('load', function (event) {
                if (this.readyState === 4) {
                    if (this.status === 200 && this.statusText === 'OK') {
                        resolve(JSON.parse(this.responseText));
                    } else {
                        reject(JSON.parse(this.responseText));
                    }
                }
            });

            xhr.send();
        }))
            .then((response) => {
                // display the messages for the user of this club
                document.getElementById('messages-list').innerHTML = '';
                for (let index = 0; index <= response.length - 1; index += 1) {
                    insertToDOM(response[index]);
                }
                $('.js-chatbox').animate({ scrollTop: $('.js-chatbox').get(0).scrollHeight });
            })
            .catch((error) => {
                // show error message
            });
    }, 1000);
}
