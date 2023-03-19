class App {
    constructor() {
        this.client = new Client();
        this.cardsContainer = document.getElementById('cards_container');
        this.generateGameButton = document.getElementById('generate_game_button');
        this.sortCardsButton = document.getElementById('sort_cards_button');
        this.valuesOrderContainer = document.getElementById('values_order_container');
        this.colorsOrderContainer = document.getElementById('colors_order_container');
        this.generateGameButton.addEventListener('click', this.generateGame.bind(this));
        this.sortCardsButton.addEventListener('click', this.sortCards.bind(this));
    }


    async sortCards() {
        try {
            const response = await this.client.request('sort_cards.json', 'POST');
            this.cardsContainer.innerHTML = '';
            response.cards.forEach((card) => {
                const div = document.createElement('div');
                div.classList.add('col-md-1');
                div.innerHTML =
                    ('<div class="card mb-4 box-shadow">\n' +
                        '   <img class="card-img-top" alt="Card image cap" src="images/'+card.value+'_'+card.color+'.png" />\n' +
                        '</div>').trim();
                this.cardsContainer.append(div);
            });
        } catch (error) {
            console.error(error);
        }
    }
    async generateGame() {
        try {
            const response = await this.client.request('game.json', 'GET');
            this.cardsContainer.innerHTML = '';
            this.valuesOrderContainer.innerHTML = '';
            this.colorsOrderContainer.innerHTML = '';
            response.cards.forEach((card) => {
                const div = document.createElement('div');
                div.classList.add('col-md-1');
                div.innerHTML =
                    ('<div class="card mb-4 box-shadow">\n' +
                    '   <img class="card-img-top" alt="Card image cap" src="images/'+card.value+'_'+card.color+'.png" />\n' +
                    '</div>').trim();
                this.cardsContainer.append(div);
            });
            response.colors_order.forEach((color) => {
                const li = document.createElement('li');
                li.classList.add('list-inline-item');
                li.innerHTML = ('<img class="card-img-top" alt="Card image cap" src="images/'+color+'.png" />').trim();
                this.colorsOrderContainer.append(li);
            });
            response.values_order.forEach((value) => {
                const li = document.createElement('li');
                li.classList.add('list-inline-item');
                li.innerHTML = ('<img class="card-img-top" alt="Card image cap" src="images/'+value+'_diamonds.png" />').trim();
                this.valuesOrderContainer.append(li);
            });

        } catch (error) {
            console.error(error);
        }
    }
}

class Client {
    request (url, method, data) {
        return new Promise((resolve, reject) => {
            const xhr = new XMLHttpRequest();
            xhr.open(method, url);

            xhr.onload = () => {
                if (xhr.status >= 200 && xhr.status < 300) {
                    resolve(JSON.parse(xhr.responseText));
                } else {
                    reject({
                        status: xhr.status,
                        statusText: xhr.statusText
                    });
                }
            };

            xhr.onerror = () => {
                reject({
                    status: xhr.status,
                    statusText: xhr.statusText
                });
            };

            xhr.send(JSON.stringify(data));
        });
    }
}