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

    goTop(time, top)
    {
        if (time > 500) {
            this.canvas.style.top = top + 'px';
        } else {
            let now = parseInt(this.canvas.style.top);
            let distance = (now - top) * (time / 500);

            this.canvas.style.top = (now - distance) + 'px';
        }
    }

    clearRect()
    {
        this.context.clearRect(0, 0, this.canvas.width, this.canvas.height);
    }

    draw(itemManager)
    {
        this.clearRect();

        this.context.save();

        let act, chd, gchd, grad;

        // 現役ループ
        for (act = 0; act < itemManager.activeGeneration.length; act++) {
            let actItem = itemManager.activeGeneration[act];        // 現役
            let children = itemManager.activeGeneration[act].children;

            // 子ループ
            for (chd = 0; chd < children.length; chd++) {
                let chdItem = children[chd];        // 子

                // 現役から子への線を引く
                this.context.strokeStyle = 'rgba(255, 255, 255, 0.4)';
                this.context.lineWidth = 3;

                this.context.beginPath();

                this.context.moveTo(actItem.position.x, actItem.position.y);
                this.context.lineTo(chdItem.position.x, chdItem.position.y);

                this.context.closePath();
                this.context.stroke();

                if (chdItem.children.length > 0) {
                    // 孫がおる
                    // 孫ループ
                    for (gchd = 0; gchd < chdItem.children.length; gchd++) {
                        let gradItem = chdItem.children[gchd];
                        // 子から孫への線を引く

                        // 孫から背景への線を描く
                        this.context.strokeStyle = 'rgba(60, 90, 180, 0.5)';
                        this.context.lineWidth = 1;

                        // 孫から背景への線を描画
                        //Object.keys(items).forEach((key) => {
                        //items[key].drawChildToBackgroundBallLine(this.context);
                        //});



                        // 孫の球体を描く
                        grad = this.context.createRadialGradient(gradItem.position.x, gradItem.position.y, 2, gradItem.position.x, gradItem.position.y, 15);

                        grad.addColorStop(0,'white');
                        grad.addColorStop(1,'rgba(50, 100, 170, 0)');

                        ctx.fillStyle = grad;

                        ctx.beginPath();
                        ctx.arc(x, y, 5, 0, Math.PI * 2, true);
                        ctx.fill();
                    }
                } else {
                    // 孫いない
                    // 背景への線を描画
                }


                // 子の球体を描く
                grad = this.context.createRadialGradient(chdItem.position.x, chdItem.position.y, 5, chdItem.position.x, chdItem.position.y, 10);

                grad.addColorStop(0,'white');
                grad.addColorStop(0.5,'rgba(255, 255, 255, 0.7)');
                grad.addColorStop(0.7,'rgba(255, 255, 255, 0.1)');
                grad.addColorStop(1,'rgba(50, 100, 170, 0)');

                this.context.fillStyle = grad;

                this.context.beginPath();
                this.context.arc(chdItem.position.x, chdItem.position.y, 10, 0, Math.PI * 2, true);
                this.context.fill();
            }

            // 現役の球体を描く
            grad = this.context.createRadialGradient(actItem.position.x, actItem.position.y, 5, actItem.position.x, actItem.position.y, 10);

            grad.addColorStop(0,'white');
            grad.addColorStop(0.5,'rgba(255, 255, 255, 0.7)');
            grad.addColorStop(0.7,'rgba(255, 255, 255, 0.1)');
            grad.addColorStop(1,'rgba(50, 100, 170, 0)');

            this.context.fillStyle = grad;

            this.context.beginPath();
            this.context.arc(actItem.position.x, actItem.position.y, 10, 0, Math.PI * 2, true);
            this.context.fill();

            if (act > 0) {
                // TODO 現役同士で線をつなぐ？
            }
        }

        this.context.restore();
    }
}