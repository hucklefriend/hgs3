
class NetworkItem
{
    constructor(manager)
    {
        this.manager = manager;
        this.data = null;
        this.dom = null;
        this.id = null;
        this.position = {x: 0, y: 0};
        this.parent = null;
        this.offset = {x: 0, y: 0};
        this.animationStatus = null;
        this.children = [];

        this.originalSize = null;
    }

    load(data)
    {
        this.dom = document.getElementById(data.id);

        // 幅と高さを設定
        this.originalSize = this.dom.getBoundingClientRect();
        // 幅と高さをセットしておかないと、拡大縮小アニメーションができない
        this.dom.style.width = this.originalSize.width + 'px';
        this.dom.style.height = this.originalSize.height + 'px';



        this.changePosition(data);

        // 子の位置決めのため、ここで位置確定
        this.setPosition();

        if (data.hasOwnProperty('children')) {
            this.setChildPosition(data.childNum);
        }
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
        this.position = null;
        this.parent = null;
        this.offset = null;
        this.animationStatus = null;
        this.originalSize = null;
        this.children = null;
    }


    draw()
    {
        // 親からの線は親が引いてくれる

        // 自分の球を描画

        // 自分から子への線を引く
    }


    setupPosition(target, offset)
    {
        // 配置は以下の2種類で設定できる
        // 中央からのオフセット位置
        // 特定のアイテムからのオフセット位置


        if (data.hasOwnProperty('position')) {
            if (data.position.hasOwnProperty('offset')) {
                if (!this.parent) {
                    // 親がいないのにオフセットはできない
                    this.setPosition = () => {this.setPosCenter()};
                } else {
                    this.offset = data.position.offset;
                    this.setPosition = () => {this.setPosOffset()};
                }
            } else {
                switch (data.position) {
                    case 'center':
                        this.setPosition = () => {this.setPosCenter()};
                        break;
                    case 'left-top':
                        this.setPosition = () => {this.setPosLeftTop()};
                        break;
                    case 'right-top':
                        this.setPosition = () => {this.setPosRightTop()};
                        break;
                    case 'left-bottom':
                        this.setPosition = () => {this.setPosLeftBottom()};
                        break;
                    case 'right-bottom':
                        this.setPosition = () => {this.setPosRightBottom()};
                        break;
                }
            }
        } else {
            this.setPosition = ()=> {this.setPosRandom()};
        }
    }

    setChildPosition(childNum)
    {

        if (childNum <= 0) {
            return;
        }

        // なるべく重ならないようにちらばらせたい
        // 大まかな位置を決める
        let positions = [
            {x: -50, y: -50}, {x: 0, y: -50}, {x: 50, y: -50},
            {x: -50, y: 0}, {x: 0, y: 0}, {x: 50, y: 0},
            {x: -50, y: 50}, {x: 0, y: 50}, {x: 50, y: 50},
        ];

        let i = 0;

        // シャッフル
        for(i = positions.length - 1; i > 0; i--){
            let r = Math.floor(Math.random() * (i + 1));
            let tmp = positions[i];
            positions[i] = positions[r];
            positions[r] = tmp;
        }
    }

    setPosRandom()
    {
        let minLeft = 0;
        let maxLeft = this.layout.width() - minLeft;
        let minTop = 0;
        let maxTop = this.layout.height() - minTop;

        let left = Math.floor(Math.random() * (maxLeft - minLeft) + minLeft);
        let top = Math.floor(Math.random() * (maxTop - minTop) + minTop);

        this.dom.style.left = (left + this.layout.backgroundOffset.left) + 'px';
        this.dom.style.top = (top + this.layout.backgroundOffset.top) + 'px';
        this.position.x = left + (this.originalSize.width / 2);
        this.position.y = top + (this.originalSize.height / 2);
    }

    setPos(x, y)
    {
        this.dom.style.left = (x - (this.originalSize.width / 2)) + 'px';
        this.dom.style.top = (y - (this.originalSize.height / 2)) + 'px';
        this.position.x = x;
        this.position.y = y;
    }

    setPosCenter()
    {
        this.setPos(BACKGROUND_CENTER_X, BACKGROUND_CENTER_Y);
    }

    setPosLeftTop()
    {
        let x = BACKGROUND_WIDTH / 6;
        let y = BACKGROUND_HEIGHT / 6 - 100;
        this.setPos(x, y);
    }

    setPosRightTop()
    {
        let x = BACKGROUND_WIDTH / 6 * 5;
        let y = BACKGROUND_HEIGHT / 6 - 100;
        this.setPos(x, y);
    }

    setPosLeftBottom()
    {
        let x = BACKGROUND_WIDTH / 6;
        let y = BACKGROUND_HEIGHT / 6 * 5 - 100;
        this.setPos(x, y);
    }

    setPosRightBottom()
    {
        let x = (BACKGROUND_WIDTH / 6 * 5);
        let y = BACKGROUND_HEIGHT / 6 * 5 - 100;
        this.setPos(x, y);
    }

    setPosOffset()
    {
        let x = this.parent.position.x + this.offset.x;
        let y = this.parent.position.y + this.offset.y;

        this.setPos(x, y);
    }
}