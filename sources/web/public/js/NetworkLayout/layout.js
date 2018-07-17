class NetworkLayout
{
    constructor(data)
    {
        this.area = document.getElementById('network-layout');
        this.networkCanvas = document.getElementById('network');
        this.context = this.networkCanvas.getContext('2d');
        this.networkCover = document.getElementById('canvas-cover');
        this.main = document.getElementById('main');
        this.mainItem = null;
        this.items = [];
        this.background = new NetworkBackground();

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
        return this.area.offsetWidth;
    }

    height()
    {
        return this.area.offsetHeight;
    }

    getItem(id)
    {
        return this.items[id];
    }

    changeWindowSize()
    {
        this.area.style.height = window.innerHeight + 'px';

        let w = this.area.offsetWidth;
        let h = this.area.offsetHeight;

        this.networkCanvas.width = this.networkCover.width = w;
        this.networkCanvas.height = this.networkCover.height = h;

        // 画面の大きさに合わせて、描画する点の量を調整
    }

    draw()
    {
        // 配置確定
        // TODO これは更新処理に書くべきで、描画メソッドでやるべきではない
        Object.keys(this.items).forEach((key) => {
            this.items[key].setPosition();
        });

        // 背景の描画
        this.background.draw();

        this.context.clearRect(0, 0, this.networkCanvas.width, this.networkCanvas.height);

        this.context.save();

        this.context.strokeStyle = 'rgba(60, 90, 180, 0.5)';
        this.context.lineWidth = 1;

        // 孫から背景への線を描画
        Object.keys(this.items).forEach((key) => {
            this.items[key].drawChildToBackgroundBallLine(this.context);
        });

        this.context.restore();


        this.context.save();

        // アイテムを描画
        Object.keys(this.items).forEach((key) => {
            this.items[key].draw(this.context);
        });

        this.context.restore();
    }

    getMainItem()
    {
        return this.items[this.mainItemId];
    }

    start()
    {
        window.onresize = () => {
            this.changeWindowSize();
            this.background.changeWindowSize();
            this.draw();
        };

        this.main.onscroll = () => {
            this.draw();
            this.networkCanvas.style.top = -(this.main.scrollTop / 8) + 'px';
            this.background.canvas.style.top = -(this.main.scrollTop / 15) + 'px';
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

        this.draw();
    }


    openMainWindow(parentId)
    {
        // TODO 取り直さなくても、メンバ変数にnetwork-item持ってる
        let items = document.getElementsByClassName('network-item');
        for (let i = 0; i < items.length; i++) {
            if (items[i].id === parentId) {
                items[i].classList.add('opened');
            } else {
                items[i].classList.add('closed');
            }
        }

        this.main.classList.remove('closed');
    }

    closeMainWindow(e)
    {
        // TODO 取り直さなくても、メンバ変数にnetwork-item持ってる
        let items = document.getElementsByClassName('network-item');
        for (let i = 0; i < items.length; i++) {
            items[i].classList.remove('closed');
            items[i].classList.remove('opened');
        }

        this.main.classList.add('closed');
    }
}