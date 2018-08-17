
class NetworkItemManager
{
    constructor(network, data)
    {
        this.network = network;
        this.data = data;
        this.items = [];        // 全アイテム
        this.activeGeneration = [];     // 世代別に並べた時の現役世代のみここに

        this.data = null;
        this.ready = false;
    }

    load()
    {
        this.data.forEach((itemData)=>{
            // HTML追加
            this.network.networkArea.appendChild(itemData.dom);

            let item = new NetworkItem(this);
            item.load(itemData);
            this.items[item.id] = item;
        });

        // 世代設定のためもっかいループ
        this.data.forEach((itemData)=>{
            if (itemData.hasOwnProperty('parentId')) {
                // 誰かの子なので親にリンク
                this.items[itemData.id].children.push(this.items[itemData.parentId]);
            } else {
                // 現役世代
                this.activeGeneration.push(this.getItem(itemData.id));
            }
        });

        this.ready = true;
    }

    appear()
    {
        Object.keys(this.items).forEach((key) => {
            this.items[key].appear();
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
        this.dom.parentNode.removeChild(this.dom);      // HTML上から削除

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