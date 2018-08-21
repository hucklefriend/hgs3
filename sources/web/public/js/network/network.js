const BACKGROUND_WIDTH = 1000;
const BACKGROUND_HEIGHT = 1000;

class Network
{
    constructor(data)
    {
        this.main = document.getElementById('main');
        this.content = document.getElementById('content');
        this.contentArea = document.getElementById('content-area');
        this.networkArea = document.getElementById('network-area');
        this.itemArea = document.getElementById('network-items');

        this.activeItemManager = new NetworkItemManager(this, data);      // 今表示されているアイテムのマネージャー
        this.nextItemManager = null;        // 次に表示されるアイテムのマネージャー

        this.backgroundArea = document.getElementById('network-background');
        this.image = new NetworkImage();
        this.background = new NetworkBackground();
        this.backgroundOffset = {left: 0, top: 0};

        this.openMainLiks = null;
        this.changeNetworkLinks = null;
        this.animationStartTime = null;

        this.mainLoading = document.getElementById('content-loading');

        this.setInitialScroll();

        this.activeItemManager.load();
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

        this.networkArea.scrollTo(scrollX, scrollY);
    }


    start()
    {
        this.startCommon();
        this.activeItemManager.appear();
    }

    startContent()
    {
        this.startCommon();
        this.itemArea.classList.add('closed');
    }

    startCommon()
    {
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

        this.changeNetworkLinks = document.getElementsByClassName('network-change-main');
        for (let i = 0; i < this.changeNetworkLinks.length; i++) {
            this.changeNetworkLinks[i].onclick = (e) => {
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
        this.mainLoading.classList.remove('d-none');
        this.contentArea.classList.add('hide');
        this.networkArea.classList.add('mainMode');

        window.superagent
            .get(url)
            .set('X-Requested-With', 'XMLHttpRequest')
            .end((err, res) => {
                this.mainLoading.classList.add('d-none');
                this.content.innerHTML = res.body.html;
                this.contentArea.classList.remove('hide');
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

        document.getElementById('network-area').classList.add('mainMode');
    }

    closeMainWindow(e)
    {
        Object.keys(this.items).forEach((key) => {
            this.items[key].appear();
        });

        this.main.classList.add('closed');
        this.itemArea.classList.remove('closed');
        document.getElementById('network-area').classList.remove('mainMode');

        // 背景を戻すアニメーション
        this.animationStartTime = null;
        window.requestAnimationFrame((time)=>{this.imageGoTopAnimation(time);});

        this.networkArea.classList.remove('mainMode');

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

        this.image.draw(this.activeItemManager);
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




    changeNetwork(url)
    {
        // 新しいネットワークの情報を取得
        window.superagent
            .get(url)
            .set('X-Requested-With', 'XMLHttpRequest')
            .end((err, res) => {
                // TODO エラーチェック


                this.nextItemManager = new NetworkItemManager(this, res.body.network);

                // タイトルを変える

                // URLを変える


                this.appear();      // 次を出現させる
            });


        // 今出ているものを消す
        this.disappear();
    }




    appear()
    {
        // このタイミングでアイテム読み込み
        // DOMをHTML上に配置もこの中でやる
        this.activeItemManager.load(this.networkArea);


        this.animationStartTime = null;
        window.requestAnimationFrame((time)=>{this.appearAnimation(time);});
    }

    appearAnimation(time)
    {
        if (this.animationStartTime == null) {
            this.animationStartTime = time;
        }

        let animationTime = time - this.animationStartTime;
        this.nextItemManager.appearAnimation(animationTime);
        if (animationTime <= 1000) {
            this.activeItemManager.disappearAnimation(animationTime);
            window.requestAnimationFrame((time)=>{this.disappearAnimation(time);});
        } else {
            // 次のネットワークが用意できている？
            if (this.nextItemManager !== null && this.nextItemManager.ready) {
                this.activeItemManager.dispose();
                this.activeItemManager = this.nextItemManager;
                this.nextItemManager = null;

                // 次のネットワークを出現させる
                this.animationStartTime = null;
                window.requestAnimationFrame((time)=>{this.appearAnimation(time);});
            }
        }
    }

    disappear()
    {
        this.animationStartTime = null;
        window.requestAnimationFrame((time)=>{this.disappearAnimation(time);});
    }

    disappearAnimation(time)
    {
        if (this.animationStartTime == null) {
            this.animationStartTime = time;
        }

        let animationTime = time - this.animationStartTime;
        if (animationTime <= 1000) {
            this.activeItemManager.disappearAnimation(animationTime);
            window.requestAnimationFrame((time)=>{this.disappearAnimation(time);});
        } else {
            // 次のネットワークが用意できている？
            if (this.nextItemManager !== null && this.nextItemManager.ready) {
                this.activeItemManager.dispose();
                this.activeItemManager = this.nextItemManager;
                this.nextItemManager = null;

                // 次のネットワークを出現させる
                this.animationStartTime = null;
                window.requestAnimationFrame((time)=>{this.appearAnimation(time);});
            }
        }
    }
}