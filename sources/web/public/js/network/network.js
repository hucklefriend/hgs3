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

        this.isChanging = false;
        this.newNetworkingLoading = 0;

        this.changeWindow();
        window.addEventListener('resize', ()=>{ this.changeWindow(); });

    }

    changeWindow()
    {
        if (window.innerWidth > BACKGROUND_WIDTH) {
            let left = (window.innerWidth - BACKGROUND_WIDTH) / 2;
            this.backgroundArea.style.left = this.itemArea.style.left = left + 'px';
        } else {
            this.backgroundArea.style.left = this.itemArea.style.left = 0;
        }

        if (window.innerHeight > BACKGROUND_HEIGHT) {

        }
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

        this.main.classList.remove('closed');
        //this.itemArea.classList.add('closed');

        this.activeItemManager.startMainMode(parentId);


        document.getElementById('network-area').classList.add('mainMode');
    }

    closeMainWindow(e)
    {
        this.activeItemManager.endMainMode();

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
        if (this.isChanging) {
            // 別の遷移処理稼働中なら遷移させない
            return;
        }
        this.isChanging = true;
        this.newNetworkingLoading = 0;

        this.nextItemManager = null;

        // 新しいアイテムを取得
        this.getNewItems(url);


        // アイテムの消去はCSSアニメーションで
        this.activeItemManager.disappear();

        // 線と球も単純にCSSでcanvasタグ自体をフェードアウトさせる
        this.image.canvas.classList.add('fade-out');

        setTimeout(()=>{
            // canvasを綺麗にしてから、fade-outを戻せばOK
            this.image.clearRect();
            this.image.canvas.classList.remove('fade-out');

            // 内部的に消す
            this.activeItemManager.dispose();
            this.activeItemManager = null;
            this.newNetworkingLoading++;
            this.waitNewItems();
        }, 500);

    }

    getNewItems(url)
    {
        window.superagent
            .get(url)
            .set('X-Requested-With', 'XMLHttpRequest')
            .end((err, res) => {
                console.debug(res.body);
                // TODO エラー処理
                this.nextItemManager = new NetworkItemManager(this, res.body.network);
                this.newNetworkingLoading++;
            });
    }

    disappear()
    {
    }

    waitNewItems()
    {
        if (this.newNetworkingLoading === 2) {
            this.showNewItems();
        } else {
            // 取得中のはずなのでもう少し待って再度呼び出し
            setTimeout(()=>{this.showNewItems();}, 300);
        }
    }

    showNewItems()
    {
        // TODO PUSH STATE
        this.nextItemManager.load();
        this.nextItemManager.appear();
        this.setLink();

        this.activeItemManager = this.nextItemManager;
        this.nextItemManager = null;

        this.draw(true);


        this.isChanging = false;
    }
}