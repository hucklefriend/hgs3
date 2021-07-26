
class NetworkItemManager
{
    constructor(network, data)
    {
        this.network = network;
        this.data = data;
        this.items = {};        // 全アイテム
        this.activeGeneration = [];     // 世代別に並べた時の現役世代のみ

        this.mainItemId = '';
        this.ready = false;
    }

    load()
    {
        this.data.forEach((itemData)=>{
            // HTML追加
            this.network.itemArea.insertAdjacentHTML('beforeend', itemData.dom);

            // インスタンスだけ先に作る
            this.items[itemData.id] = new NetworkItem(this);
        });

        // もっかいループ
        this.data.forEach((itemData)=>{
            this.items[itemData.id].load(itemData);

            if (itemData.hasOwnProperty('parentId') && itemData.parentId !== null) {
                // 誰かの子なので親にリンク
                this.items[itemData.parentId].children.push(this.items[itemData.id]);
            } else {
                // 現役世代
                this.activeGeneration.push(this.getItem(itemData.id));
            }
        });


        // 準備完了
        this.ready = true;
    }

    appear()
    {
        console.debug(this.items);

        Object.keys(this.items).forEach((key) => {
            this.items[key].appear();
        });
    }

    disappear()
    {
        Object.keys(this.items).forEach((key) => {
            this.items[key].disappear();
        });
    }

    startMainMode(mainItemId)
    {
        this.mainItemId = mainItemId;

        // メインになるアイテム以外を消す
        Object.keys(this.items).forEach((key) => {
            if (key !== mainItemId) {
                this.items[key].disappear();
            } else {
                this.items[key].openMain();
            }
        });
    }

    endMainMode()
    {
        Object.keys(this.items).forEach((key) => {
            if (key !== this.mainItemId) {
                this.items[key].appear();
            } else {
                this.items[key].closeMain();
            }
        });
    }
















    appearAnimation(animationTime)
    {
        let progress = animatinTime / 1000;


        Object.keys(this.items).forEach((key) => {
            this.items[key].appear();
        });
    }

    disappear()
    {
        Object.keys(this.items).forEach((key) => {
            this.items[key].disappear();
        });
    }

    open()
    {
        Object.keys(this.items).forEach((key) => {
            this.items[key].open();
        });
    }

    close()
    {
        Object.keys(this.items).forEach((key) => {
            this.items[key].close();
        });
    }

    dispose()
    {
        //this.dom.parentNode.removeChild(this.dom);      // HTML上から削除

        this.layout = null;

        Object.keys(this.items).forEach((key) => {
            this.items[key].dispose();
        });

        this.items = null;
    }

    getItem(key)
    {
        return this.items[key];
    }
}