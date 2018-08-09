const BACKGROUND_WIDTH = 1000;
const BACKGROUND_HEIGHT = 1000;
const BACKGROUND_CENTER_X = 500;
const BACKGROUND_CENTER_Y = 500;

class NetworkLayout
{
    constructor(data)
    {
        console.debug(data);

        this.main = document.getElementById('main');
        this.content = document.getElementById('content');
        this.mainItem = null;
        this.mainItemId = null;
        this.itemArea = document.getElementById('network-items');
        this.items = [];
        this.oldItems = null;
        this.oldMainItemId = null;

        this.backgroundArea = document.getElementById('network-background');
        this.image = new NetworkImage();
        this.background = new NetworkBackground();
        this.backgroundOffset = {left: 0, top: 0};

        this.openMainLiks = null;
        this.changeNetworkLiks = null;
        this.animationStartTime = null;

        this.changeWindowSize();

        this.load(data);

        this.setInitialScroll();
    }

    load(data)
    {
        if (data.hasOwnProperty('main')) {
            this.mainItemId = data.main.id;
            this.itemArea.insertAdjacentHTML('beforeend', data.main.dom);
            this.items[this.mainItemId] = new NetworkItem(this, data.main);
            this.items[this.mainItemId].isMain = true;
            this.items[this.mainItemId].dom.classList.add('main');
        }

        if (data.hasOwnProperty('children')) {
            data.children.forEach((element) => {
                this.itemArea.insertAdjacentHTML('beforeend', element.dom);
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
        /*
        this.backgroundArea.style.width = window.innerWidth + 'px';
        this.backgroundArea.style.height = window.innerHeight + 'px';
        */
        /*
        this.backgroundOffset.left = (window.innerWidth - BACKGROUND_WIDTH) / 2;
        this.backgroundOffset.top = (window.innerHeight - BACKGROUND_HEIGHT) / 2;
        let left = this.backgroundOffset.left + 'px';
        let top = this.backgroundOffset.top + 'px';*/
        //this.image.changeWindowSize(left, top);
        //this.background.changeWindowSize(left, top);

        //this.updateItemPosition();
    }

    setInitialScroll()
    {
        let scrollX = 0, scrollY = 0;

        // スクロール位置の調整
        if (window.innerWidth < BACKGROUND_WIDTH) {
            scrollX = (BACKGROUND_WIDTH - window.innerWidth) / 2;
        }

        if (window.innerHeight < BACKGROUND_HEIGHT) {
            scrollY = (BACKGROUND_HEIGHT - window.innerHeight) / 2;
        }

        window.scrollTo(scrollX, scrollY);
    }

    getMainItem()
    {
        return this.items[this.mainItemId];
    }

    start()
    {
        this.startCommon();
        Object.keys(this.items).forEach((key) => {
            this.items[key].appear();       // appearで出現させる
        });
    }

    startContent()
    {
        this.startCommon();
        this.itemArea.classList.add('closed');
    }

    startCommon()
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

                this.openMainWindow(e.target, e.target.dataset.parentId);

                return false;
            };
        }

        this.changeNetworkLiks = document.getElementsByClassName('network-change-main');
        for (let i = 0; i < this.changeNetworkLiks.length; i++) {
            this.changeNetworkLiks[i].onclick = (e) => {
                e.preventDefault();

                this.changeMain(e.target.getAttribute('href'), e.target.dataset.parentId);

                return false;
            };
        }
    }

    updateItemPosition()
    {
        Object.keys(this.items).forEach((key) => {
            if (!this.items[key].dom.classList.contains('opened')) {
                this.items[key].setPosition();
            }
        });
    }

