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


        // ”wŒi—p‚Ì“_‚Ì¶¬
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

        // ‰æ–Ê‚Ì‘å‚«‚³‚É‡‚í‚¹‚ÄA•`‰æ‚·‚é“_‚Ì—Ê‚ð’²®
    }

    draw()
    {

        // ”wŒi‚Ì•`‰æ



        // ”z’uŠm’è
        Object.keys(this.items).forEach((key) => {
            this.items[key].setPosition();
        });

        this.context.save();

        // ŠÖŒW‚É‡‚í‚¹‚Äƒ‰ƒCƒ“‚ð•`‚­
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