
class NetworkItem
{
    constructor(layout, data, parent)
    {
        this.data = data;
        this.layout = layout;
        this.dom = document.getElementById(data.id);
        this.name = data.id;
        this.position = {x: 0, y: 0};
        this.parent = parent;
        this.offset = {x: 0, y: 0};
        this.isMain = false;
        this.childBalls = [];
        this.animationStatus = null;

        // 幅と高さを設定
        this.originalSize = this.dom.getBoundingClientRect();
        // 幅と高さをセットしておかないと、拡大縮小アニメーションができない
        this.dom.style.width = this.originalSize.width + 'px';
        this.dom.style.height = this.originalSize.height + 'px';

        this.changePosition(data);

        // 子の位置決めのため、ここで位置確定
        this.setPosition();

        if (data.hasOwnProperty('childNum')) {
            this.setChildPosition(data.childNum);
        }
    }

    changePosition(data)
    {
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
        this.childBalls = [];

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

        for (i = 0; i < childNum; i++) {
            this.childBalls.push(new NetworkChildBall(this.layout, this, positions[i % (positions.length - 1)]));
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
        let minTop = (this.originalSize.height / 2) + 20;
        if (y < minTop) {
            y = minTop;
        }

        this.dom.style.left = (x - (this.originalSize.width / 2) + this.layout.backgroundOffset.left) + 'px';
        this.dom.style.top = (y - (this.originalSize.height / 2) + this.layout.backgroundOffset.top) + 'px';
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


    drawChildToBackgroundBallLine(ctx)
    {
        if (this.isMain) {
            return;
        }

        let x = 0;
        let y = 0;
        let scrollOffset = 0;
        if (this.layout.image.canvas.style.top && this.layout.background.canvas.style.top) {
            scrollOffset = (parseInt(this.layout.image.canvas.style.top) - parseInt(this.layout.background.canvas.style.top));
        }

        this.childBalls.forEach((child)=>{
            x = this.position.x + child.offset.x;
            y = this.position.y + child.offset.y;

            child.backgroundChildren.forEach((idx)=>{
                ctx.beginPath();

                ctx.moveTo(x, y);
                ctx.lineTo(BACKGROUND_CENTER_X + this.layout.background.balls[idx].x, BACKGROUND_CENTER_Y + this.layout.background.balls[idx].y - scrollOffset);

                ctx.closePath();
                ctx.stroke();
            });
        });
    }

    open()
    {
        this.dom.style.left = 0;
        this.dom.style.top = 0;
        this.dom.classList.add('opened');
    }

    close()
    {
        this.dom.classList.add('closed');
    }

    appear()
    {
        this.dom.classList.add('active');
        this.dom.classList.remove('closed');
        this.dom.classList.remove('opened');

        this.setPosition();
    }

    disappear()
    {
        this.dom.classList.remove('active');
        this.dom.classList.add('disposing');
    }

    moving()
    {
        this.dom.classList.add('moving');
    }

    dispose()
    {
        for (let i = 0; i < this.childBalls.length; i++) {
            this.childBalls[i].dispose();
            delete this.childBalls[i];
        }
        this.dom.parentNode.removeChild(this.dom);

        this.layout = null;
        this.dom = null;
        this.name = null;
        this.position = null;
        this.parent = null;
        this.offset = null;
        this.isMain = null;
        this.childBalls = null;
        this.originalSize = null;
        this.data = null;
    }

    getChildData(id)
    {
        for (let i = 0; i < this.data.mainMode.children.length; i++) {
            if (this.data.mainMode.children[i].id == id) {
                return this.data.mainMode.children[i];
            }
        }

        return null;
    }
}