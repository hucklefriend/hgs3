const BACKGROUND_WIDTH = 1000;
const BACKGROUND_HEIGHT = 1000;
const BACKGROUND_CENTER_X = 500;
const BACKGROUND_CENTER_Y = 500;

class NetworkLayout
{
    constructor(data)
    {
        //this.networkCover = document.getElementById('canvas-cover');
        this.main = document.getElementById('main');
        this.mainItem = null;
        this.itemArea = document.getElementById('network-items');
        this.items = [];

        this.backgroundArea = document.getElementById('network-background');
        this.image = new NetworkImage();
        this.background = new NetworkBackground();
        this.backgroundOffset = {left: 0, top: 0};

        this.changeWindowSize();

        this.load(data);
    }

    load(data)
    {
        if (data.hasOwnProperty('main')) {
            this.mainItemId = data.main.id;
            this.items[this.mainItemId] = new NetworkItem(this, data.main);
            this.items[this.mainItemId].isMain = true;
        }

        if (data.hasOwnProperty('children')) {
            data.children.forEach((element)=>{
                this.items[element.id] = new NetworkItem(this, element, this.items[this.mainItemId]);
            });
        }
    }

    width()
    {
        return window.innerWidth;
    }

    height()
    {
        return window.innerHeight;
    }

    getItem(id)
    {
        return this.items[id];
    }

    changeWindowSize()
    {
        this.backgroundArea.style.width = window.innerWidth + 'px';
        this.backgroundArea.style.height = window.innerHeight + 'px';

        this.backgroundOffset.left = (window.innerWidth - BACKGROUND_WIDTH) / 2;
        this.backgroundOffset.top = (window.innerHeight - BACKGROUND_HEIGHT) / 2;
        let left = this.backgroundOffset.left + 'px';
        let top = this.backgroundOffset.top + 'px';
        this.image.changeWindowSize(left, top);
        this.background.changeWindowSize(left, top);

        this.updateItemPosition();
    }

    getMainItem()
    {
        return this.items[this.mainItemId];
    }

    start()
    {
        window.onresize = () => {
            this.changeWindowSize();
            this.draw(false);
        };

        this.main.onscroll = () => {
            this.image.scroll(this.main.scrollTop, this.backgroundOffset.top);
            this.background.scroll(this.main.scrollTop, this.backgroundOffset.top);

            this.draw(true);
        };

        let links = document.getElementsByClassName('network-layout-link');
        for (let i = 0; i < links.length; i++) {
            links[i].onclick = (e) => {
                e.preventDefault();

                this.openMainWindow(e.target.dataset.parentId);

                return false;
            };
        }

        document.getElementById('close-main').onclick = (e) => {
            this.closeMainWindow(e);
        };

        this.draw(false);
    }

    updateItemPosition()
    {
        Object.keys(this.items).forEach((key) => {
            this.items[key].setPosition();
        });
    }

    openMainWindow(parentId)
    {
        Object.keys(this.items).forEach((key) => {
            if (this.items[key].dom.id === parentId) {
                this.items[key].open();
            } else {
                this.items[key].dom.classList.add('closed');
            }
        });

        this.main.classList.remove('closed');
        this.itemArea.classList.add('closed');

    }

    closeMainWindow(e)
    {
        Object.keys(this.items).forEach((key) => {
            this.items[key].appear();
        });

        this.main.classList.add('closed');
        this.itemArea.classList.remove('closed');
    }

    draw(onlyImage)
    {
        if (!onlyImage) {
            this.background.draw();
        }

        this.image.draw(this.items);
    }
}