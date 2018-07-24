/**
 * 手前側のメインネットワークイメージ
 */
class NetworkImage
{
    constructor()
    {
        this.canvas = document.getElementById('network-image-canvas');
        this.context = this.canvas.getContext('2d');
    }

    changeWindowSize(left, top)
    {
        this.canvas.style.left = left;
        this.canvas.style.top = top;
    }

    scroll(mainScroll, top)
    {
        this.canvas.style.top = top - (mainScroll / 8) + 'px';
    }

    draw(items)
    {
        this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);

        this.context.save();

        this.context.strokeStyle = 'rgba(60, 90, 180, 0.5)';
        this.context.lineWidth = 1;

        // 孫から背景への線を描画
        Object.keys(items).forEach((key) => {
            items[key].drawChildToBackgroundBallLine(this.context);
        });

        this.context.restore();

        this.context.save();

        // アイテムを描画
        Object.keys(items).forEach((key) => {
            if (!items[key].isMain) {
                // メインから子へのラインを描画
                this.context.strokeStyle = 'rgba(255, 255, 255, 0.4)';
                this.context.lineWidth = 3;

                // 親から自分への線を引く
                this.context.beginPath();

                this.context.moveTo(items[key].parent.position.x, items[key].parent.position.y);
                this.context.lineTo(items[key].position.x, items[key].position.y);

                this.context.closePath();
                this.context.stroke();

                if (items[key].childBalls.length > 0) {
                    this.context.save();

                    this.context.strokeStyle = '#444';
                    this.context.lineWidth = 2;

                    // 自分から子への線を引く
                    items[key].childBalls.forEach((childBall)=>{
                        let x = items[key].position.x + childBall.offset.x;
                        let y = items[key].position.y + childBall.offset.y;

                        this.context.beginPath();

                        this.context.moveTo(items[key].position.x, items[key].position.y);
                        this.context.lineTo(x, y);

                        this.context.closePath();
                        this.context.stroke();

                        childBall.draw(this.context, x, y);
                    });

                    this.context.restore();
                }
            }

            // 自分のボールを描く
            let grad = this.context.createRadialGradient(items[key].position.x, items[key].position.y, 5, items[key].position.x, items[key].position.y, 10);

            grad.addColorStop(0,'white');
            grad.addColorStop(0.5,'rgba(255, 255, 255, 0.7)');
            grad.addColorStop(0.7,'rgba(255, 255, 255, 0.1)');
            grad.addColorStop(1,'rgba(50, 100, 170, 0)');

            this.context.fillStyle = grad;

            this.context.beginPath();
            this.context.arc(items[key].position.x, items[key].position.y, 10, 0, Math.PI * 2, true);
            this.context.fill();
        });

        this.context.restore();
    }
}