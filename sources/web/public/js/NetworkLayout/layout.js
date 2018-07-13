class NetworkLayout
{
    constructor()
    {
        this.networkCanvas = document.getElementById('network');
        this.context = this.networkCanvas.getContext('2d');
        this.networkCover = document.getElementById('canvas-cover');
        this.items = [];

        this.networkCanvas.width = this.networkCover.width = window.innerWidth;
        this.networkCanvas.height = this.networkCover.height = window.innerHeight;

        window.onresize = ()=>{
            this.changeWindowSize();
            this.draw();
        };


        // 背景用の点の生成
    }

    addItem(id, relations, options)
    {
        this.items[id] = new NetworkItem(id, relations, options)
    }

    getItem(id)
    {
        return this.items[id];
    }

    changeWindowSize()
    {
        this.networkCanvas.width = this.networkCover.width = window.innerWidth;
        this.networkCanvas.height = this.networkCover.height = window.innerHeight;

        // 画面の大きさに合わせて、描画する点の量を調整
    }

    draw()
    {

        // 背景の描画



        // 配置確定
        Object.keys(this.items).forEach((key) => {
            this.items[key].setPosition();
        });

        this.context.save();

        // 関係に合わせてラインを描く
        this.context.strokeStyle = '#666';
        this.context.lineWidth = 3;
        Object.keys(this.items).forEach((key) => {
            this.items[key].drawRelationLine(this);
        });

        this.context.restore();
    }

    start()
    {
        this.draw();
    }
}