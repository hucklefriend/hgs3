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


        // �w�i�p�̓_�̐���
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

        // ��ʂ̑傫���ɍ��킹�āA�`�悷��_�̗ʂ𒲐�
    }

    draw()
    {

        // �w�i�̕`��



        // �z�u�m��
        Object.keys(this.items).forEach((key) => {
            this.items[key].setPosition();
        });

        this.context.save();

        // �֌W�ɍ��킹�ă��C����`��
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