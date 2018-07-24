class NetworkItem
{
    constructor(layout, data, parent)
    {
        this.layout = layout;
        this.dom = document.getElementById(data.id);
        this.name = data.id;
        this.position = {x: 0, y: 0};
        this.parent = parent;
        this.offset = {x: 0, y: 0};
        this.isMain = false;
        this.childBalls = [];

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

        // 子の位置決めのため、ここで位置確定
        this.setPosition();

        if (data.hasOwnProperty('childNum')) {
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

            for (i = 0; i < data.childNum; i++) {
                this.childBalls.push(new NetworkChildBall(layout, this, positions[i]));
            }
        }

        // 幅と高さを設定

        let size = this.dom.getBoundingClientRect();
        this.dom.style.width = size.width + 'px';
        this.dom.style.height = size.height + 'px';
    }

    setPosRandom()
    {
        let minLeft = 0;
        let maxLeft = this.layout.width() - minLeft;
        let minTop = 0;
        let maxTop = this.layout.height() - minTop;

        let left = Math.floor(Math.random()*(maxLeft - minLeft) + minLeft);
        let top = Math.floor(Math.random()*(maxTop - minTop) + minTop);

        this.dom.style.left = (left + this.layout.backgroundOffset.left) + 'px';
        this.dom.style.top = (top + this.layout.backgroundOffset.top) + 'px';
        this.position.x = left + (this.dom.offsetWidth / 2);
        this.position.y = top + (this.dom.offsetHeight / 2);
    }

    setPos(x, y)
    {
        let minTop = (this.dom.offsetHeight / 2) + 20;
        if (y < minTop) {
            y = minTop;
        }

        this.dom.style.left = (x - (this.dom.offsetWidth / 2) + this.layout.backgroundOffset.left) + 'px';
        this.dom.style.top = (y - (this.dom.offsetHeight / 2) + this.layout.backgroundOffset.top) + 'px';
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

    draw(ctx)
    {
        if (!this.isMain) {
            // メインから子へのラインを描画
            ctx.strokeStyle = 'rgba(255, 255, 255, 0.4)';
            ctx.lineWidth = 3;

            // 親から自分への線を引く
            ctx.beginPath();

            ctx.moveTo(this.parent.position.x, this.parent.position.y);
            ctx.lineTo(this.position.x, this.position.y);

            ctx.closePath();
            ctx.stroke();

            if (this.childBalls.length > 0) {
                ctx.save();

                ctx.strokeStyle = '#444';
                ctx.lineWidth = 2;

                // 自分から子への線を引く
                this.childBalls.forEach((childBall)=>{
                    let x = this.position.x + childBall.offset.x;
                    let y = this.position.y + childBall.offset.y;

                    ctx.beginPath();

                    ctx.moveTo(this.position.x, this.position.y);
                    ctx.lineTo(x, y);

                    ctx.closePath();
                    ctx.stroke();

                    childBall.draw(ctx, x, y);
                });

                ctx.restore();
            }
        }

        // 自分のボールを描く
        let grad = ctx.createRadialGradient(this.position.x, this.position.y, 5, this.position.x, this.position.y, 10);

        grad.addColorStop(0,'white');
        grad.addColorStop(0.5,'rgba(255, 255, 255, 0.7)');
        grad.addColorStop(0.7,'rgba(255, 255, 255, 0.1)');
        grad.addColorStop(1,'rgba(50, 100, 170, 0)');

        ctx.fillStyle = grad;

        ctx.beginPath();
        ctx.arc(this.position.x, this.position.y, 10, 0, Math.PI * 2, true);
        ctx.fill();
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
}