    openMainWindow(target, parentId)
    {
        let url = target.getAttribute('href');

        window.superagent
            .get(url)
            .set('X-Requested-With', 'XMLHttpRequest')
            .end((err, res) => {
                this.content.innerHTML = res.body.html;
            });

        Object.keys(this.items).forEach((key) => {
            if (this.items[key].dom.id === parentId) {
                this.items[key].open();
            } else {
                this.items[key].close();
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

        // 背景を戻すアニメーション
        this.animationStartTime = null;
        window.requestAnimationFrame((time)=>{this.imageGoTopAnimation(time);});

        // メインウィンドウの内容を消しておく
        setTimeout(()=>{
            this.content.innerHTML = '';
        }, 500);
    }

    imageGoTopAnimation(time)
    {
        if (this.animationStartTime == null) {
            this.animationStartTime = time;
        }

        let animationTime = time - this.animationStartTime;
        this.background.goTop(animationTime, this.backgroundOffset.top);
        this.image.goTop(animationTime, this.backgroundOffset.top);

        this.draw(true);

        if (animationTime <= 500) {
            window.requestAnimationFrame((time)=>{this.imageGoTopAnimation(time);});
        } else {
            this.main.scrollTop = 0;
            // TODO scrollイベントが走らないか要確認
        }
    }



    draw(onlyImage)
    {
        if (!onlyImage) {
            this.background.draw();
        }

        this.image.draw(this.items);
    }

    changeMain(url, id)
    {
        // 古いアイテムを退避
        this.oldItems = this.items;
        this.oldMainItemId = this.mainItemId;
        this.mainItemId = id;

        // 新しくメインになるアイテム
        let newMain = this.items[id];
        newMain.animationStatus = {from: {x: newMain.position.x, y: newMain.position.y}};
        newMain.changePosition(newMain.data.mainMode.main);

        this.items = {};
        this.items[id] = newMain;
        this.items[id].isMain = true;
        this.items[id].parent = null;
        newMain.dom.classList.add('main');

        // 旧メイン
        let oldMain = this.oldItems[this.oldMainItemId];
        this.items[this.oldMainItemId] = oldMain;
        oldMain.animationStatus = {from: {x: oldMain.position.x, y: oldMain.position.y}};
        oldMain.parent = newMain;
        oldMain.changePosition(newMain.getChildData(this.oldMainItemId));
        oldMain.isMain = false;
        oldMain.dom.classList.remove('main');

        // 旧メインの子は最小化して位置替え
        oldMain.setChildPosition(oldMain.childBalls.length);

        // 配置確定(この時点でCSSのアニメーションで新旧メインのみ動き始める)
        Object.keys(this.items).forEach((key) => {
            this.items[key].setPosition();
        });

        // 旧メインの子の処理
        let idx = 0;
        Object.keys(this.oldItems).forEach((key) => {
            if (this.oldItems[key].dom.id === this.oldMainItemId) {
                // 新しい位置に移動
                oldMain.childBalls[idx].animation = {
                    from: oldMain.animationStatus.from,
                    to: {
                        x: oldMain.position.x + oldMain.childBalls[idx].offset.x,
                        y: oldMain.position.y + oldMain.childBalls[idx].offset.y
                    },
                    item: this.oldItems[key]
                };
                idx++;
            } else if (this.oldItems[key].dom.id !== id && this.oldItems[key].dom.id !== this.oldMainItemId) {
                this.oldItems[key].disappear();

                // 新しい位置に移動
                oldMain.childBalls[idx].animation = {
                    from: {
                        x: this.oldItems[key].position.x,
                        y: this.oldItems[key].position.y
                    },
                    to: {
                        x: oldMain.position.x + oldMain.childBalls[idx].offset.x,
                        y: oldMain.position.y + oldMain.childBalls[idx].offset.y
                    },
                    item: this.oldItems[key]
                };

                idx++;
            }
        });

        // 新しい要素の追加
        idx = 0;
        newMain.data.mainMode.children.forEach((newItem)=>{
            if (newItem.id !== this.oldMainItemId) {
                this.itemArea.insertAdjacentHTML('beforeend', newItem.dom);
                this.items[newItem.id] = new NetworkItem(this, newItem, newMain);
                this.items[newItem.id].setPosition();
                this.items[newItem.id].moving();

                newMain.childBalls[idx].animation = {
                    from: {
                        x: newMain.animationStatus.from.x + newMain.childBalls[idx].offset.x,
                        y: newMain.animationStatus.from.y + newMain.childBalls[idx].offset.y
                    },
                    to: {
                        x: this.items[newItem.id].position.x,
                        y: this.items[newItem.id].position.y
                    },
                    item: this.items[newItem.id]
                };

                idx++;
            }
        });

        // 遷移先の情報を取得
        this.updateItems(url);

        // 移動アニメーション
        this.animationStartTime = null;
        window.requestAnimationFrame((time)=>{this.changeMainAnimation(time);});

        this.setLink();
    }

    updateItems(url)
    {
        window.superagent
            .get(url)
            .set('X-Requested-With', 'XMLHttpRequest')
            .end((err, res) => {
                res.body.network.children.forEach((element)=>{
                    this.items[element.id].data = element;
                });
            });
    }



    changeMainAnimation(time)
    {
        if (this.animationStartTime == null) {
            this.animationStartTime = time;
        }

        let animationTime = time - this.animationStartTime;
        this.image.changeAnimation(animationTime, this.oldItems, this.items,
            this.items[this.mainItemId], this.items[this.oldMainItemId], this.backgroundOffset);

        if (animationTime <= 500) {
            window.requestAnimationFrame((time)=>{this.changeMainAnimation(time);});
        } else {
            Object.keys(this.oldItems).forEach((key) => {
                if (!this.items.hasOwnProperty(key)) {
                    this.oldItems[key].dispose();
                    delete this.oldItems[key];
                }
            });

            this.oldItems = null;
            this.oldMainItemId = null;

            this.draw(true);
        }
    }
}