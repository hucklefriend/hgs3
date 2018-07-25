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
        this.oldItems = null;

        this.backgroundArea = document.getElementById('network-background');
        this.image = new NetworkImage();
        this.background = new NetworkBackground();
        this.backgroundOffset = {left: 0, top: 0};

        this.openMainLiks = null;
        this.changeNetworkLiks = null;

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

        document.getElementById('close-main').onclick = (e) => {
            this.closeMainWindow(e);
        };

        this.setLink();

        this.draw(false);
    }

    setLink()
    {
        this.openMainLiks = document.getElementsByClassName('network-open-main');
        for (let i = 0; i < this.openMainLiks.length; i++) {
            this.openMainLiks[i].onclick = (e) => {
                e.preventDefault();

                this.openMainWindow(e.target.dataset.parentId);

                return false;
            };
        }

        this.changeNetworkLiks = document.getElementsByClassName('network-change-main');
        for (let i = 0; i < this.changeNetworkLiks.length; i++) {
            this.changeNetworkLiks[i].onclick = (e) => {
                e.preventDefault();

                this.changeMain(e.target.dataset.parentId);

                return false;
            };
        }
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

    changeMain(parentId)
    {
        // 古いアイテムを退避
        this.oldItems = this.items;

        // 消えるやつの選定
        Object.keys(this.items).forEach((key) => {
            if (this.items[key].dom.id === parentId) {
                this.items[key].open();
            } else {
                this.items[key].dom.classList.add('closed');
            }
        });



        // 移動アニメーション
        window.requestAnimationFrame((time)=>{
            console.debug(time);

            /*if (this.changeMainAnimation(time)) {
                oldItems = null;
            }*/
        });


        // 表示ページのデータを取得
    }


    changeMainAnimation(time)
    {
        console.debug(time);

        // 親は指定位置に移動


        // 自分を指定位置に移動


        // 消えるアイテム


        // 増えるアイテム


        // 孫を子に


        // 消える子を親の周りに


        // 関係のない孫を消す


        if (parseInt(Math.random() * 2) === 0) {
            window.requestAnimationFrame((time)=>{
                if (this.changeMainAnimation(time)) {
                    oldItems = null;
                }
            });
        } else {
            // アニメーションが終わったらアイテムを削除
            Object.keys(this.oldItems).forEach((key)=>{
                this.oldItems[key].remove();
                delete this.oldItems[key];
            });

            this.oldItems = null;
        }
    }
}