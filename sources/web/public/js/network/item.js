
class NetworkItem
{
    constructor(manager)
    {
        this.manager = manager;
        this.id = null;
        this.dom = null;
        this.parent = null;
        this.positionSetting = null;
        this.position = {x: 0, y: 0};
        this.animationStatus = null;
        this.children = [];
        this.backgroundBalls = [];

        this.originalSize = null;
    }

    load(data)
    {
        this.id = data.id;
        this.dom = document.getElementById(data.id);
        if (data.hasOwnProperty('parentId')) {
            this.parent = this.manager.getItem(data.parentId);
        }

        // 幅と高さを設定
        this.originalSize = this.dom.getBoundingClientRect();
        // 幅と高さをセットしておかないと、拡大縮小アニメーションができない
        this.dom.style.width = this.originalSize.width + 'px';
        this.dom.style.height = this.originalSize.height + 'px';

        this.setupPosition(data.position);

        // とりあえずここで配置設定
        // 親のオフセットの場合、親が先に設定されてないといけない
        this.setPosition();
    }

    appear(animationTime, progress)
    {

    }

    disappear(animationTime, progress)
    {

    }

    open()
    {

    }

    close()
    {

    }

    dispose()
    {
        this.manager = null;
        this.data = null;
        this.dom = null;
        this.id = null;
        this.positionSetting = null;
        this.position = null;
        this.parent = null;
        this.offset = null;
        this.animationStatus = null;
        this.originalSize = null;
        this.children = null;
        this.backgroundBalls = null;
    }


    draw()
    {
        // 親からの線は親が引いてくれる

        // 自分の球を描画

        // 自分から子への線を引く
    }


    setupPosition(data)
    {
        if (data.type === 'fixed') {
            // 配置固定
            this.positionSetting = {
                x: data.position.x,
                y: data.position.y
            };

            this.setPosition = () => {this.setPos(this.positionSetting.x, this.positionSetting.y)};
        } else if (data.type === 'parent') {
            // 自分の親からのオフセット
            this.positionSetting = {
                offset: {
                    x: data.offset.x,
                    y: data.offset.y
                }
            };
            this.setPosition = () => {this.setPosParentOffset()};
        }
    }

    setPos(x, y)
    {
        this.dom.style.left = (x - (this.originalSize.width / 2)) + 'px';
        this.dom.style.top = (y - (this.originalSize.height / 2)) + 'px';
        this.position.x = x;
        this.position.y = y;
    }

    setPosParentOffset()
    {
        let x = this.parent.position.x + this.positionSetting.offset.x;
        let y = this.parent.position.y + this.positionSetting.offset.y;

        this.setPos(x, y);
    }

    setPosTargetOffset()
    {
        let x = this.positionSetting.target.position.x + this.positionSetting.offset.x;
        let y = this.positionSetting.target.position.y + this.positionSetting.offset.y;

        this.setPos(x, y);
    }
}